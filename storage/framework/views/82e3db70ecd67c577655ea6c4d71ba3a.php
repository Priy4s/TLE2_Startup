<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Lootbox</title>

    <!-- AI generated css voor heel de pagina MOET NOG VERANDEREN!!!!! -->
    <style>
        body {
            font-family: sans-serif;
        }

        .popup-overlay {
            display: none; /* Standaard verborgen */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex; /* Gebruik flex om te centreren */
            justify-content: center;
            align-items: center;
            z-index: 10000;
            display: none; /* Standaard weer verbergen */
        }

        .popup-content {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            animation: fadeIn 0.3s ease-in-out;
            width: 90%;
            max-width: 400px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }

        .popup-content h2 {
            margin-top: 0;
            color: #333;
        }

        .popup-content .item-name {
            font-size: 1.5em;
            font-weight: bold;
            color: #007bff; /* Een leuke kleur voor het item */
            margin: 10px 0 20px 0;
        }

        .popup-content button {
            padding: 10px 20px;
            border: none;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.2s;
        }
        .popup-content button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<p>You can claim your next lootbox in:</p>
<p id="timer"></p>
<button id="claimBtn" style="display: none;">Claim Lootbox</button>

<div id="videoContainer" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(0,0,0,0.8); justify-content: center; align-items: center; z-index: 9999;">
    <video id="lootboxVideo" width="600"></video>
</div>

<div id="itemPopup" class="popup-overlay">
    <div class="popup-content">
        <h2>Congratulations!</h2>
        <p>You received drip:</p>
        <p id="receivedItemName" class="item-name"></p>
        <button id="closePopupBtn">Awesome!</button>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {

        const timer = document.getElementById("timer");
        const claimBtn = document.getElementById("claimBtn");
        const videoContainer = document.getElementById("videoContainer");
        const video = document.getElementById("lootboxVideo");
        const itemPopup = document.getElementById('itemPopup');
        const receivedItemName = document.getElementById('receivedItemName');
        const closePopupBtn = document.getElementById('closePopupBtn');

        function getStoredTime() {
            const stored = localStorage.getItem("lastClaimed");
            return stored ? parseInt(stored) : null;
        }

        function setNextLootboxTime() {
            const now = new Date().getTime();
            //const nextTime = now + (24 * 60 * 60 * 1000); // 24 uur timer
            const nextTime = now + (10 * 1000); // 10 seconden voor testen
            localStorage.setItem("lastClaimed", nextTime.toString());
            return nextTime;
        }

        let countDownDate = getStoredTime() || setNextLootboxTime();
        let timerInterval = setInterval(updateTimer, 1000);

        function updateTimer() {
            const now = new Date().getTime();
            const distance = countDownDate - now;

            if (claimBtn) { claimBtn.disabled = false; }

            if (distance <= 0) {
                clearInterval(timerInterval);
                if (timer) { timer.innerHTML = "Lootbox earned!"; }
                if (claimBtn) { claimBtn.style.display = "inline"; }
            } else {
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                if (timer) { timer.innerHTML = `${hours}h ${minutes}m ${seconds}s`; }
                if (claimBtn) { claimBtn.style.display = "none"; }
            }
        }

        function showLootboxAnimation(callback) {
            video.currentTime = 0;
            video.src = "<?php echo e(asset('images/ChestOpening.mp4')); ?>";
            videoContainer.style.display = "flex";
            video.play();
            video.onended = () => {
                videoContainer.style.display = "none";
                video.src = "";
                if (callback) callback();
            };
        }

        function showItemPopup(itemName) {
            if(receivedItemName) receivedItemName.textContent = itemName;
            if(itemPopup) itemPopup.style.display = 'flex';
        }

        if(closePopupBtn) {
            closePopupBtn.addEventListener('click', () => {
                if(itemPopup) itemPopup.style.display = 'none';
            });
        }

        if(itemPopup) {
            itemPopup.addEventListener('click', (event) => {
                if (event.target === itemPopup) {
                    itemPopup.style.display = 'none';
                }
            });
        }

        if(claimBtn) {
            claimBtn.addEventListener("click", () => {
                claimBtn.disabled = true;
                claimBtn.textContent = 'Claiming...';
                fetch("<?php echo e(route('lootbox.open')); ?>", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                })
                    .then(response => {
                        if (!response.ok) throw new Error('Server response not OK');
                        return response.json();
                    })
                    .then(data => {
                        showLootboxAnimation(() => showItemPopup(data.item));
                        countDownDate = setNextLootboxTime();
                        timerInterval = setInterval(updateTimer, 1000);
                        updateTimer();
                        claimBtn.textContent = 'Claim Lootbox';
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        alert('Something went wrong. Please try again.');
                        claimBtn.disabled = false;
                        claimBtn.textContent = 'Claim Lootbox';
                    });
            });
        }
        updateTimer();
    });
</script>

</body>
</html><?php /**PATH C:\Users\nbjja\PhpstormProjects\TLE2_Startup\resources\views/lootbox.blade.php ENDPATH**/ ?>