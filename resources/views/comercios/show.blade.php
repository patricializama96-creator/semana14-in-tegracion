{{-- Semana 7 · Blade --}}
{{-- resources/views/comercios/show.blade.php --}}
@extends('layouts.app')

@section('titulo', $comercio->nombre_comercio)

@section('contenido')
    <p><a href="{{ route('comercios.index') }}">&larr; Volver a comercios</a></p>

    <h1>{{ $comercio->nombre_comercio }}</h1>
    <p class="meta">
        Rubro: {{ $comercio->rubro }}
        &middot;
        Teléfono: {{ $comercio->telefono ?? 'Sin teléfono registrado' }}
    </p>

    {{-- Semana 11: mensajes de éxito y error --}}
    @if (session('mensaje'))
        <div style="background:#d1fae5; padding:10px; border-radius:6px; margin-bottom:12px;">
            ✓ {{ session('mensaje') }}
        </div>
    @endif

    @if (session('error'))
        <div style="background:#fee2e2; padding:10px; border-radius:6px; margin-bottom:12px;">
            ✕ {{ session('error') }}
        </div>
    @endif

    <a href="{{ route('transacciones.create', $comercio) }}"
       style="display:inline-block; background:var(--navy); color:#fff;
              padding:0.5rem 1rem; border-radius:8px; text-decoration:none;
              font-weight:bold; margin:0.5rem 0 1rem;">
        + Nueva transacción
    </a>

    <h2>Transacciones</h2>

    <x-resumen-actividad :total="$comercio->transacciones->count()" />

    @forelse ($comercio->transacciones as $transaccion)
        <div class="card">
            <strong>${{ number_format($transaccion->monto, 2) }}</strong>
            — {{ $transaccion->cliente_nombre }}
            <x-badge-estado :estado="$transaccion->estado" />

            {{-- Semana 11: Editar / Eliminar / Mover estado --}}
            <div style="margin-top:8px; display:flex; gap:12px; align-items:center;">
                <a href="{{ route('transacciones.edit', $transaccion) }}">Editar</a>

                <form action="{{ route('transacciones.destroy', $transaccion) }}"
                      method="POST" style="display:inline"
                      onsubmit="return confirm('¿Eliminar esta transacción? Esta acción no se puede deshacer.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar</button>
                </form>

                {{-- Semana 11 (viernes): botones de mover estado --}}
                @if ($transaccion->estado === 'Iniciada')
                    <form action="{{ route('transacciones.mover', [$transaccion, 'Completada']) }}"
                          method="POST" style="display:inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit">Marcar Completada</button>
                    </form>

                    <form action="{{ route('transacciones.mover', [$transaccion, 'Fallida']) }}"
                          method="POST" style="display:inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit">Marcar Fallida</button>
                    </form>
                @endif

                @if ($transaccion->estado === 'Fallida')
                    <form action="{{ route('transacciones.mover', [$transaccion, 'Iniciada']) }}"
                          method="POST" style="display:inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit">Reintentar</button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <p>Sin transacciones</p>
    @endforelse
@endsection
