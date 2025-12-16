<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invesmart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            
        }   

        img{
            width: 40%;
        }
        .card {
            background-color: #ffffff;
            padding: 3rem 2rem;
            border-radius: 1rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.42);
            max-width: 400px;
            width: 100%;
            text-align: center;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .icon {
            width: 130px;
            height: 130px;
            margin: 0 auto 1.5rem;
            animation: float 2s ease-in-out infinite;
            color: #f59e0b;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .title {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 2rem;
        }

        .btn {
            display: inline-block;
            width: 140px;
            padding: 0.75rem 0;
            margin: 0.5rem;
            font-weight: 600;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-login {
            background-color: var(--secondary-color);
            color: #fff;
        }

        .btn-login:hover {
            background-color: #4244DD;
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(0,0,0,0.15);
        }

        .btn-register {
            background-color: var(--terciary-color);
            color: #fff;
        }

        .btn-register:hover {
            background-color: #dd8d8dff;
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <img src="images/login.jpg" alt="inverison">
    <div class="card">
        <h1 class="title">Bienvenido a InveSmart</h1>
        <div>
            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="btn btn-login">Iniciar Sesión</a>
            @endif
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-register">Registrarse</a>
            @endif
        </div>
    </div>

</body>
</html>
