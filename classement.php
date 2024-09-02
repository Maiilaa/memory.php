<?php
session_start();

if (!isset($_SESSION['nom'])) {
    header("Location: index.php");
    exit;
}

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'memory';

$conn = new mysqli($host, $username, $password, $dbname);


if ($conn->connect_error) {
    die('Erreur de connexion : ' . $conn->connect_error);
}

$sql = 'SELECT nom, meilleur_score 
        FROM joueurs 
        WHERE meilleur_score IS NOT NULL 
        ORDER BY meilleur_score ASC 
        LIMIT 10';

$result = $conn->query($sql);
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classement des Meilleurs Joueurs</title>
    <link rel="stylesheet" href="Assets/css/classement.css?t=<?=time()?>">
</head>
<body>
    <h1>Classement des 10 Meilleurs Joueurs</h1>

    <?php if ($result && $result->num_rows > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Position</th>
                    <th>Nom d'utilisateur</th>
                    <th>Meilleur Score (Nombre de coups)</th>
                </tr>
            </thead>
            <tbody>
                <?php $index = 1; ?>
                <?php while ($player = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $index ?></td> 
                        <td><?= htmlspecialchars($player['nom']) ?></td> 
                        <td><?= htmlspecialchars($player['meilleur_score']) ?></td> 
                    </tr>
                    <?php $index++; ?>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun joueur n'a encore enregistré de score.</p>
    <?php endif; ?>

    <a href="card.php">Retour au jeu</a>
</body>
</html>

