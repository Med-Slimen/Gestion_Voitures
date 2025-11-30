<?php
include_once("../config/init.php");
if(isset($_POST["reserver"])){
    $id_user=$_SESSION["id_user"];
    $id_voiture=$_POST["id_voiture"];
    $date_deb=$_POST["date_deb"];
    $date_fin=$_POST["date_fin"];
    $query=$conn->prepare("INSERT INTO reservations(date_deb,date_fin,id_voiture,id_user) Values(?,?,?,?)");
    $query->execute([$date_deb,$date_fin,$id_voiture,$id_user]);
    if($query->rowCount()>0){
        $query=$conn->prepare("UPDATE voiture Set disp=0 where id=?");
        $query->execute([$id_voiture]);
        if($query->rowCount()>0){
            echo"Insersation successful";
        }
        else{
            echo"error";
        }
        
    }
    else{
        echo"error";
    }
}

?>