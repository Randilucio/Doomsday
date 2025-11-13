<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST"){
    die("Méthode non autorisée");
}
$nom     = htmlspecialchars(trim($_POST['nom'] ?? ''));
$email   = htmlspecialchars(trim($_POST['email'] ?? ''));
$mdp     = htmlspecialchars(trim($_POST['mdp'] ?? ''));
$ville   = htmlspecialchars(trim($_POST['ville'] ?? ''));
$sexe    = htmlspecialchars(trim($_POST['sexe'] ?? ''));
$loisir  = htmlspecialchars(trim($_POST['loisir'] ?? ''));
$animaux = htmlspecialchars(trim($_POST['animaux'] ?? ''));

$errors = [];

if (empty($nom)) {
    $errors[] = "Le nom est requis.";
}
if (empty($email)) {
    $errors[] = "L'email est requis.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "L'email n'est pas valide.";
}

if (empty($mdp)) {
    $errors[] = "Le mot de passe est requis.";
} elseif (strlen($mdp) < 6) {
    $errors[] = "Le mot de passe doit contenir au moins 6 caractères.";
}

if (empty($ville)) {
    $errors[] = "La ville est requise.";
}

if(strlen($animaux)<=1){
    $errors[] = "Un animaux a au moins 1 lettre vraiment ?";
}

if(strlen($loisir)<= 1){
    $errors[] = "Un loisir a au moins 1 lettre vraiment ?";
}

$profils = [
    ["nom" => "Alice", "ville" => "Paris", "sexe" => "femme", "loisir" => "lecture", "animaux" => "chat"],
    ["nom" => "Bob", "ville" => "Lyon", "sexe" => "homme", "loisir" => "sport", "animaux" => "chien"],
    ["nom" => "Clara", "ville" => "Marseille", "sexe" => "femme", "loisir" => "musique", "animaux" => "poisson"],
    ["nom" => "David", "ville" => "Lille", "sexe" => "homme", "loisir" => "cinéma", "animaux" => "chat"]
];

$resultats = array_filter($profils, function ($p) use ($ville, $sexe) {
    return (
        stripos($p['ville'], $ville) !== false &&
        $p['sexe'] === $sexe
    );
});


?>