<?php
include_once("../config/init.php");
if(isset($_POST["Modify"])){
    $id_voiture=$_POST["id_voiture"];
    $modele=$_POST["modele"];
    $marque=$_POST["marque"];
    $annee=$_POST["annee"];
    $immat=$_POST["immat"];
    $disp=$_POST["disp"];
    $old_disp=$_POST["old_disp"];
    if($disp==1 && $old_disp==0){
        $sel=$conn->prepare("SELECT * from reservations where id_voiture=? ");
        $sel->execute([$id_voiture]);
        if($sel->rowCount()>0){
            $del=$conn->prepare("DELETE from reservations where id_voiture=? ");
            $del->execute([$id_voiture]);
        }
    }
    $query=$conn->prepare("UPDATE voiture SET modele=?,marque=?,annee=?,immat=?,disp=? where id=?");
    $query->execute([$modele,$marque,$annee,$immat,$disp,$id_voiture]);
    if($query->rowCount()>0){
        header("Location: ../views/admin/dashboard.php");
        exit();
    }
    else{
        echo "<script>alert('error')</script>";
    }
}
if(isset($_POST["Add"])){
    $modele=$_POST["modele"];
    $marque=$_POST["marque"];
    $annee=$_POST["annee"];
    $immat=$_POST["immat"];
    $disp=$_POST["disp"] ? 1 : 0;
    $query=$conn->prepare("INSERT INTO voiture(marque,modele,annee,immat,disp)Values(?,?,?,?,?)");
    $query->execute([$marque,$modele,$annee,$immat,$disp]);
    if($query->rowCount()>0){
        header("Location: ../views/admin/dashboard.php");
        exit();
    }
}


?>