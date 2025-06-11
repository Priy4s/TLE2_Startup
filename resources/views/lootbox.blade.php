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
<p>lootbox pagina man</p>
<p id="demo"></p>
<button id="claimBtn" style="display: none;">Claim Lootbox</button>

<script>
    const demo = document.getElementById("demo");
    const claimBtn = document.getElementById("claimBtn");

    // Checkt local storage voor de tijd
    function getStoredTime() {
        const stored = localStorage.getItem("lastClaimed");
        return stored ? parseInt(stored) : null;
    }

    function setNextLootboxTime() {
        const now = new Date().getTime();
        const nextTime = now + 10 * 60 * 1000; //Dit is nu een 10 minuten timer, pas aan naar bijv +5 om meteen een "lootbox"
        localStorage.setItem("lastClaimed", nextTime.toString());
        return nextTime;
    }

    let countDownDate = getStoredTime() || setNextLootboxTime();

    const interval = setInterval(updateTimer, 1000);

    function updateTimer() {
        const now = new Date().getTime();
        const distance = countDownDate - now;

        if (distance <= 0) {
            demo.innerHTML = "Lootbox earned";
            claimBtn.style.display = "inline";
        } else {
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            demo.innerHTML = hours + "h " + minutes + "m " + seconds + "s ";
            claimBtn.style.display = "none";
        }
    }

    claimBtn.addEventListener("click", () => {
        countDownDate = setNextLootboxTime();
        updateTimer();
    });
</script>
</body>
</html>
