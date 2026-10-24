@extends('layouts.app')

@section('titulo', 'Crear cuenta — TaskBoard')

@section('contenido')
<h1>Crear cuenta</h1>

<form method="POST" action="{{ route('registro.store') }}" class="auth">
    @csrf

    <label>Nombre</label>
    <input type="text" name="name" value="{{ old('name') }}">
    @error('name') <span class="error">{{ $message }}</span> @enderror

    <label>Correo</label>
    <input type="email" name="email" value="{{ old('email') }}">
    @error('email') <span class="error">{{ $message }}</span> @enderror

    <label>Contraseña</label>
    <input type="password" name="password">
    @error('password') <span class="error">{{ $message }}</span> @enderror

    <label>Confirmar contraseña</label>
    <input type="password" name="password_confirmation">

    <button type="submit">Crear cuenta</button>
</form>
@endsection
