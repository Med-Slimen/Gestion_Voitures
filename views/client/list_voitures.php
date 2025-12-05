<?php 
include_once("../../config/init.php");
if(!isset($_SESSION["username"])){
    header("Location: ../auth/login.php");
}
$query2=$conn->query("SELECT DISTINCT(marque) from voiture");
if(isset($_GET["search2"])){
    $dateDeb=$_GET["date_deb"];
    $dateFin=$_GET["date_fin"];
    $marque=$_GET["marque_list"];
    if($marque=="all"){
        $query=$conn->prepare("SELECT * 
        from voiture v
        where v.id not in (Select id_voiture
                                from reservations
                                where date_deb<=? and date_fin>=?)");
        $query->execute([$dateFin,$dateDeb]);
    }
    else{
        $query=$conn->prepare("SELECT * 
        from voiture v
        where marque=? and v.id not in (Select id_voiture
                                from reservations
                                where date_deb<=? and date_fin>=?)");
        $query->execute([$marque,$dateFin,$dateDeb]);
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
    <?php if(isset($_SESSION["reservation_success"])): ?>
    <div class="alert success">
        <?php 
            echo $_SESSION["reservation_success"]; 
            unset($_SESSION["reservation_success"]);
        ?>
    </div>
    <?php endif; ?>
    <div class="main">
        <div class="container">
            <div class="box">
                <div class="text">
                    <h1>Cars List</h1>
                </div>
                <div class="details">
                    <hr>
                    <form action="./list_voitures.php" onsubmit="return verifDate()" method="get">
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
                        <label for="">From</label>
                        <input type="date" required name="date_deb" value="<?php echo isset($dateDeb) ? $dateDeb : ""; ?>" id="date_deb">
                        <label for="">To</label>
                        <input type="date" required name="date_fin" id="date_fin" value="<?php echo isset($dateFin) ? $dateFin : ""; ?>">
                        <input type="submit" name="search2" value="Search" id="">
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
                            <th>Reserver</th>
                        </tr>
                         <?php
                         if(!isset($query)){
                            ?>
                            <tr>
                                <td colspan="6">Selectionner une date</td>
                            </tr>
                        <?php
                         }
                        else if($query->rowCount()==0){
                            ?>
                            <tr>
                                <td colspan="6">No cars found</td>
                            </tr>
                        <?php
                        }
                        else{
                        while($row=$query->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <tr>
                                <td><?php echo $row["marque"] ;?></td>
                                <td><?php echo $row["modele"] ;?></td>
                                <td><?php echo $row["annee"] ;?></td>
                                <td><?php echo $row["immat"] ;?></td>
                                <td><button onclick="showRes('<?php echo $row['marque']?>','<?php echo $row['modele']?>','<?php echo $row['annee']?>','<?php echo $row['immat']?>','<?php echo $row['id'];?>')" class="clickable" >Reserver</button></td>
                            </tr>
                        <?php
                        }
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
                            <input required readonly type="date" value="<?php echo $dateDeb ?>" name="date_deb" id="date_deb">
                            <label for="">To</label>
                            <input required readonly type="date" value="<?php echo $dateFin ?>" name="date_fin" id="date_fin"><br>
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