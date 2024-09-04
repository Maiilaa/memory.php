<?php
class Card {
    public $image;
    public $isFlipped;

    public function __construct($image) {
        $this->image = $image;
        $this->isFlipped = false;
    }

    public function flip() {
        $this->isFlipped = !$this->isFlipped;
    }
}
?>
<?php
session_start();
if (!isset($_SESSION['nom'])) {
    header("Location: index.php");
    exit;
}

require_once 'Card.php';
$images = ['Assets/images/djibouti.png', 'Assets/images/malaisie.png', 'Assets/images/maldives.png', 'Assets/images/oman.png', 'Assets/images/seychelles.png', 'Assets/images/somalie.png','Assets/images/mwali.png', 'Assets/images/france.png', 'Assets/images/comores.png', 'Assets/images/maore.jpg', 'Assets/images/ndzuwani.jpg', 'Assets/images/ngazidja.jpg'];
$paires = isset($_POST['paires']) ? (int)$_POST['paires'] : 6; 

// Randomly select images based on the number of pairs
$selectedImages = array_slice($images, 0, $paires);
$cards = array_merge($selectedImages, $selectedImages); 
shuffle($cards); 


$memoryCards = [];
foreach ($cards as $image) {
    $memoryCards[] = new Card($image);
}
if (!isset($_SESSION['moves'])) {
    $_SESSION['moves'] = 0;
}

if (!isset($_SESSION['flipped_cards'])) {
    $_SESSION['flipped_cards'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['card_id'])) {
    $card_id = $_POST['card_id'];
    $_SESSION['flipped_cards'][] = $card_id;
    if (count($_SESSION['flipped_cards']) == 2) {
        $_SESSION['moves']++;
        $card1 = $_SESSION['flipped_cards'][0];
        $card2 = $_SESSION['flipped_cards'][1];
        if ($card1 == $card2) {
            echo "Vous avez trouvé une paire!";
        } else {
            echo "Les cartes ne correspondent pas.";
        }
        $_SESSION['flipped_cards'] = [];
    }
}



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeu de Memory</title>
    <link rel="stylesheet" href="Assets/css/card.css?t=<?=time()?>">
</head>
<body>
    <h1>Bonjour, <?= htmlspecialchars($_SESSION['nom']) ?> !</h1>
    <p>Nombre de coups : <?= $_SESSION['moves'] ?></p>

    <form action="card.php" method="POST">
        <label for="paires">Nombre de paires :</label>
        <select name="paires" id="paires">
            <?php for ($i = 3; $i <= 12; $i++): ?>
                <option value="<?= $i ?>" <?= $i == $paires ? 'selected' : '' ?>><?= $i ?></option>
            <?php endfor; ?>
        </select>
        <button type="submit">Démarrer le jeu</button>
    </form>

    <div class="memory-game">
        <?php foreach ($memoryCards as $index => $card): ?>
            <div class="memory-card">
                <label>
                    <input type="checkbox" name="card<?= $index ?>" id="card<?= $index ?>" />
                    <div class="card-content">
                        <div class="card-back">
                            
                        </div>
                        <div class="card-front">
                            <img src="<?= $card->image ?>" alt="Image <?= $index ?>">
                        </div>
                    </div>
                </label>
            </div>
        <?php endforeach; ?>
    </div>
    <form action="logout.php" method="POST">
        <button type="submit">Quitter le jeu</button>
    </form>
    <form action="classement.php" method="POST">
        <button type="submit">Voir le classement</button>
    </form>
</body>
</html>
