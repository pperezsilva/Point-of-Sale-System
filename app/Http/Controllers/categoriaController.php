<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCaracteristicaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Caracteristica;
use App\Models\Categoria;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Services\ActivityLogService;
use Throwable;
use Illuminate\Support\Facades\Log;

class categoriaController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-categoria|crear-categoria|editar-categoria|eliminar-categoria', ['only' => ['index']]);
        $this->middleware('permission:crear-categoria', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-categoria', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-categoria', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categorias = Categoria::with('caracteristica')->latest()->get();

        return view('categoria.index', ['categorias' => $categorias]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('categoria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCaracteristicaRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->categoria()->create([]);
            DB::commit();
            ActivityLogService::log('Creacion de categoria', 'Categorias', $request->validated());

            return redirect()->route('categorias.index')->with('success', 'Categoría registrada');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error("Error al crear la categoría", ['error' => $e->getMessage()]);
            return redirect()->route('categorias.index')->with('error', 'Error al registrar la categoría');
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
    public function edit(Categoria $categoria): View
    {
        return view('categoria.edit', ['categoria' => $categoria]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria): RedirectResponse
    {
        try {
            $categoria->caracteristica->update($request->validated());
            $categoria->update($request->validated());

            ActivityLogService::log('Edición de categoría', 'Categorías', $request->validated());

            return redirect()->route('categorias.index')->with('success', 'Categoría editada');

        } catch (Exception $e) {
            Log::error("Error al editar la categoría", ['error' => $e->getMessage()]);

            return redirect()->route('categorias.index')->with('error', 'Error al editar la categoría');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        try{
            $categoria = Categoria::find($id);

            $nuevoEstado = $categoria->caracteristica->estado == 1 ? 0 : 1;
            $categoria->caracteristica->update(['estado' => $nuevoEstado]);
            $message = $nuevoEstado == 1 ? 'Categoría restaurada' : 'Categoría eliminada';

            ActivityLogService::log($message, 'Categorías', [
                'categoria_id' => $id,
                'estado' => $nuevoEstado
            ]);

            return redirect()->route('categorias.index')->with('success', $message);

        }catch (Throwable $e) {
            Log::error("Error al eliminar la categoría", ['error' => $e->getMessage()]);
            return redirect()->route('categorias.index')->with('error', 'Error al eliminar la categoría');
        }
    }
}
