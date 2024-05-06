<?php
// Démarrer ou récupérer la session
session_start();

// Vérifier si le panier existe dans la session
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array(); // Initialiser le panier comme un tableau vide
}

// Connexion à la base de données
$servername = "localhost"; // Adresse du serveur MySQL (habituellement localhost si sur le même serveur)
$username = "root"; // Nom d'utilisateur MySQL
$password = ""; // Mot de passe MySQL
$database = "projet_rania"; // Nom de la base de données

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $database);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Récupérer les produits dans le panier depuis la base de données
$panier_products = [];
foreach ($_SESSION['panier'] as $produit_id => $quantite) {
    // Exécuter la requête SQL pour récupérer les détails du produit à partir d'une autre table de produits
    $sql = "SELECT * FROM produits WHERE ID = $produit_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Ajouter les données du produit dans le panier_products
        $row = $result->fetch_assoc();
        $row['quantite'] = $quantite; // Ajouter la quantité du produit
        $panier_products[] = $row;
    }
}

// Afficher les produits dans le panier
echo "<h2>Votre Panier</h2>";
echo "<table>";
echo "<tr><th>Nom du produit</th><th>Prix</th><th>Quantité</th></tr>";
foreach ($panier_products as $product) {
    echo "<tr><td>" . $product['nom_produit'] . "</td><td>" . $product['prix'] . "</td><td>" . $product['quantite'] . "</td></tr>";
}
echo "</table>";

// Fermer la connexion à la base de données
$conn->close();
?>
