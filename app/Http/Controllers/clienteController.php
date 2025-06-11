<?php

namespace App\Http\Controllers;

use App\Enums\TipoPersonaEnum;
use App\Http\Requests\StorePersonaRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use App\Models\Documento;
use App\Models\Persona;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Log;
use Throwable;

class clienteController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-cliente|crear-cliente|editar-cliente|eliminar-cliente', ['only' => ['index']]);
        $this->middleware('permission:crear-cliente', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-cliente', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-cliente', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $clientes = Cliente::with('persona.documento')->latest()->get();
        return view('cliente.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $documentos = Documento::all();
        $optionsTipoPersona = TipoPersonaEnum::cases();
        return view('cliente.create', compact('documentos', 'optionsTipoPersona'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonaRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $persona = Persona::create($request->validated());
            $persona->cliente()->create([]);
            DB::commit();

            ActivityLogService::log('Creacion de cliente','Clientes', $request->validated());

            return redirect()->route('clientes.index')->with('success', 'Cliente registrado');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Error al crear un cliente', ['error' => $e->getMessage()]);

            return redirect()->route('clientes.index')->with('error', 'Error al registrar el cliente');
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
    public function edit(Cliente $cliente): View
    {
        $cliente->load('persona.documento');
        $documentos = Documento::all();
        return view('cliente.edit', compact('cliente', 'documentos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente): RedirectResponse
    {
        try{
            $cliente->persona->update($request->validated());
            ActivityLogService::log('Edicion de cliente', 'Clientes', $request->validated());
            return redirect()->route('clientes.index')->with('success','Cliente editado');

        }catch(Throwable $e){
            Log::error('Error al editar un cliente', ['error' => $e->getMessage()]);
            return redirect()->route('clientes.index')->with('error', 'Error al editar el cliente');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        try{
            $persona = Persona::findOrFail($id);

            $nuevoEstado = $persona->estado == 1 ? 0 : 1; 
            $persona->update(['estado' => $nuevoEstado]);
            $message = $nuevoEstado == 1 ? 'Cliente restaurado' : 'Cliente eliminado';

            ActivityLogService::log($message, 'Clientes', [
                'persona_id' => $id,
                'estado' => $nuevoEstado
            ]);
            return redirect()->route('clientes.index')->with('success', $message);

        }catch(Throwable $e){
            Log::error('Error al eliminar/restaurar un cliente', ['error' => $e->getMessage()]);
            return redirect()->route('clientes.index')->with('error', 'Algo salió mal');
        }
    }
}
