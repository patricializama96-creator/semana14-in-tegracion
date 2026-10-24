<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventoTransaccionController extends Controller
{
    public function index()
    {
        $eventos = [
            ['id' => 1, 'transaccion_id' => 1, 'estado_anterior' => 'Iniciada', 'estado_nuevo' => 'Procesando'],
            ['id' => 2, 'transaccion_id' => 1, 'estado_anterior' => 'Procesando', 'estado_nuevo' => 'Aprobada'],
        ];

        return $eventos;
    }
}
