<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lootbox</title>
</head>
<body>
<p>You can claim your next lootbox in:</p>
<p id="timer"></p>
<button id="claimBtn" style="display: none;">Claim Lootbox</button>

<div id="videoContainer" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(0,0,0,0.8); justify-content: center; align-items: center; z-index: 9999;">
    <video id="lootboxVideo" width="600" autoplay></video>
</div>

<script>
    const timer = document.getElementById("timer");
    const claimBtn = document.getElementById("claimBtn");

    // Checkt local storage voor de tijd
    function getStoredTime() {
        const stored = localStorage.getItem("lastClaimed");
        return stored ? parseInt(stored) : null;
    }

    function setNextLootboxTime() {
        const now = new Date().getTime();
        const nextTime = now + 10 //* 60 * 1000; Dit is nu een 10 minuten timer in miliseconden
        localStorage.setItem("lastClaimed", nextTime.toString()); //, pas aan naar bijv +5 om meteen een "lootbox" te ontvangen voor testing
        return nextTime; // pas aan naar 24 uur voor production (now + 24 * 60 * 60 * 1000)
    }

    let countDownDate = getStoredTime() || setNextLootboxTime();

    const interval = setInterval(updateTimer, 1000);

    function updateTimer() {
        const now = new Date().getTime();
        const distance = countDownDate - now;

        if (distance <= 0) {
            timer.innerHTML = "Lootbox earned!";
            claimBtn.style.display = "inline";
        } else {
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            timer.innerHTML = hours + "h " + minutes + "m " + seconds + "s ";
            claimBtn.style.display = "none";
        }
    }

    function showLootboxAnimation() {
        const videoContainer = document.getElementById("videoContainer");
        const video = document.getElementById("lootboxVideo");

        video.src = "/media/video/ChestOpening.mp4";
        console.log("video playing");
        videoContainer.style.display = "flex";

        video.play();

        video.onended = () => {
            videoContainer.style.display = "none";
            video.src = "";
        };
    }


    claimBtn.addEventListener("click", () => {
        countDownDate = setNextLootboxTime();  //
        updateTimer();
        showLootboxAnimation();
    });
</script>
</body>
</html>
