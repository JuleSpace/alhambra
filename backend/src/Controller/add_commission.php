<?php
// Configuration de la base de données
$host = 'localhost';
$dbname = 'alhambra';
$username = 'root'; // remplacer par l'utilisateur MySQL
$password = ''; // remplacer par le mot de passe MySQL

// En-têtes pour autoriser les requêtes depuis le frontend Vue.js
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["message" => "Erreur de connexion : " . $e->getMessage()]);
    exit();
}

// Récupérer les données de la requête
$data = json_decode(file_get_contents("php://input"));

// Vérifier si le nom de la commission est défini
if (!empty($data->name)) {
    $name = htmlspecialchars(strip_tags($data->name));

    // Insertion de la commission dans la base de données
    $query = "INSERT INTO commissions (name) VALUES (:name)";
    $stmt = $pdo->prepare($query);

    // Exécuter la requête
    if ($stmt->execute([':name' => $name])) {
        echo json_encode(["message" => "Commission ajoutée avec succès."]);
    } else {
        echo json_encode(["message" => "Échec de l'ajout de la commission."]);
    }
} else {
    echo json_encode(["message" => "Le champ 'name' est requis."]);
}
?>
