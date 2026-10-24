@extends('layouts.app')

@section('titulo', 'Iniciar sesión — TaskBoard')

@section('contenido')
<h1>Iniciar sesión</h1>

<form method="POST" action="{{ route('login.attempt') }}" class="auth">
    @csrf

    <label>Correo</label>
    <input type="email" name="email" value="{{ old('email') }}">
    @error('email') <span class="error">{{ $message }}</span> @enderror

    <label>Contraseña</label>
    <input type="password" name="password">

    <label><input type="checkbox" name="recordar"> Recordarme</label>

    <button type="submit">Entrar</button>
</form>
@endsection
