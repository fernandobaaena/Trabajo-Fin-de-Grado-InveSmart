<x-app-layout>
    <div class="container mx-auto py-6">

        <!-- Panel Financiero Compacto -->
        <div class="panel-finanzas">
            <div class="tarjeta ingreso">
                <h2>Ingresos</h2>
                <p>€{{ number_format($ingresos, 2) }}</p>
            </div>
            <div class="tarjeta gasto">
                <h2>Gastos</h2>
                <p>€{{ number_format($gastos, 2) }}</p>
            </div>
            <div class="tarjeta ahorro">
                <h2>Ahorros</h2>
                <p>€{{ number_format($ahorros, 2) }}</p>
            </div>
        </div>

        <!-- Formulario CRUD -->
        <div class="crud-form">
            <h2>{{ isset($movimiento) ? 'Editar Movimiento' : 'Añadir Movimiento' }}</h2>
            @if(isset($movimiento))
                <form action="{{ route('finanzas.update', $movimiento->id) }}" method="POST">
                    @method('PUT')
            @else
                    <form action="{{ route('finanzas.store') }}" method="POST">
                @endif
                    @csrf
                    <div class="form-row">
                        <select name="tipo" required>
                            <option value="">Tipo</option>
                            <option value="ingreso" {{ (isset($movimiento) && $movimiento->tipo == 'ingreso') ? 'selected' : '' }}>Ingreso</option>
                            <option value="gasto" {{ (isset($movimiento) && $movimiento->tipo == 'gasto') ? 'selected' : '' }}>Gasto</option>
                        </select>
                        <input type="number" name="cantidad" placeholder="Cantidad" step="0.01"
                            value="{{ $movimiento->cantidad ?? '' }}" required>
                        <input type="date" name="fecha" value="{{ $movimiento->fecha ?? '' }}" required>
                        <div class="botones">
                            <button type="submit">{{ isset($movimiento) ? 'Actualizar' : 'Guardar' }}</button>
                            @if(isset($movimiento))
                                <a href="{{ route('finanzas.index') }}">Cancelar</a>
                            @endif
                        </div>
                    </div>
                </form>
        </div>

        <!-- Lista de Movimientos -->
        <div class="lista-movimientos">
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($movimientos as $m)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($m->fecha)->format('d/m/Y') }}</td>
                            <td>{{ ucfirst($m->tipo) }}</td>
                            <td>€{{ number_format($m->cantidad, 2) }}</td>
                            <td class="acciones">
                                <a href="{{ route('finanzas.edit', $m->id) }}" class="editar">Editar</a>
                                <form action="{{ route('finanzas.destroy', $m->id) }}" method="POST"
                                    onsubmit="return confirm('¿Seguro que quieres borrar?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="borrar">Borrar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if($movimientos->isEmpty())
                        <tr>
                            <td colspan="4" class="no-movimientos">No hay movimientos aún</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
    </div>

    <style>
        /* Panel Financiero */
        .panel-finanzas {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .panel-finanzas .tarjeta {
            flex: 1;
            min-width: 150px;
            background: #f5f5f5;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .panel-finanzas .tarjeta:hover {
            transform: translateY(-3px);
        }

        .tarjeta.ingreso {
            background: #e6f7ea;
            color: #2f855a;
        }

        .tarjeta.gasto {
            background: #fde2e2;
            color: #c53030;
        }

        .tarjeta.ahorro {
            background: #e0f2fe;
            color: #2b6cb0;
        }

        .tarjeta h2 {
            font-size: 14px;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .tarjeta p {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
        }

        /* Formulario CRUD */
        .crud-form {
            background: #fff;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .crud-form h2 {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .crud-form .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }

        .crud-form select,
        .crud-form input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            min-width: 100px;
        }

        .crud-form .botones {
            display: flex;
            gap: 5px;
        }

        .crud-form button {
            background: #3182ce;
            color: #fff;
            padding: 8px 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
        }

        .crud-form button:hover {
            background: #2b6cb0;
        }

        .crud-form a {
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            text-decoration: none;
            color: #333;
        }

        .crud-form a:hover {
            background: #f0f0f0;
        }


        .lista-movimientos table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .lista-movimientos th,
        .lista-movimientos td {
            padding: 8px 12px;
            text-align: left;
            font-size: 14px;
            border-bottom: 1px solid #eee;
        }

        .lista-movimientos tr:hover {
            background: #f9f9f9;
        }

        .acciones {
            display: flex;
            gap: 5px;
        }

        .acciones .editar {
            padding: 4px 8px;
            background: #f6e05e;
            border-radius: 6px;
            text-decoration: none;
            color: #744210;
            font-size: 12px;
        }

        .acciones .editar:hover {
            background: #ecc94b;
        }

        .acciones .borrar {
            padding: 4px 8px;
            background: #f56565;
            border-radius: 6px;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 12px;
        }

        .acciones .borrar:hover {
            background: #c53030;
        }

        .no-movimientos {
            text-align: center;
            color: #888;
            padding: 12px 0;
        }

        @media(max-width: 640px) {
            .panel-finanzas {
                flex-direction: column;
            }

            .crud-form .form-row {
                flex-direction: column;
                align-items: stretch;
            }

            .crud-form .botones {
                justify-content: flex-start;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</x-app-layout>