<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Iniciar sesión - {{ config('app.name', 'SGDEA') }}</title>
    </head>
    <body>
        <main>
            <h1>Iniciar sesión</h1>

            @if ($errors->any())
                <div role="alert">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <div>
                    <label for="correo">Correo electrónico</label>
                    <input
                        id="correo"
                        name="correo"
                        type="email"
                        value="{{ old('correo') }}"
                        autocomplete="username"
                        required
                        autofocus
                    >
                </div>

                <div>
                    <label for="password">Contraseña</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <button type="submit">Ingresar</button>
            </form>
        </main>
    </body>
</html>
