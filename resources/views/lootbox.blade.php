<x-nav>
    <div class="flex flex-col items-center w-full">
        <p class="mt-4 text-center w-full">You can claim your next lootbox in:</p>
        <p id="timer" class="text-2xl font-bold text-center w-full"></p>
        <div class="flex gap-2 w-full max-w-md justify-center mt-4">
            <button id="claimBtn" class="w-full px-10 py-2 rounded bg-teal-700 text-white text-lg font-semibold shadow hover:bg-teal-600 transition whitespace-nowrap" style="display: none;">
                Claim Lootbox
            </button>
            <a href="{{ route('kikkerman.index') }}" class="w-full px-10 py-2 rounded bg-teal-700 text-white text-lg font-semibold shadow hover:bg-teal-600 transition text-center whitespace-nowrap">
                Back
            </a>
        </div>
    </div>

    <div id="videoContainer" class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50" style="display: none;">
        <video id="lootboxVideo" class="w-[600px] rounded shadow-lg"></video>
    </div>

    <div id="itemPopup" class="fixed inset-0 bg-teal-800 bg-opacity-95 flex items-center justify-center z-50" style="display: none;">
        <div class="bg-teal-800 p-8 rounded-xl text-center shadow-2xl w-11/12 max-w-md animate-fadeIn">
            <h2 class="text-2xl font-bold text-white mb-2">Congratulations!</h2>
            <p class="text-lg text-gray-200">You received drip:</p>
            <p id="receivedItemName" class="item-name text-2xl font-bold text-blue-400 my-4"></p>
            <button id="closePopupBtn" class="mt-4 px-6 py-2 rounded bg-green-600 text-white font-semibold hover:bg-green-700 transition">
                Awesome!
            </button>
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
                video.src = "{{ asset('images/ChestOpening.mp4') }}";
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
                    fetch("{{ route('lootbox.open') }}", {
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
</x-nav>


{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport"--}}
{{--          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">--}}
{{--    <meta http-equiv="X-UA-Compatible" content="ie=edge">--}}
{{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}
{{--    <title>Lootbox</title>--}}


{{--    <style>--}}
{{--        body {--}}
{{--            font-family: sans-serif;--}}
{{--            color: whitesmoke;--}}
{{--            background-color: #2b6561;--}}
{{--        }--}}

{{--        .popup-overlay {--}}
{{--            display: none;--}}
{{--            position: fixed;--}}
{{--            top: 0;--}}
{{--            left: 0;--}}
{{--            width: 100%;--}}
{{--            height: 100%;--}}
{{--            background-color: #2b6561;--}}
{{--            display: flex;--}}
{{--            justify-content: center;--}}
{{--            align-items: center;--}}
{{--            z-index: 10000;--}}
{{--            display: none;--}}
{{--        }--}}

{{--        .popup-content {--}}
{{--            background-color: #2b6561;--}}
{{--            padding: 30px;--}}
{{--            border-radius: 10px;--}}
{{--            text-align: center;--}}
{{--            box-shadow: 0 5px 15px rgba(0,0,0,0.3);--}}
{{--            animation: fadeIn 0.3s ease-in-out;--}}
{{--            width: 90%;--}}
{{--            max-width: 400px;--}}
{{--        }--}}

{{--        @keyframes fadeIn {--}}
{{--            from { opacity: 0; transform: scale(0.9); }--}}
{{--            to { opacity: 1; transform: scale(1); }--}}
{{--        }--}}

{{--        .popup-content h2 {--}}
{{--            margin-top: 0;--}}
{{--            color: #333;--}}
{{--        }--}}

{{--        .popup-content .item-name {--}}
{{--            font-size: 1.5em;--}}
{{--            font-weight: bold;--}}
{{--            color: #007bff; /* Een leuke kleur voor het item */--}}
{{--            margin: 10px 0 20px 0;--}}
{{--        }--}}

{{--        .popup-content button {--}}
{{--            padding: 10px 20px;--}}
{{--            border: none;--}}
{{--            background-color: #28a745;--}}
{{--            color: white;--}}
{{--            border-radius: 5px;--}}
{{--            cursor: pointer;--}}
{{--            font-size: 1em;--}}
{{--            transition: background-color 0.2s;--}}
{{--        }--}}
{{--        .popup-content button:hover {--}}
{{--            background-color: #218838;--}}
{{--        }--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body>--}}
{{--<p><a href="{{ route('kikkerman.index') }}" class="font-medium text-3xl">Back to your kikkerman!</a></p>--}}
{{--<p>You can claim your next lootbox in:</p>--}}
{{--<p id="timer"></p>--}}
{{--<button id="claimBtn" style="display: none; background-color: #2b6561; color: white">Claim Lootbox</button>--}}

{{--<div id="videoContainer" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(0,0,0,0.8); justify-content: center; align-items: center; z-index: 9999;">--}}
{{--    <video id="lootboxVideo" width="600"></video>--}}
{{--</div>--}}

{{--<div id="itemPopup" class="popup-overlay">--}}
{{--    <div class="popup-content">--}}
{{--        <h2>Congratulations!</h2>--}}
{{--        <p>You received drip:</p>--}}
{{--        <p id="receivedItemName" class="item-name"></p>--}}
{{--        <button id="closePopupBtn">Awesome!</button>--}}
{{--    </div>--}}
{{--</div>--}}



{{--<script>--}}
{{--    document.addEventListener('DOMContentLoaded', function () {--}}

{{--        const timer = document.getElementById("timer");--}}
{{--        const claimBtn = document.getElementById("claimBtn");--}}
{{--        const videoContainer = document.getElementById("videoContainer");--}}
{{--        const video = document.getElementById("lootboxVideo");--}}
{{--        const itemPopup = document.getElementById('itemPopup');--}}
{{--        const receivedItemName = document.getElementById('receivedItemName');--}}
{{--        const closePopupBtn = document.getElementById('closePopupBtn');--}}

{{--        function getStoredTime() {--}}
{{--            const stored = localStorage.getItem("lastClaimed");--}}
{{--            return stored ? parseInt(stored) : null;--}}
{{--        }--}}

{{--        function setNextLootboxTime() {--}}
{{--            const now = new Date().getTime();--}}
{{--            //const nextTime = now + (24 * 60 * 60 * 1000); // 24 uur timer--}}
{{--            const nextTime = now + (10 * 1000); // 10 seconden voor testen--}}
{{--            localStorage.setItem("lastClaimed", nextTime.toString());--}}
{{--            return nextTime;--}}
{{--        }--}}

{{--        let countDownDate = getStoredTime() || setNextLootboxTime();--}}
{{--        let timerInterval = setInterval(updateTimer, 1000);--}}

{{--        function updateTimer() {--}}
{{--            const now = new Date().getTime();--}}
{{--            const distance = countDownDate - now;--}}

{{--            if (claimBtn) { claimBtn.disabled = false; }--}}

{{--            if (distance <= 0) {--}}
{{--                clearInterval(timerInterval);--}}
{{--                if (timer) { timer.innerHTML = "Lootbox earned!"; }--}}
{{--                if (claimBtn) { claimBtn.style.display = "inline"; }--}}
{{--            } else {--}}
{{--                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));--}}
{{--                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));--}}
{{--                const seconds = Math.floor((distance % (1000 * 60)) / 1000);--}}
{{--                if (timer) { timer.innerHTML = `${hours}h ${minutes}m ${seconds}s`; }--}}
{{--                if (claimBtn) { claimBtn.style.display = "none"; }--}}
{{--            }--}}
{{--        }--}}

{{--        function showLootboxAnimation(callback) {--}}
{{--            video.currentTime = 0;--}}
{{--            video.src = "{{ asset('images/ChestOpening.mp4') }}";--}}
{{--            videoContainer.style.display = "flex";--}}
{{--            video.play();--}}
{{--            video.onended = () => {--}}
{{--                videoContainer.style.display = "none";--}}
{{--                video.src = "";--}}
{{--                if (callback) callback();--}}
{{--            };--}}
{{--        }--}}

{{--        function showItemPopup(itemName) {--}}
{{--            if(receivedItemName) receivedItemName.textContent = itemName;--}}
{{--            if(itemPopup) itemPopup.style.display = 'flex';--}}
{{--        }--}}

{{--        if(closePopupBtn) {--}}
{{--            closePopupBtn.addEventListener('click', () => {--}}
{{--                if(itemPopup) itemPopup.style.display = 'none';--}}
{{--            });--}}
{{--        }--}}

{{--        if(itemPopup) {--}}
{{--            itemPopup.addEventListener('click', (event) => {--}}
{{--                if (event.target === itemPopup) {--}}
{{--                    itemPopup.style.display = 'none';--}}
{{--                }--}}
{{--            });--}}
{{--        }--}}

{{--        if(claimBtn) {--}}
{{--            claimBtn.addEventListener("click", () => {--}}
{{--                claimBtn.disabled = true;--}}
{{--                claimBtn.textContent = 'Claiming...';--}}
{{--                fetch("{{ route('lootbox.open') }}", {--}}
{{--                    method: 'POST',--}}
{{--                    headers: {--}}
{{--                        'Content-Type': 'application/json',--}}
{{--                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')--}}
{{--                    },--}}
{{--                })--}}
{{--                    .then(response => {--}}
{{--                        if (!response.ok) throw new Error('Server response not OK');--}}
{{--                        return response.json();--}}
{{--                    })--}}
{{--                    .then(data => {--}}
{{--                        showLootboxAnimation(() => showItemPopup(data.item));--}}
{{--                        countDownDate = setNextLootboxTime();--}}
{{--                        timerInterval = setInterval(updateTimer, 1000);--}}
{{--                        updateTimer();--}}
{{--                        claimBtn.textContent = 'Claim Lootbox';--}}
{{--                    })--}}
{{--                    .catch((error) => {--}}
{{--                        console.error('Error:', error);--}}
{{--                        alert('Something went wrong. Please try again.');--}}
{{--                        claimBtn.disabled = false;--}}
{{--                        claimBtn.textContent = 'Claim Lootbox';--}}
{{--                    });--}}
{{--            });--}}
{{--        }--}}
{{--        updateTimer();--}}
{{--    });--}}
{{--</script>--}}

{{--</body>--}}
{{--</html>--}}