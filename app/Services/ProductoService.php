<?php

namespace App\Services;

use App\Models\Producto;
use Illuminate\Support\Facades\Storage;

class ProductoService{
    public function crearProducto(array $data): Producto
    {
        //Tabla producto
        $producto = Producto::create([
            'codigo' => $data['codigo'],
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'img_path' => isset($data['img_path']) && $data['img_path']
                ? $this->handleUploadImage($data['img_path'])
                : null,
            'marca_id' => $data['marca_id'],
            'categoria_id' => $data['categoria_id'],
            'presentacione_id' => $data['presentacione_id']
        ]);

        return $producto;
    }

    public function editarProducto(array $data, Producto $producto): Producto
    {
        $producto->update([
            'codigo' => $data['codigo'],
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'img_path' => isset($data['img_path']) && $data['img_path']
                ? $this->handleUploadImage($data['img_path'], $producto->img_path)
                : $producto->img_path,
            'marca_id' => $data['marca_id'],
            'categoria_id' => $data['categoria_id'],
            'presentacione_id' => $data['presentacione_id']
        ]);

        return $producto;
    }

    //Guarda imagen en el Storage
    private function handleUploadImage($image, string $img_path = null): string
    {
        if($img_path){
            $relative_path = str_replace('storage/', '', $img_path);

            if (Storage::disk('public')->exists($relative_path)) {
                Storage::disk('public')->delete($relative_path);
            }
        }

        $name = uniqid() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('productos', $name, 'public');
        //$path = 'storage/' .$image->storeAs('productos', $name);
        return 'storage/' . $path;
    }
}