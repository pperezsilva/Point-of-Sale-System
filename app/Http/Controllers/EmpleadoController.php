<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmpleadoRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Empleado;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleados = Empleado::latest()->get();
        return view('empleado.index', compact('empleados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('empleado.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmpleadoRequest $request): RedirectResponse
    {
        try {
            $empleado = new Empleado();
            $request->merge([
                'img_path' => isset($request->img)
                    ? $empleado->handleUploadImage($request->img)
                    : null
            ]);
            $empleado->create($request->all());

            ActivityLogService::log('Registro de empleado', 'Empleados', $request->validated());
            return redirect()->route('empleados.index')->with('success', 'Empleado registrado');

        } catch (Throwable $e) {
            Log::error('Error al registrar un empleado', ['error' => $e->getMessage()]);
            return redirect()->route('empleados.index')->with('error', 'Error al registrar el empleado');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empleado $empleado): View
    {
        return view('empleado.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreEmpleadoRequest $request, Empleado $empleado): RedirectResponse
    {
        try {
            $request->merge([
                'img_path' => isset($request->img)
                    ? $empleado->handleUploadImage($request->img, $empleado->img_path)
                    : $empleado->img_path,
            ]);
            $empleado->update($request->all());
            ActivityLogService::log('Edición de empleado', 'Empleados', $request->validated());
            return redirect()->route('empleados.index')->with('success', 'Empleado editado');
        } catch (Throwable $e) {
            Log::error('Error al editar un empleado', ['error' => $e->getMessage()]);
            return redirect()->route('empleados.index')->with('error', 'Error al editar el empleado');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        try {
            $empleado = Empleado::findOrFail($id);

            ActivityLogService::log('Eliminación de empleado', 'Empleados', [
                'empleado' => $empleado
            ]);
            $empleado->delete();
            return redirect()->route('empleados.index')->with('success', 'Empleado eliminado');
        } catch (Throwable $e) {
            Log::error('Error al eliminar un empleado', ['error' => $e->getMessage()]);
            return redirect()->route('empleados.index')->with('error', 'Error al eliminar el empleado');
        }
    }
}
