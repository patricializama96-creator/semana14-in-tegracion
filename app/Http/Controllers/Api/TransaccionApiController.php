<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuardarTransaccionRequest;
use App\Http\Resources\TransaccionResource;
use App\Models\Transaccion;
use Illuminate\Http\Request;

class TransaccionApiController extends Controller
{
    public function index(Request $request)
    {
        // Reto: filtro opcional ?estado=Completada
        $estado = $request->query('estado');

        // Solo transacciones de los comercios del dueño del token
        $transacciones = Transaccion::whereHas('comercio', fn ($q) =>
                $q->where('user_id', $request->user()->id))
            ->when($estado, fn ($q) => $q->where('estado', $estado))
            ->latest()
            ->get();

        return TransaccionResource::collection($transacciones);
    }

    public function show(Request $request, Transaccion $transaccion)
    {
        $this->autorizar($request, $transaccion);

        return new TransaccionResource($transaccion);
    }

    public function store(GuardarTransaccionRequest $request)
    {
        $datos = $request->validated();
        $datos['estado'] = $request->input('estado', 'Iniciada');

        $transaccion = Transaccion::create($datos);

        return (new TransaccionResource($transaccion))
            ->response()
            ->setStatusCode(201);
    }

    public function destroy(Request $request, Transaccion $transaccion)
    {
        $this->autorizar($request, $transaccion);

        $transaccion->delete();

        return response()->noContent(); // 204
    }

    private function autorizar(Request $request, Transaccion $t): void
    {
        // 404 (no 403): para otro usuario, el recurso "no existe"
        abort_unless($t->comercio->user_id === $request->user()->id, 404);
    }
}
