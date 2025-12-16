<x-app-layout>
    <div class="container mx-auto py-6">

        @php
            // Si el usuario está autenticado, calculamos los totales rápidos aquí
            $ahorros = 0;
            if (\Illuminate\Support\Facades\Auth::check()) {
                $userId = \Illuminate\Support\Facades\Auth::id();
                $movimientos = \App\Models\Movimiento::where('user_id', $userId)->get();
                $ingresos = $movimientos->where('tipo', 'ingreso')->sum('cantidad');
                $gastos = $movimientos->where('tipo', 'gasto')->sum('cantidad');
                $ahorros = $ingresos - $gastos;
            }
        @endphp

        <div class="welcome-card">
            <div class="welcome-left">
                <h1 class="title">
                    Bienvenido{{ \Illuminate\Support\Facades\Auth::check() ? ', ' . \Illuminate\Support\Facades\Auth::user()->name : '' }}
                </h1>
                <p class="subtitle">Resumen rápido de tus finanzas</p>

                <div class="small-panel">
                    <span class="label">Ahorros</span>
                    @if ($ahorros > 0)
                        <div class="amount positive ">€{{ number_format($ahorros, 2) }}</div>
                    @elseif ($ahorros === 0)
                        <div class="amount neutral" text>€{{ number_format($ahorros, 2) }}</div>
                    @elseif ($ahorros < 0)
                        <div class="amount negative">€{{ number_format($ahorros, 2) }}</div>
                    @endif
                </div>
                <div class="actions">
                    @auth
                        <a href="{{ route('finanzas.index') }}" class="btn btn-primary">Ir a mi panel financiero</a>
                    @endauth
                </div>
            </div>

            <div class="welcome-right">
                <div class="info-card">
                    <h3>Estado rápido</h3>
                    <ul>
                        <li><strong>Ingresos:</strong> €{{ isset($ingresos) ? number_format($ingresos, 2) : '0.00' }}
                        </li>
                        <li><strong>Gastos:</strong> €{{ isset($gastos) ? number_format($gastos, 2) : '0.00' }}</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <style>
        /* Layout container: uso mínimo de Tailwind (container) + CSS propio */
        .welcome-card {
            display: flex;
            gap: 20px;
            align-items: stretch;
            margin-top: 8px;
            flex-wrap: wrap;
        }

        .welcome-left {
            flex: 1 1 420px;
            background: #ffffff;
            border-radius: 12px;
            padding: 26px;
            box-shadow: 0 6px 18px rgba(16, 24, 40, 0.06);
        }

        .welcome-right {
            width: 320px;
            min-width: 260px;
            background: #fafafa;
            border-radius: 12px;
            padding: 18px;
            box-shadow: 0 4px 12px rgba(16, 24, 40, 0.04);
            align-self: start;
        }

        .title {
            font-size: 22px;
            font-weight: 700;
            margin: 0 0 6px 0;
            color: #0f172a;
        }

        .subtitle {
            margin: 0 0 18px 0;
            color: #64748b;
            font-size: 14px;
        }

        .small-panel {
            display: inline-block;
            background: #f1f5f9;
            padding: 14px 18px;
            border-radius: 10px;
            margin: 12px 0;
        }

        .small-panel .label {
            display: block;
            color: #475569;
            font-size: 13px;
            margin-bottom: 6px;
            font-weight: 600;
        }

        .small-panel .amount {
            font-size: 28px;
            font-weight: 800;
        }

        .positive {
            color: #0b5f4f;
        }

        .neutral{
            color: black;
        }

        .negative{
            color: red;
        }

        .actions {
            margin-top: 18px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .btn {
            display: inline-block;
            padding: 10px 14px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            border: 1px solid transparent;
        }

        .btn-primary {
            background: linear-gradient(180deg, #0ea5a4, #059669);
            color: white;
            box-shadow: 0 6px 18px rgba(6, 95, 70, 0.12);
        }

        .btn-primary:hover {
            opacity: 0.95;
        }

        .btn-ghost {
            background: transparent;
            color: #0f172a;
            border: 1px solid #e6eef2;
        }

        .info-card h3 {
            margin: 0 0 8px 0;
            font-size: 15px;
            color: #0f172a;
        }

        .info-card ul {
            list-style: none;
            padding: 0;
            margin: 0;
            color: #475569;
        }

        .info-card li {
            padding: 6px 0;
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 860px) {
            .welcome-right {
                width: 100%;
            }

            .welcome-left {
                width: 100%;
            }
        }
    </style>
</x-app-layout>