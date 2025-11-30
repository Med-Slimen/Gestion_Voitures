<?php 
include_once("../../config/db.php");

$query2=$conn->query("SELECT DISTINCT(marque) from voiture");
if(isset($_GET["marque_list"])&&$_GET["marque_list"]=="all" && isset($_GET["disp_list"])&&$_GET["disp_list"]=="all" ){
$query=$conn->query("SELECT * from voiture");
}
else if(isset($_GET["search"])){
    $marque=$_GET["marque_list"];
    $disp=$_GET["disp_list"];
    if($marque=="all"){
        $query=$conn->prepare("SELECT * from voiture where disp=?");
        $query->execute([$disp]);
    }
    else if($disp=="all"){
        $query=$conn->prepare("SELECT * from voiture where marque=?");
        $query->execute([$marque]);
    }
    else{
        $query=$conn->prepare("SELECT * from voiture where marque=? and disp=?");
        $query->execute([$marque,$disp]);
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    <div class="navbar">
        <div class="box">
            <div class="text">
                <h1>Hi User</h1>
            </div>
            <div class="details">
                <div class="p1">
                    <p>username</p>
                </div>
                <div class="p2">
                    <a href="">Log out</a>
                </div>
            </div>
        </div>
    </div>
    <div class="main">
        <div class="container">
            <div class="box">
                <div class="text">
                    <h1>Here the list of the cars</h1>
                </div>
                <div class="details">
                    <form action="./list_voitures.php" method="get">
                        <select name="marque_list" id="">
                            <option <?php echo isset($marque)&&$marque=="all" ? "selected":"" ?> value="all">All</option>
                            <?php 
                            while($row2=$query2->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                <option <?php echo isset($marque)&&$marque==$row2["marque"] ? "selected":"" ?> value="<?php echo $row2["marque"] ?>"><?php echo $row2["marque"] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <select name="disp_list" id="">
                            <option <?php echo isset($disp)&&$disp=="all" ? "selected":"" ?> value="all">All</option>
                            <option <?php echo isset($disp)&&$disp=="1" ? "selected":"" ?> value="1">Disponible</option>
                            <option <?php echo isset($disp)&&$disp=="0" ? "selected":"" ?> value="0">Reservé</option>
                        </select>
                        <input type="submit" name="search" value="Search" id="">
                    </form>
                    <table border="3">
                        <tr>
                            <th>Marque</th>
                            <th>Modele</th>
                            <th>Annee</th>
                            <th>Immatriculation</th>
                            <th>disponibilité</th>
                            <th>Reserver</th>
                        </tr>
                        <?php
                        while($row=$query->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <tr>
                                <td><?php echo $row["marque"] ;?></td>
                                <td><?php echo $row["modele"] ;?></td>
                                <td><?php echo $row["annee"] ;?></td>
                                <td><?php echo $row["immat"] ;?></td>
                                <td><?php echo $row["disp"] ? "Yes" : "Non"; ?></td>
                                <td><button class="<?php echo $row["disp"] ? "clickable" : "unclickable"; ?> ;" ><a  href="">Reserver</button></a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>