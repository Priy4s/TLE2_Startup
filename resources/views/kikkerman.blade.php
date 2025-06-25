<x-nav>
    <div class="flex flex-col items-center justify-center min-h-screen">
        <div class="flex gap-12 items-center bg-accentBlue p-10 rounded-xl shadow-2xl customizer">
            <!-- De Kikker Visual -->
            <div id="kikker-container" class="relative w-72 h-72">
                <img id="base-kikker" src="{{ asset('cosmetics/lefrog.png') }}" alt="Le Frog" class="absolute top-0 left-0 w-full h-full object-contain">
                <img id="lower-layer" src="" alt="" class="absolute top-0 left-0 w-full h-full object-contain">
                <img id="upper-layer" src="" alt="" class="absolute top-0 left-0 w-full h-full object-contain">
            </div>

            <!-- De Knoppen -->
            <div class="flex flex-col gap-5 controls">
                <!-- Upper Body Controls -->
                <div class="flex items-center gap-4 control-group">
                    <h3 class="m-0 w-20 text-white font-semibold">Upper</h3>
                    <div class="arrow-btn flex items-center justify-center w-10 h-10 rounded-full border border-gray-300 text-2xl cursor-pointer select-none hover:bg-gray-200 bg-white text-gray-800" data-category="upper" data-direction="-1">&lt;</div>
                    <span id="upper-name" class="item-name font-bold w-36 text-center text-white">None</span>
                    <div class="arrow-btn flex items-center justify-center w-10 h-10 rounded-full border border-gray-300 text-2xl cursor-pointer select-none hover:bg-gray-200 bg-white text-gray-800" data-category="upper" data-direction="1">&gt;</div>
                </div>
                <!-- Lower Body Controls -->
                <div class="flex items-center gap-4 control-group">
                    <h3 class="m-0 w-20 text-white font-semibold">Lower</h3>
                    <div class="arrow-btn flex items-center justify-center w-10 h-10 rounded-full border border-gray-300 text-2xl cursor-pointer select-none hover:bg-gray-200 bg-white text-gray-800" data-category="lower" data-direction="-1">&lt;</div>
                    <span id="lower-name" class="item-name font-bold w-36 text-center text-white">None</span>
                    <div class="arrow-btn flex items-center justify-center w-10 h-10 rounded-full border border-gray-300 text-2xl cursor-pointer select-none hover:bg-gray-200 bg-white text-gray-800" data-category="lower" data-direction="1">&gt;</div>
                </div>
                <!-- Color Controls -->
                <div class="flex items-center gap-4 control-group">
                    <h3 class="m-0 w-20 text-white font-semibold">Color</h3>
                    <div class="arrow-btn flex items-center justify-center w-10 h-10 rounded-full border border-gray-300 text-2xl cursor-pointer select-none hover:bg-gray-200 bg-white text-gray-800" data-category="color" data-direction="-1">&lt;</div>
                    <span id="color-name" class="item-name font-bold w-36 text-center text-white">None</span>
                    <div class="arrow-btn flex items-center justify-center w-10 h-10 rounded-full border border-gray-300 text-2xl cursor-pointer select-none hover:bg-gray-200 bg-white text-gray-800" data-category="color" data-direction="1">&gt;</div>
                </div>
                <p><a href="{{ route('lootbox.index') }}" class="bg-viridian text-greenLight px-4 py-2 rounded m-4">Open your daily lootbox!</a></p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // De cosmetica die de gebruiker bezit (komt van de server)
            const userCosmetics = @json($cosmetics);

            // De volledige inventaris, inclusief de 'None' optie
            const inventory = {
                upper: [{name: 'None', image_path: ''}, ...(userCosmetics.upper || [])],
                lower: [{name: 'None', image_path: ''}, ...(userCosmetics.lower || [])],
                color: [{name: 'None', image_path: ''}, ...(userCosmetics.color || [])]
            };

            // Huidige selectie, start bij 0
            const currentIndexes = { upper: 0, lower: 0, color: 0 };

            // Referenties naar de HTML-elementen
            const baseKikker = document.getElementById('base-kikker');
            const layers = {
                upper: document.getElementById('upper-layer'),
                lower: document.getElementById('lower-layer')
            };
            const names = {
                upper: document.getElementById('upper-name'),
                lower: document.getElementById('lower-name'),
                color: document.getElementById('color-name')
            };

            // --- NIEUW: Functie om de outfit op te slaan ---
            function saveOutfit() {
                // Sla het 'currentIndexes' object als een JSON-string op in localStorage
                localStorage.setItem('kikkerOutfit', JSON.stringify(currentIndexes));
            }

            // --- NIEUW: Functie om de outfit te laden ---
            function loadOutfit() {
                const savedOutfit = localStorage.getItem('kikkerOutfit');
                if (savedOutfit) {
                    // Als er een opgeslagen outfit is, parse deze en update de currentIndexes
                    const savedIndexes = JSON.parse(savedOutfit);
                    // Controleer of de opgeslagen indexen nog geldig zijn (bv. na het verwijderen van een item)
                    if (savedIndexes.upper < inventory.upper.length) {
                        currentIndexes.upper = savedIndexes.upper;
                    }
                    if (savedIndexes.lower < inventory.lower.length) {
                        currentIndexes.lower = savedIndexes.lower;
                    }
                    if (savedIndexes.color < inventory.color.length) {
                        currentIndexes.color = savedIndexes.color;
                    }
                }
            }

            // Functie om de weergave van de kikker bij te werken
            function updateDisplay(category) {
                const currentIndex = currentIndexes[category];
                const currentItem = inventory[category][currentIndex];

                names[category].textContent = currentItem.name;

                if (category === 'color') {
                    // Update de basiskleur van de kikker
                    if (currentItem.image_path) {
                        baseKikker.src = `{{ asset('cosmetics/') }}/${currentItem.image_path}`;
                    } else {
                        baseKikker.src = `{{ asset('cosmetics/lefrog.png') }}`; // Standaard kikker
                    }
                } else {
                    // Update de kledinglagen
                    if (currentItem.image_path) {
                        layers[category].src = `{{ asset('cosmetics/') }}/${currentItem.image_path}`;
                        layers[category].style.display = 'block';
                    } else {
                        layers[category].src = '';
                        layers[category].style.display = 'none';
                    }
                }
            }

            // Event listener voor de pijltjestoetsen
            document.querySelectorAll('.arrow-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const category = button.dataset.category;
                    const direction = parseInt(button.dataset.direction);
                    const maxIndex = inventory[category].length - 1;

                    currentIndexes[category] += direction;

                    // Zorg dat de index binnen de grenzen blijft (loopt rond)
                    if (currentIndexes[category] > maxIndex) {
                        currentIndexes[category] = 0;
                    } else if (currentIndexes[category] < 0) {
                        currentIndexes[category] = maxIndex;
                    }

                    updateDisplay(category);

                    // --- NIEUW: Sla de outfit op na elke verandering ---
                    saveOutfit();
                });
            });

            // --- NIEUW: Laad de outfit direct als de pagina wordt geladen ---
            loadOutfit();

            // Werk de weergave initieel bij met de (eventueel geladen) outfit
            updateDisplay('upper');
            updateDisplay('lower');
            updateDisplay('color');
        });
    </script>
</x-nav>
