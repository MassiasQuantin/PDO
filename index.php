<?php
require_once '_connec.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);

    if (strlen($firstname) > 0 && strlen($firstname) <= 45 && strlen($lastname) > 0 && strlen($lastname) <= 45) {
        $query = 'INSERT INTO friends (firstname, lastname) VALUES (:firstname, :lastname)';
        $statement = $pdo->prepare($query);
        $statement->bindValue(':firstname', $firstname, PDO::PARAM_STR);
        $statement->bindValue(':lastname', $lastname, PDO::PARAM_STR);
        $statement->execute();

        header('Location: index.php');
        exit;
    } else {
        $message = 'Les champs doivent être remplis et ne doivent pas dépasser 45 caractères.';
    }
}

$query = 'SELECT * FROM friends';
$statement = $pdo->query($query);
$friends = $statement->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des amis</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Liste des amis</h1>
    <ul>
        <?php foreach ($friends as $friend): ?>
            <li><?= htmlspecialchars($friend['firstname']) . ' ' . htmlspecialchars($friend['lastname']) ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Ajouter un ami</h2>
    <?php if ($message): ?>
        <p><?= $message ?></p>
    <?php endif; ?>
    <form method="post">
        <div>
            <label for="firstname">Prénom :</label>
            <input type="text" id="firstname" name="firstname" required>
        </div>
        <div>
            <label for="lastname">Nom :</label>
            <input type="text" id="lastname" name="lastname" required>
        </div>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
