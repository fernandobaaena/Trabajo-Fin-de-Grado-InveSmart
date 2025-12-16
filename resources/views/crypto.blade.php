<x-app-layout>
    <div class="container mx-auto py-6">

        <div class="welcome-card flex-col md:flex-row">
            <!-- Panel principal: Lista de criptos -->
            <div class="welcome-left flex-1 mb-6 md:mb-0">
                <h1 class="title">Top Criptomonedas</h1>
                <p class="subtitle">Actualizado cada 3 segundos</p>

                <input type="text" id="crypto-search" placeholder="Buscar cripto..."
                    class="w-full p-2 text-black bg-gray-200 rounded-md border-0 mb-4">

                <ul id="crypto-list" class="space-y-4 max-h-[500px] overflow-y-auto"></ul>
            </div>

            <!-- Panel derecho: Resumen -->
            <div class="welcome-right w-full md:w-[320px] flex-shrink-0">
                <div class="small-panel">
                    <span class="label">Total Criptos</span>
                    <div class="amount" id="total-cryptos">0</div>
                </div>

                <div class="small-panel">
                    <span class="label">Capital Total Estimado</span>
                    <div class="amount" id="total-marketcap">€0</div>
                </div>

                <div class="actions mt-4">
                    <a href="{{ route('dashboard') }}" class="btn btn-ghost">Volver al inicio</a>
                    <a href="{{ route('finanzas.index') }}" class="btn btn-primary">Ir a Finanzas</a>
                </div>
            </div>
        </div>

    </div>

    <style>
        .welcome-card {
            display: flex;
            gap: 20px;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .welcome-left {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 6px 18px rgba(16, 24, 40, 0.06);
        }

        .welcome-right {
            background: #ffffff;
            border-radius: 12px;
            padding: 18px;
            box-shadow: 0 4px 12px rgba(16, 24, 40, 0.04);
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
            color: #0b5f4f;
        }

        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 12px;
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

        #crypto-list li {
            list-style: none;
        }

        .price-cell {
            transition: background-color 0.5s, color 0.5s;
            padding: 2px 6px;
            border-radius: 4px;
        }

        @media (max-width: 860px) {

            .welcome-left,
            .welcome-right {
                width: 100%;
            }
        }
    </style>

    <script>
        let allCryptos = [];
        let previousPrices = {};
        const searchInput = document.getElementById('crypto-search');
        const cryptoList = document.getElementById('crypto-list');
        const totalCryptosEl = document.getElementById('total-cryptos');
        const totalMarketCapEl = document.getElementById('total-marketcap');

        async function fetchPrices() {
            try {
                const res = await fetch('/api/crypto');
                const data = await res.json();
                allCryptos = data;

                renderFilteredCryptos();
                updateSummary();
            } catch (error) {
                console.error('Error al obtener datos:', error);
            }
        }

        function renderFilteredCryptos() {
            const query = searchInput.value.toLowerCase();
            const filtered = query
                ? allCryptos.filter(coin => coin.name.toLowerCase().includes(query) || coin.symbol.toLowerCase().includes(query))
                : allCryptos;

            renderCryptos(filtered);
        }

        function renderCryptos(data) {
            cryptoList.innerHTML = '';
            data.forEach(coin => {
                const price = coin.current_price;
                const prevPrice = previousPrices[coin.id];
                let colorClass = '';
                if (prevPrice !== undefined) {
                    colorClass = price > prevPrice ? 'bg-green-600 text-white' :
                        price < prevPrice ? 'bg-red-600 text-white' : '';
                }
                const priceChange = coin.price_change_percentage_24h;
                const changeColor = priceChange >= 0 ? 'text-green-400' : 'text-red-500';

                const li = document.createElement('li');
                li.className = "bg-white rounded-xl p-4 flex items-center justify-between shadow";

                li.innerHTML = `
                    <div class="flex items-center space-x-4">
                        <img src="${coin.image}" alt="${coin.name}" class="w-10 h-10 rounded-full">
                        <div>
                            <h2 class="font-bold text-lg">${coin.name} (${coin.symbol.toUpperCase()})</h2>
                            <p class="text-gray-500 text-sm">Rank: ${coin.market_cap_rank}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xl font-semibold price-cell ${colorClass}">${price.toLocaleString()} €</p>
                        <p class="${changeColor}">24h: ${priceChange?.toFixed(2) ?? '0'}%</p>
                        <p class="text-gray-400 text-sm">Market Cap: €${coin.market_cap.toLocaleString()}</p>
                    </div>
                `;

                if (colorClass) {
                    const priceCell = li.querySelector('.price-cell');
                    setTimeout(() => priceCell.classList.remove('bg-green-600', 'bg-red-600', 'text-white'), 1000);
                }

                previousPrices[coin.id] = price;
                cryptoList.appendChild(li);
            });
        }

        function updateSummary() {
            totalCryptosEl.textContent = allCryptos.length;
            const totalMarketCap = allCryptos.reduce((acc, coin) => acc + (coin.market_cap ?? 0), 0);
            totalMarketCapEl.textContent = `€${totalMarketCap.toLocaleString()}`;
        }

        searchInput.addEventListener('input', renderFilteredCryptos);
        fetchPrices();
        //setInterval(fetchPrices, 3000); 
    </script>
</x-app-layout>