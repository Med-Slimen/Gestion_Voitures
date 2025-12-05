<?php
include_once("../config/init.php");
if(isset($_POST["reserver"])){
    $id_user=$_SESSION["id_user"];
    $id_voiture=$_POST["id_voiture"];
    $date_deb=$_POST["date_deb"];
    $date_fin=$_POST["date_fin"];
    try {
    $conn->beginTransaction();

    $query = $conn->prepare("INSERT INTO reservations (date_deb, date_fin, id_voiture, id_user) VALUES (?, ?, ?, ?)");
    $query->execute([$date_deb, $date_fin, $id_voiture, $id_user]);
 
    $updateCar = $conn->prepare("UPDATE voiture SET disp = 0 WHERE id = ?");
    $updateCar->execute([$id_voiture]);

    $conn->commit();
    $_SESSION["reservation_success"] = "Votre réservation a été effectuée avec succès !";
    header("Location: ../views/client/list_voitures.php");
    exit();
    }
    catch (Exception $e) {
        $conn->rollback();
        echo "Erreur: " . $e->getMessage();
    }
    

}

?>