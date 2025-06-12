@extends('layouts.app')

@section('title','Editar presentación')

@push('css')
<style>
    #descripcion {
        resize: none;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar Presentación</h1>
    
    <x-breadcrumb.template>
        <x-breadcrumb.item :href="route('panel')" content="Inicio"/>
        <x-breadcrumb.item :href="route('presentaciones.index')" content="Presentaciones"/>
        <x-breadcrumb.item active='true' content="Editar presentación"/>
    </x-breadcrumb.template>

    <x-forms.template :action="route('presentaciones.update',['presentacione'=>$presentacione])" method='post' patch='true'>
        
        <div class="row g-4">

            <div class="col-md-6">
                <x-forms.input id="nombre" required="true" defaultValue="{{$presentacione->caracteristica->nombre}}"/>
            </div>

            <div class="col-md-6">
                <x-forms.input id="sigla" required="true" defaultValue="{{$presentacione->sigla}}"/>
            </div>

            <div class="col-12">
                <x-forms.textarea id="descripcion" defaultValue="{{$presentacione->caracteristica->descripcion}}"/>
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