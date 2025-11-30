<?php
include_once("../config/db.php");
if(isset($_POST["regisdter"])){
    $email=$_POST["email"];
    $pass=md5($_POST["pass"]);
    $username=$_POST["username"];
    $adress=$_POST["add"];
    $tel=$_POST["phone"];
    $query=$conn->prepare("SELECT email FROM user where email=?");
    $query->bindValue(1,$email);
    $query->execute();
    if($query->rowCount()>0){
        echo"An account already exist with this email";
    }
    else{
        $query=$conn->prepare("INSERT INTO user VALUES('',?,?,?,?,?)");
        $query->execute([$username,$adress,$tel,$email,$pass]);
        if($query){
            echo"inserstion avec succés";
        }
        else{
            echo"error";
        }
    }
}
if(isset($_POST["log_in"])){
    $email=$_POST["email"];
    $pass=md5($_POST["pass"]);
    $query=$conn->prepare("SELECT * FROM user where email=? and pass=?");
    $query->execute([$email,$pass]);
    if($query->rowCount()>0){
        header("Location: ../views/client/list_voitures.php");
    }
    else{
        header("Location: ../views/auth/login.php");
    }
}

?>