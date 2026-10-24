<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Sandbox de formulario</title></head>
<body>
    <h1>Laboratorio de formularios</h1>

    <form action="/practica/enviar" method="POST">
        @csrf
        <input name="cliente_nombre">
        <button type="submit">Enviar (modo prueba)</button>
    </form>
</body>
</html>
