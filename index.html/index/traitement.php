<?php
// Refuser tout accès en GET
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("❌ Accès non autorisé. Veuillez utiliser le formulaire.");
}

// 1️⃣ Sécurité & récupération des données
$nom = htmlspecialchars(trim($_POST['nom'] ?? ''));
$email = htmlspecialchars(trim($_POST['email'] ?? ''));
$password = htmlspecialchars(trim($_POST['password'] ?? ''));
$sexe = htmlspecialchars($_POST['sexe'] ?? '');
$ville = htmlspecialchars($_POST['ville'] ?? '');
$loisirs = htmlspecialchars(trim($_POST['loisirs'] ?? ''));
$animaux = htmlspecialchars(trim($_POST['animaux'] ?? ''));

// 2️⃣ Validations
$errors = [];

if (strlen($nom) < 2 || strlen($nom) > 50) {
    $errors[] = "Le nom doit comporter entre 2 et 50 caractères.";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Adresse email invalide.";
}
if (strlen($password) < 6 || strlen($password) > 20) {
    $errors[] = "Le mot de passe doit comporter entre 6 et 20 caractères.";
}
if (!in_array($sexe, ['H', 'F'])) {
    $errors[] = "Le sexe doit être 'H' ou 'F'.";
}
$villes_autorisees = ['Paris', 'Lyon', 'Marseille'];
if (!in_array($ville, $villes_autorisees)) {
    $errors[] = "Ville invalide.";
}

// 3️⃣ Gestion des erreurs
if (!empty($errors)) {
    echo "<h2>❌ Erreurs dans le formulaire :</h2><ul>";
    foreach ($errors as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul>";
    echo '<a href="index.html">Retour au formulaire</a>';
    exit;
}

// 4️⃣ Affichage du récapitulatif
echo "<h1>✅ Données reçues :</h1>";
echo "<ul>";
echo "<li><strong>Nom :</strong> $nom</li>";
echo "<li><strong>Email :</strong> $email</li>";
echo "<li><strong>Sexe :</strong> " . ($sexe === 'H' ? 'Homme' : 'Femme') . "</li>";
echo "<li><strong>Ville :</strong> $ville</li>";
echo "<li><strong>Loisirs :</strong> $loisirs</li>";
echo "<li><strong>Animaux :</strong> $animaux</li>";
echo "</ul>";

// 5️⃣ Recherche dans une liste de profils
$profils = [
    ["nom" => "Dupont", "sexe" => "H", "ville" => "Paris", "loisirs" => "foot"],
    ["nom" => "Durand", "sexe" => "F", "ville" => "Lyon", "loisirs" => "lecture"],
    ["nom" => "Martin", "sexe" => "H", "ville" => "Marseille", "loisirs" => "natation"],
    ["nom" => "Bernard", "sexe" => "F", "ville" => "Paris", "loisirs" => "cinéma"],
];

$resultats = array_filter($profils, function ($p) use ($sexe, $ville) {
    return $p['sexe'] === $sexe && $p['ville'] === $ville;
});

echo "<h2>🔎 Profils correspondants :</h2>";
if (count($resultats) > 0) {
    echo "<ul>";
    foreach ($resultats as $r) {
        echo "<li>{$r['nom']} ({$r['ville']} - {$r['loisirs']})</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Aucun profil trouvé pour ces critères.</p>";
}
?>
