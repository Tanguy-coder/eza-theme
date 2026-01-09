<?php
// maintenance.php
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Maintenance en cours</title>
    <style>
        /* Style de base pour la page de maintenance */
        body {
            font-family: Arial, sans-serif;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f3f4f6;
        }

        .maintenance-container {
            text-align: center;
            padding: 20px;
            max-width: 600px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .maintenance-title {
            font-size: 2em;
            margin-bottom: 0.5em;
            color: #ff5722;
        }

        .maintenance-message {
            font-size: 1.2em;
            margin-bottom: 1em;
            color: #555;
        }

        .maintenance-timer {
            font-size: 1.5em;
            color: #ff5722;
        }
    </style>
</head>
<body>
<div class="maintenance-container">
    <h1 class="maintenance-title">Site en maintenance</h1>
    <p class="maintenance-message">Nous travaillons actuellement à l'amélioration de notre site. Merci de votre patience !</p>
    <p class="maintenance-timer" id="timer"></p>
</div>

<script>
    // Compte à rebours
    const targetDate = new Date().getTime() + 3 * 60 * 60 * 1000; // 3 heures de maintenance
    const timerElement = document.getElementById('timer');

    function updateTimer() {
        const now = new Date().getTime();
        const distance = targetDate - now;

        if (distance < 0) {
            timerElement.innerText = "Nous sommes bientôt de retour !";
            return;
        }

        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        timerElement.innerText = `Temps restant : ${hours}h ${minutes}m ${seconds}s`;
    }

    setInterval(updateTimer, 1000);
</script>
</body>
</html>
