<?php
try {
$dns = 'mysql:host=localhost;dbname=gestion_voiture';
$utilisateur = 'root';
$motDePasse = '';
$conn =new PDO($dns, $utilisateur, $motDePasse
);
}
catch ( Exception $e )
{ echo "Connection à MySQL impossible :", $e->getMessage();
die(); // ET mettre un arrêt du script
}
?>