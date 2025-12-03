<?php 
include_once("../../config/init.php");
if(!isset($_SESSION["username"])){
    header("Location: ../auth/login.php");
}
$query2=$conn->query("SELECT DISTINCT(marque) from voiture");
if(isset($_GET["search"])){
    $marque=$_GET["marque_list"];
    $disp=$_GET["disp_list"];
    if($marque=="all" && $disp=="all" ){
        $query=$conn->query("SELECT * from voiture");
    }
    else if($marque=="all"){
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
else{
    $query=$conn->query("SELECT * from voiture");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <!--Font awsome link -->
    <script src="https://kit.fontawesome.com/0a1e03754e.js" crossorigin="anonymous"></script>
    <script src="../../public/js/script.js"></script>
</head>
<body>
    <div class="navbar">
        <div class="box">
            <div class="text">
                <h1>Car Reservation</h1>
            </div>
            <div class="details">
                <p><?php echo $_SESSION['username']; ?></p>
                <a href="../auth/logout.php">Log out</a>
            </div>
        </div>
    </div>
    <div class="main">
        <div class="container">
            <div class="box">
                <div class="text">
                    <h1>Cars List</h1>
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
                    <?php 
                        if(isset($_SESSION["admin"])&& $_SESSION["admin"]){
                            ?>
                            <div class="adminbutton">
                            <a href='../admin/dashboard.php'>Admin Panel</a>
                            </div>
                        <?php
                        }
                    ?>
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
                        if($query->rowCount()==0){
                            ?>
                            <tr>
                                <td colspan="6">No cars found</td>
                            </tr>
                        <?php
                        }
                        ?>
                        <?php
                        while($row=$query->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <tr>
                                <td><?php echo $row["marque"] ;?></td>
                                <td><?php echo $row["modele"] ;?></td>
                                <td><?php echo $row["annee"] ;?></td>
                                <td><?php echo $row["immat"] ;?></td>
                                <td><?php 
                                    if($row["disp"]==0){
                                        $disquery=$conn->prepare("SELECT * From reservations where id_voiture=?");
                                        $disquery->execute([$row["id"]]);
                                        if($disquery->rowCount()>0){
                                            $disres=$disquery->fetch(PDO::FETCH_ASSOC);
                                            $date_deb=new DATETIME($disres["date_deb"]);
                                            $date_fin=new DATETIME($disres["date_fin"]);
                                            $days=$date_deb->diff($date_fin);
                                            echo "Non ( Available in  ".$days->days+1 ." days )";
                                        }
                                        else{
                                            echo"Non";
                                        }
                                    }
                                    else{
                                        echo "Yes";
                                    }
                                ?></td>
                                <td><button onclick="showRes('<?php echo $row['marque']?>','<?php echo $row['modele']?>','<?php echo $row['annee']?>','<?php echo $row['immat']?>','<?php echo $row['id'];?>')" class="<?php echo $row["disp"] ? "clickable" : "unclickable"; ?> ;" >Reserver</button></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div id="res_form" class="reserver_form">
                <div class="text">
                    <h2>Reservation of the car</h2>
                </div>
                <div class="details">
                    <div class="car">
                        <p id="marque"></p>
                        <p id="modele"></p>
                        <p id="annee"></p>
                        <p id="immat"></p>
                    </div>
                    <div class="res_form">
                        <form action="../../controllers/reservationController.php" onsubmit="return verifDate()" method="post">
                            <label for="">From</label>
                            <input type="hidden" name="id_voiture" id="id_voiture">
                            <input required type="date" name="date_deb" id="date_deb">
                            <label for="">To</label>
                            <input required type="date" name="date_fin" id="date_fin"><br>
                            <input type="submit" name="reserver" value="Reserver" id="">
                        </form>
                    </div>
                    <div onclick="closeResForm()" class="close">
                        <i class="fa-solid fa-x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>