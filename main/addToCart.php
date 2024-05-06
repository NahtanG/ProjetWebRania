<?php
// Démarrer ou récupérer la session
session_start();

// Vérifier si le formulaire d'ajout au panier a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_to_cart"])) {
    // Vérifier si l'ID du produit est défini dans le formulaire
    if (isset($_POST["product_id"])) {
        // Récupérer l'ID du produit depuis le formulaire
        $product_id = $_POST["product_id"];

        // Vérifier si le produit existe dans la base de données (vous devrez implémenter cette logique)
        $product_exists = true; // Remplacez cette ligne par votre logique de vérification du produit

        if ($product_exists) {
            // Ajouter le produit au panier
            if (!isset($_SESSION['panier'][$product_id])) {
                $_SESSION['panier'][$product_id] = 1; // Ajouter le produit avec une quantité de 1
            } else {
                $_SESSION['panier'][$product_id]++; // Incrémenter la quantité si le produit est déjà dans le panier
            }

            // Rediriger l'utilisateur vers la page du panier
            header("Location: panier.php");
            exit;
        } else {
            // Le produit n'existe pas dans la base de données
            echo "Product not found!";
        }
    } else {
        // L'ID du produit n'est pas défini dans le formulaire
        echo "Product ID not specified!";
    }
} else {
    // Le formulaire d'ajout au panier n'a pas été soumis
    // Rediriger l'utilisateur vers la page précédente ou une autre page
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit;
}
?>
