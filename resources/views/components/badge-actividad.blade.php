{{-- Semana 7 · Blade — Componente reutilizable --}}
{{-- Uso: <x-badge-actividad :totalTransacciones="$comercio->transacciones_count" /> --}}
@props(['totalTransacciones'])

@if ($totalTransacciones == 0)
    <span class="badge gris">Sin actividad</span>
@elseif ($totalTransacciones <= 2)
    <span class="badge verde">Activo</span>
@else
    <span class="badge" style="background-color: #d4af37; color: #4a3800;">Comercio estrella</span>
@endif
