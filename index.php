<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nom'])) {
    $_SESSION['nom'] = $_POST['nom'];
    header("Location: card.php"); 
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Game</title>
    <link rel="stylesheet" href="Assets/css/index.css?t=<?=time()?>">
</head>
<body>
    <main>
        <?php include '_header.php'; ?>
        <form action="index.php" method="post">
            <label for="nom">Nom du joueur :</label>
            <input type="text" id="nom"name="nom" required>
            <button type="submit">Commencer à jouer</button>
        </form>
    </main>
</body>
</html>
