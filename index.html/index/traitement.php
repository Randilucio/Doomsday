<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo 'Not allowed if not method POST';
}

$nom = htmlspecialchars(trim($_POST['nom'] ?? ''));
$email = htmlspecialchars(trim($_POST['email'] ?? ''));
$password = htmlspecialchars(trim($_POST['password'] ?? ''));
$sexe = htmlspecialchars(trim($_POST['sexe'] ?? ''));
$ville = htmlspecialchars(trim($_POST['ville'] ?? ''));
$loisirs = $_POST['loisirs'] ?? [];
$animaux = htmlspecialchars(trim($_POST['animaux'] ?? ''));

$erreurs = [];
$villes_autorisees = ['Paris', 'Lyon', 'Marseille'];
$sexe_autorise = ['H', 'F'];

if (strlen($nom) < 2 || strlen($nom) > 50) {
    $erreurs[] = "Le nom doit contenir entre 2 et 50 caractères.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erreurs[] = "Email invalide.";
}

if (strlen($password) < 6) {
    $erreurs[] = "Le mot de passe doit contenir au moins 6 caractères.";
}

if (!in_array($sexe, $sexe_autorise)) {
    $erreurs[] = "Sexe invalide.";
}

if (!in_array($ville, $villes_autorisees)) {
    $erreurs[] = "Ville invalide.";
}

if (!empty($erreurs)) {
    echo "<h2>Erreurs :</h2><ul>";
    foreach ($erreurs as $erreur) {
        echo "<li>$erreur</li>";
    }
    echo "</ul>";
    echo '<a href="index.html">Retour au formulaire</a>';
    exit;
}

$profils = [
    ['nom'=>'Alice', 'sexe'=>'F', 'ville'=>'Paris', 'loisirs'=>['Lecture','Musique']],
    ['nom'=>'Bob', 'sexe'=>'H', 'ville'=>'Lyon', 'loisirs'=>['Sport']],
    ['nom'=>'Claire', 'sexe'=>'F', 'ville'=>'Marseille', 'loisirs'=>['Musique','Sport']],
];


$resultats = array_filter($profils, function($p) use ($sexe, $ville, $loisirs) {
    $loisirs_match = empty($loisirs) || count(array_intersect($loisirs, $p['loisirs'])) > 0;
    return $p['sexe'] === $sexe && $p['ville'] === $ville && $loisirs_match;
});

echo "<h2>Résultats de la recherche :</h2>";
if (empty($resultats)) {
    echo "Sa ne correspond a aucun profil";
} else {
    echo "<ul>";
    foreach ($resultats as $r) {
        echo "<li>{$r['nom']} ({$r['ville']}) - Loisirs: ".implode(", ", $r['loisirs'])."</li>";
    }
    echo "</ul>";
}
?>
