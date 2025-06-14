@extends('layouts.app')

@section('title','Editar Producto')

@push('css')
<style>
    #descripcion {
        resize: none;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar Producto</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('productos.index')}}">Productos</a></li>
        <li class="breadcrumb-item active">Editar producto</li>
    </ol>

    <div class="card text-bg-light">
        <form action="{{route('productos.update',['producto'=>$producto])}}" method="post" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="card-body">

                <div class="row g-4">

                    <!----Codigo---->
                        <div class="col-md-6">
                            <label for="codigo" class="form-label">Código:</label>
                            <input type="text" name="codigo" id="codigo" class="form-control" value="{{old('codigo',$producto->codigo)}}">
                            @error('codigo')
                            <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>

                        <div class ="col-md-6">
                            <p class="form-label">Codigo de barras:</p>

                            <?php
                            require base_path('vendor/autoload.php');
                            $codigo = $producto->codigo;
                            $generator = new Picqer\Barcode\BarcodeGeneratorPNG();

                            echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($codigo, $generator::TYPE_EAN_13)) . '">';
                            ?>
                        </div> 

                    <!---Nombre---->
                    <div class="col-12">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre',$producto->nombre)}}">
                        @error('nombre')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <!---Descripción---->
                    <div class="col-12">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea name="descripcion" id="descripcion" rows="3" class="form-control">{{old('descripcion',$producto->descripcion)}}</textarea>
                        @error('descripcion')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                
                </div>

                <br>

                <div class="row g-4">

                    <div class="col-md-6">

                        <div class="row g-4">

                            <!---Imagen---->
                            <div class="col-12">
                                <label for="img_path" class="form-label">Imagen:</label>
                                <input type="file" name="img_path" id="img_path" class="form-control" accept="image/*">
                                @error('img_path')
                                <small class="text-danger">{{'*'.$message}}</small>
                                @enderror
                            </div>

                            <!---Marca---->
                            <div class="col-12">
                                <label for="marca_id" class="form-label">Marca:</label>
                                <select data-size="4"
                                    title="Seleccione una marca" 
                                    data-live-search="true" 
                                    name="marca_id" 
                                    id="marca_id" 
                                    class="form-control selectpicker show-tick">
                                    <option value="">No tiene marca</option>
                                    @foreach ($marcas as $item)
                                    <option value="{{$item->id}}"
                                        {{ $producto->marca && $producto->marca_id == $item_id || old('marca_id') == $item->id ? 'selected' : '' }}>
                                        {{$item->nombre}}
                                    </option>
                                    @endforeach
                                </select>
                                @error('marca_id')
                                <small class="text-danger">{{'*'.$message}}</small>
                                @enderror
                            </div>

                            <!---Presentaciones---->
                            <div class="col-12">
                                <label for="presentacione_id" class="form-label">Presentación:</label>
                                <select data-size="4" 
                                    title="Seleccione una presentación" 
                                    data-live-search="true" 
                                    name="presentacione_id" 
                                    id="presentacione_id" 
                                    class="form-control selectpicker show-tick">
                                    @foreach ($presentaciones as $item)
                                    <option value="{{$item->id}}"
                                        {{ $producto->presentaciones && $producto->presentacione_id == $item_id || old('presentacione_id') == $item->id ? 'selected' : '' }}>
                                        {{$item->nombre}}
                                    </option>
                                    @endforeach
                                </select>
                                @error('presentacione_id')
                                <small class="text-danger">{{'*'.$message}}</small>
                                @enderror
                            </div>

                            <!---Categorías---->
                            <div class="col-12">
                                <label for="categorias" class="form-label">Categorías:</label>
                                <select data-size="4" 
                                    title="Seleccione las categorías" 
                                    data-live-search="true" 
                                    name="categoria_id" 
                                    id="categoria_id" 
                                    class="form-control selectpicker show-tick">
                                    <option value="">No tiene categorías</option>
                                    @foreach ($categorias as $item)
                                    <option value="{{$item->id}}"
                                        {{ $producto->categorias && $producto->categoria_id == $item_id || old('categoria_id') == $item->id ? 'selected' : '' }}>
                                        {{$item->nombre}}
                                    </option>
                                    @endforeach
                                </select>
                                @error('categorias')
                                <small class="text-danger">{{'*'.$message}}</small>
                                @enderror
                            </div>
                        </div>

                        
                    </div>

                    <div class="col-md-6">
                        <p>Imagen del producto</p>
                        <img id="imgDefault" 
                        src="{{ $producto->img_path ? asset($producto->img_path) : asset('assets/img/imgIcon.png') }}"
                        class="img-fluid img-thumbnail" 
                        style="max-width: 50%; height: auto;">
                        
                        <img id="imgPreview" src=""  alt="Ha cargado un archivo no compatible" style="display: none;">
                    </div>

                    
                </div>

            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="reset" class="btn btn-secondary">Reiniciar</button>
            </div>
        </form>
    </div>



</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script>
    const inputImage = document.getElementById('img_path');
    const imgPreview = document.getElementById('imgPreview');
    const imgDefault = document.getElementById('imgDefault');

    inputImage.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                imgPreview.src = e.target.result;
                imgPreview.style.display = 'block';
                imgDefault.style.display = 'none';
            }

            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
@endpush