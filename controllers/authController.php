<?php
include_once("../config/init.php");
if(isset($_POST["register"])){
    $email=$_POST["email"];
    $pass=md5($_POST["pass"]);
    $username=$_POST["username"];
    $adress=$_POST["add"];
    $tel=$_POST["phone"];
    $query=$conn->prepare("SELECT email FROM user where email=?");
    $query->bindValue(1,$email);
    $query->execute();
    if($query->rowCount()>0){
        $_SESSION["emailerror"]="Adresse email deja utilisé";
        header("Location: ../views/auth/register.php");
        exit();
    }
    else{
        try{
            $conn->beginTransaction();
            $query=$conn->prepare("INSERT INTO user VALUES('',?,?,?,?,?)");
            $query->execute([$username,$adress,$tel,$email,$pass]);
            $id_user = $conn->lastInsertId();
            $query=$conn->query("SELECT id from roles where nom='CLIENT'");
            $id_role=($query->fetch(PDO::FETCH_ASSOC))["id"];
            $query=$conn->prepare("INSERT INTO user_roles VALUES (?,?)");
            $query->execute([$id_user,$id_role]);
            $conn->commit();
            $_SESSION["username"]=$username;
            $_SESSION['id_user']=$id_user;
            header("Location: ../views/client/list_voitures.php");
            exit();
        }
        catch(Exception $e){
            $conn->rollBack();
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
        $row=$query->fetch(PDO::FETCH_ASSOC);
        $_SESSION['username']=$row["username"];
        $_SESSION['id_user']=$row["id"];
        $roles_query=$conn->prepare("SELECT DISTINCT(nom) from
         roles r,user_roles ur,user u 
         where ur.id_user=? and u.id=ur.id_user and r.id=ur.id_role");
        $roles_query->execute([$row["id"]]);
        $user_roles=[];
        while($roles=$roles_query->fetch(PDO::FETCH_ASSOC)){
            $user_roles[]=$roles["nom"];
        }
        if(in_array("ADMIN",$user_roles)){
            $_SESSION["admin"]=true;
            header("Location: ../views/admin/adminChose.php");
            exit();
        }
        else{
            $_SESSION["admin"]=false;
            header("Location: ../views/client/list_voitures.php");
            exit();
        }
    }
    else{
        $_SESSION["loginerror"]="Invalid credentials";
        header("Location: ../views/auth/login.php");

        exit();
    }
}

?>