<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("<h2>❌ Accès non autorisé. Veuillez utiliser le formulaire.</h2>");
}

$nom = htmlspecialchars(trim($_POST['nom'] ?? ''));
$email = htmlspecialchars(trim($_POST['email'] ?? ''));
$mdp = htmlspecialchars(trim($_POST['mdp'] ?? ''));
$ville = htmlspecialchars(trim($_POST['ville'] ?? ''));
$sexe = htmlspecialchars($_POST['sexe'] ?? '');
$loisir = htmlspecialchars(trim($_POST['loisir'] ?? ''));
$animaux = htmlspecialchars(trim($_POST['animaux'] ?? ''));


$errors = [];


if (strlen($nom) < 2) {
    $errors[] = "Le nom doit contenir au moins 2 caractères.";
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "L'email n'est pas valide.";
}


if (strlen($mdp) < 6 || strlen($mdp) > 20) {
    $errors[] = "Le mot de passe doit comporter entre 6 et 20 caractères.";
}


if (strlen($ville) < 2) {
    $errors[] = "La ville doit comporter au moins 2 caractères.";
}


if (!in_array($sexe, ['homme', 'femme'])) {
    $errors[] = "Le sexe doit être 'homme' ou 'femme'.";
}


if (!empty($errors)) {
    echo "<h2 class='text-danger'>❌ Erreurs dans le formulaire :</h2><ul>";
    foreach ($errors as $e) {
        echo "<li>$e</li>";
    }
    echo "</ul>";
    echo '<a href="index.html" class="btn btn-primary mt-3">Retour au formulaire</a>';
    exit;
}


echo "<h1 class='text-success'>✅ Données reçues :</h1>";
echo "<ul>";
echo "<li><strong>Nom :</strong> $nom</li>";
echo "<li><strong>Email :</strong> $email</li>";
echo "<li><strong>Sexe :</strong> $sexe</li>";
echo "<li><strong>Ville :</strong> $ville</li>";
echo "<li><strong>Loisir :</strong> $loisir</li>";
echo "<li><strong>Animaux :</strong> $animaux</li>";
echo "</ul>";


$profils = [
    ["nom" => "Dupont", "sexe" => "homme", "ville" => "Paris", "loisir" => "football"],
    ["nom" => "Durand", "sexe" => "femme", "ville" => "Lyon", "loisir" => "lecture"],
    ["nom" => "Martin", "sexe" => "homme", "ville" => "Marseille", "loisir" => "natation"],
    ["nom" => "Bernard", "sexe" => "femme", "ville" => "Paris", "loisir" => "cinéma"],
];


$resultats = array_filter($profils, function ($p) use ($sexe, $ville) {
    return strtolower($p['sexe']) === strtolower($sexe) && strtolower($p['ville']) === strtolower($ville);
});


echo "<h2>🔎 Profils correspondants :</h2>";
if (count($resultats) > 0) {
    echo "<ul>";
    foreach ($resultats as $r) {
        echo "<li>{$r['nom']} ({$r['ville']} - {$r['loisir']})</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Aucun profil trouvé correspondant à vos critères.</p>";
}
?>
