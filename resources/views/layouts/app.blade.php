<!DOCTYPE html>
{{-- Semana 7 · Blade — Layout maestro --}}
{{-- Toda vista hija hereda esta estructura con @extends('layouts.app') --}}
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Pasarela de Pagos — TaskBoard')</title>

    <style>
        :root {
            --navy: #0B2E59;
            --gold: #F2A900;
            --ink: #13233D;
            --gray: #5B6B85;
            --line: #D7E1EF;
            --bg: #F5F8FC;
            --green: #1E7E52;
            --red: #C23B32;
        }
        * { box-sizing: border-box; }
        body {
            font-family: -apple-system, "Segoe UI", Calibri, Arial, sans-serif;
            background: var(--bg);
            color: var(--ink);
            margin: 0;
        }
        nav {
            background: var(--navy);
            color: #fff;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }
        nav .tag {
            background: var(--gold);
            color: var(--navy);
            padding: 0.2rem 0.7rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: bold;
        }
        main {
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }
        h1 { color: var(--navy); }
        h2 { color: var(--navy); font-size: 1.1rem; margin-top: 2rem; }
        .card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 1rem 1.25rem;
            margin-bottom: 0.75rem;
        }
        .card a { color: var(--navy); font-weight: bold; text-decoration: none; }
        .card a:hover { text-decoration: underline; }
        .meta { color: var(--gray); font-size: 0.9rem; }
        .badge {
            display: inline-block;
            padding: 0.2rem 0.7rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: bold;
            color: #fff;
        }
        .badge.verde { background: var(--green); }
        .badge.rojo { background: var(--red); }
        .badge.amarillo { background: var(--gold); color: var(--navy); }
        .badge.gris { background: #9AAAC4; }
        footer {
            text-align: center;
            color: var(--gray);
            font-size: 0.85rem;
            padding: 2rem 0;
        }
        ul.comercios { list-style: none; padding: 0; }

        /* ── Autenticación (Semana 12) ── */
        .nav-derecha { display: flex; align-items: center; gap: 1rem; }
        .btn-salir {
            background: transparent; color: #fff; border: 1px solid #fff;
            border-radius: 6px; padding: 0.25rem 0.8rem; cursor: pointer;
            font-weight: bold;
        }
        .btn-salir:hover { background: #fff; color: var(--navy); }

        form.auth {
            max-width: 420px; background: #fff; border: 1px solid var(--line);
            border-radius: 10px; padding: 1.25rem 1.5rem;
        }
        form.auth label { display: block; margin-top: 0.9rem; font-weight: bold; }
        form.auth input[type="text"],
        form.auth input[type="email"],
        form.auth input[type="password"] {
            width: 100%; padding: 0.5rem; margin-top: 0.3rem;
            border: 1px solid var(--line); border-radius: 6px;
        }
        form.auth button[type="submit"] {
            margin-top: 1.25rem; background: var(--navy); color: #fff; border: 0;
            border-radius: 6px; padding: 0.6rem 1.2rem; font-weight: bold; cursor: pointer;
        }
        .error { color: var(--red); font-size: 0.85rem; display: block; margin-top: 0.25rem; }
    </style>
</head>
<body>
    <nav>
        <a href="{{ route('comercios.index') }}">Pasarela de Pagos · TaskBoard</a>

        <div class="nav-derecha">
            @auth
                <span>Hola, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="btn-salir">Salir</button>
                </form>
            @endauth

            @guest
                <a href="{{ route('login') }}">Entrar</a>
                <a href="{{ route('registro') }}">Registrarse</a>
            @endguest

            <span class="tag">UPED · Integración de Sistemas</span>
        </div>
    </nav>

    @if (session('mensaje'))
        <div style="max-width:900px; margin:1rem auto 0; padding:0 1.5rem;">
            <div style="background:#EAF6EE; color:var(--green);
                padding:0.75rem 1.25rem; border-radius:10px;
                border:1px solid var(--line); font-weight:bold;">
                ✅ {{ session('mensaje') }}
            </div>
        </div>
    @endif

    <main>
        @yield('contenido')
    </main>

    <footer>
        &copy; {{ date('Y') }} UPED — Integración de Sistemas
    </footer>
</body>
</html>
