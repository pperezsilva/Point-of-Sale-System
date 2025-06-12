@extends('layouts.app')

@section('title','Editar marca')

@push('css')
<style>
    #descripcion {
        resize: none;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar Marca</h1>
    
    <x-breadcrumb.template>
        <x-breadcrumb.item :href="route('panel')" content="Inicio"/>
        <x-breadcrumb.item :href="route('marcas.index')" content="Marcas"/>
        <x-breadcrumb.item active='true' content="Editar marca"/>
    </x-breadcrumb.template>

    <x-forms.template :action="route('marcas.update',['marca'=>$marca])" method='post' patch='true'>

        <div class="row g-4">

            <div class="col-md-6">
                <x-forms.input id="nombre" defaultValue="{{$marca->caracteristica->nombre}}"/>
            </div>

            <div class="col-12">
                <x-forms.textarea id="descripcion" defaultValue="{{$marca->caracteristica->descripcion}}"/>
            </div>

        </div>

        <x-slot name="footer">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <button type="reset" class="btn btn-secondary">Reiniciar</button>
        </x-slot>
        
    </x-forms.template>

</div>
@endsection

@push('js')

@endpush