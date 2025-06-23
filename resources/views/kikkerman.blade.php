<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kikkerman Customizer</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #1f2937; }
        .customizer { display: flex; gap: 50px; align-items: center; background-color: #2b6561; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }

        #kikker-container {
            position: relative;
            width: 300px;
            height: 300px;
        }


        /* Alle lagen (kikker + cosmetics) */
        #kikker-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        /* De besturing */
        .controls { display: flex; flex-direction: column; gap: 20px; }
        .control-group { display: flex; align-items: center; gap: 15px; }
        .control-group h3 { margin: 0; width: 80px; }
        .arrow-btn { font-size: 24px; cursor: pointer; user-select: none; border: 1px solid #ccc; border-radius: 50%; width: 40px; height: 40px; display: inline-flex; justify-content: center; align-items: center; }
        .arrow-btn:hover { background-color: #e9e9e9; }
        .item-name { font-weight: bold; width: 150px; text-align: center; }
    </style>
</head>
<body>

<div class="customizer">
    <!-- De Kikker Visual -->
    <div id="kikker-container">
        <img id="base-kikker" src="{{ asset('cosmetics/lefrog.png') }}" alt="Le Frog">
{{--        <img id="color-layer" src="" alt="">--}}
        <img id="lower-layer" src="" alt="">
        <img id="upper-layer" src="" alt="">
    </div>

    <!-- De Knoppen -->
    <div class="controls">
        <!-- Upper Body Controls -->
        <div class="control-group">
            <h3>Upper</h3>
            <div class="arrow-btn" data-category="upper" data-direction="-1"><</div>
            <span id="upper-name" class="item-name">None</span>
            <div class="arrow-btn" data-category="upper" data-direction="1">></div>
        </div>
        <!-- Lower Body Controls -->
        <div class="control-group">
            <h3>Lower</h3>
            <div class="arrow-btn" data-category="lower" data-direction="-1"><</div>
            <span id="lower-name" class="item-name">None</span>
            <div class="arrow-btn" data-category="lower" data-direction="1">></div>
        </div>
        <!-- Color Controls -->
        <div class="control-group">
            <h3>Color</h3>
            <div class="arrow-btn" data-category="color" data-direction="-1"><</div>
            <span id="color-name" class="item-name">None</span>
            <div class="arrow-btn" data-category="color" data-direction="1">></div>
        </div>
        <p><a href="{{ route('lootbox.index') }}" class="font-medium text-3xl">Open your daily lootbox!</a></p>
        <p><a href="{{ route('dashboard') }}" class="font-medium text-3xl">Take me back home</a></p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // 1. Haal de data op van Laravel en zet een "None" optie erbij
        const userCosmetics = @json($cosmetics);

        const inventory = {
            upper: [{name: 'None', image_path: ''}, ...(userCosmetics.upper || [])],
            lower: [{name: 'None', image_path: ''}, ...(userCosmetics.lower || [])],
            color: [{name: 'None', image_path: ''}, ...(userCosmetics.color || [])]
        };

        // 2. Houd bij welk item we nu tonen
        const currentIndexes = {
            upper: 0,
            lower: 0,
            color: 0
        };

        // 3. Referenties naar de HTML-elementen
        const baseKikker = document.getElementById('base-kikker'); // AANGEPAST: Directe referentie naar de basiskikker

        // AANGEPAST: 'color' is hieruit verwijderd
        const layers = {
            upper: document.getElementById('upper-layer'),
            lower: document.getElementById('lower-layer')
        };

        const names = {
            upper: document.getElementById('upper-name'),
            lower: document.getElementById('lower-name'),
            color: document.getElementById('color-name')
        };

        // 4. De hoofdfunctie: update de weergave
        // AANGEPAST: De functie heeft nu een if/else voor de 'color' categorie
        function updateDisplay(category) {
            const currentIndex = currentIndexes[category];
            const currentItem = inventory[category][currentIndex];

            // Update altijd de naam
            names[category].textContent = currentItem.name;

            // --- DIT IS DE KERN VAN DE WIJZIGING ---
            if (category === 'color') {
                // Als de categorie 'color' is, verander de basiskikker
                if (currentItem.image_path) {
                    // Gebruik de nieuwe gekleurde kikker afbeelding
                    baseKikker.src = `{{ asset('cosmetics/') }}/${currentItem.image_path}`;
                } else {
                    // Geen kleur geselecteerd? Ga terug naar de standaard kikker.
                    baseKikker.src = `{{ asset('cosmetics/lefrog.png') }}`;
                }
            } else {
                // Voor 'upper' en 'lower', werk de overlay-laag bij (zoals voorheen)
                if (currentItem.image_path) {
                    layers[category].src = `{{ asset('cosmetics/') }}/${currentItem.image_path}`;
                } else {
                    layers[category].src = ''; // Verberg de laag
                }
            }
        }

        // 5. Maak de pijltjes-knoppen functioneel (deze code blijft hetzelfde)
        document.querySelectorAll('.arrow-btn').forEach(button => {
            button.addEventListener('click', () => {
                const category = button.dataset.category;
                const direction = parseInt(button.dataset.direction);
                const maxIndex = inventory[category].length - 1;

                currentIndexes[category] += direction;

                if (currentIndexes[category] > maxIndex) {
                    currentIndexes[category] = 0;
                } else if (currentIndexes[category] < 0) {
                    currentIndexes[category] = maxIndex;
                }

                updateDisplay(category);
            });
        });

        // 6. Initialiseer de pagina
        updateDisplay('upper');
        updateDisplay('lower');
        updateDisplay('color');

    });
</script>

</body>
</html>
