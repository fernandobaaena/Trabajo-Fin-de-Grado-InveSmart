<x-app-layout>
    <div class="container mx-auto py-6">

        <div class="welcome-card flex-col md:flex-row">
            
            <!-- Panel principal -->
            <div class="welcome-left flex-1 mb-6 md:mb-0">
                <h1 class="title">Mercado de Acciones</h1>
                <p class="subtitle">Datos en tiempo real de bolsa</p>

                <input
                    type="text"
                    id="stock-search"
                    placeholder="Buscar acción (AAPL, TSLA...)"
                    class="w-full p-2 text-black bg-gray-200 rounded-md border-0 mb-4"
                >

                <ul id="stock-list" class="space-y-4 max-h-[500px] overflow-y-auto"></ul>
            </div>

            <!-- Panel derecho -->
            <div class="welcome-right w-full md:w-[320px] flex-shrink-0">
                <div class="small-panel">
                    <span class="label">Total Acciones</span>
                    <div class="amount" id="total-stocks">0</div>
                </div>

                <div class="small-panel">
                    <span class="label">Mercado</span>
                    <div class="amount text-slate-700 text-lg">
                        USA
                    </div>
                </div>

                <div class="actions mt-4">
                    <a href="{{ route('dashboard') }}" class="btn btn-ghost">Volver al inicio</a>
                    <a href="{{ route('finanzas.index') }}" class="btn btn-primary">Ir a Finanzas</a>
                </div>
            </div>

        </div>

    </div>

    {{-- ESTILOS (idénticos a cryptos para mantener coherencia) --}}
    <style>
        .welcome-card {
            display: flex;
            gap: 20px;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .welcome-left,
        .welcome-right {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 6px 18px rgba(16, 24, 40, 0.06);
        }

        .title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 6px;
            color: #0f172a;
        }

        .subtitle {
            margin-bottom: 18px;
            color: #64748b;
            font-size: 14px;
        }

        .small-panel {
            background: #f1f5f9;
            padding: 14px 18px;
            border-radius: 10px;
            margin: 12px 0;
        }

        .label {
            font-size: 13px;
            font-weight: 600;
            color: #475569;
        }

        .amount {
            font-size: 28px;
            font-weight: 800;
            color: #0b5f4f;
        }

        .btn {
            padding: 10px 14px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(180deg, #0ea5a4, #059669);
            color: white;
        }

        .btn-ghost {
            background: transparent;
            border: 1px solid #e6eef2;
            color: #0f172a;
        }
    </style>

    {{-- JS (de momento placeholder) --}}
    <script>
        const stockList = document.getElementById('stock-list');
        const totalStocksEl = document.getElementById('total-stocks');

        async function fetchStocks() {
            const res = await fetch('/api/stocks');
            const data = await res.json();

            totalStocksEl.textContent = data.length ?? 0;
            stockList.innerHTML = '';

            data.forEach(stock => {
                const li = document.createElement('li');
                li.className = 'bg-white rounded-xl p-4 shadow flex justify-between';

                li.innerHTML = `
                    <div>
                        <h2 class="font-bold text-lg">${stock.symbol}</h2>
                        <p class="text-gray-500 text-sm">${stock.name ?? 'Empresa'}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xl font-semibold">${stock.price ?? '--'} $</p>
                    </div>
                `;

                stockList.appendChild(li);
            });
        }

        fetchStocks();
    </script>
</x-app-layout>
