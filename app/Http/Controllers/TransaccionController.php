<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuardarTransaccionRequest;
use App\Models\Comercio;
use App\Models\Transaccion;
use Illuminate\Http\Request;

class TransaccionController extends Controller
{
    // Semana 9: formulario "Nueva transacción" de un comercio
    public function create(Request $request, Comercio $comercio)
    {
        abort_unless($comercio->user_id === $request->user()->id, 404);

        return view('transacciones.create', compact('comercio')); // AJUSTAR nombre de vista
    }

    public function store(GuardarTransaccionRequest $request)
    {
        $datos = $request->validated();
        $datos['estado'] = 'Iniciada';

        $transaccion = Transaccion::create($datos);

        return redirect()
            ->route('comercios.show', $transaccion->comercio_id)
            ->with('exito', 'Transacción creada.'); // AJUSTAR clave de mensaje flash
    }

    // Semana 11 (jueves): editar y eliminar
    public function edit(Request $request, Transaccion $transaccion)
    {
        $this->autorizar($request, $transaccion);

        return view('transacciones.edit', compact('transaccion')); // AJUSTAR nombre de vista
    }

    public function update(GuardarTransaccionRequest $request, Transaccion $transaccion)
    {
        $this->autorizar($request, $transaccion);

        $transaccion->update($request->validated());

        return redirect()
            ->route('comercios.show', $transaccion->comercio_id)
            ->with('exito', 'Transacción actualizada.');
    }

    public function destroy(Request $request, Transaccion $transaccion)
    {
        $this->autorizar($request, $transaccion);

        $comercioId = $transaccion->comercio_id;
        $transaccion->delete();

        return redirect()
            ->route('comercios.show', $comercioId)
            ->with('exito', 'Transacción eliminada.');
    }

    // Semana 11 (viernes): mover estado según Transaccion::TRANSICIONES
    public function moverEstado(Request $request, Transaccion $transaccion, string $estado)
    {
        $this->autorizar($request, $transaccion);

        abort_unless($transaccion->puedeMoverseA($estado), 422, 'Transición no permitida.');

        $transaccion->update(['estado' => $estado]);

        // TODO: aquí iba el registro en EventoTransaccion (no sé sus columnas)

        return back()->with('exito', "Estado cambiado a {$estado}.");
    }

    private function autorizar(Request $request, Transaccion $t): void
    {
        abort_unless($t->comercio->user_id === $request->user()->id, 404);
    }
}
