<?php 
include_once("../../config/init.php");
if(!isset($_SESSION["username"])){
    header("Location: ../auth/login.php");
}
if(isset($_GET["id"])){
    $idSup=$_GET["id"];
    $query=$conn->prepare("DELETE FROM voiture WHERE id=?");
    $query->execute([$idSup]);
    if($query->rowCount()>0){
        echo("<script>window.location.href='dashboard.php'</script>");
    }
    else{
        echo("<script>alert('eroor lors de la suppriamtion')</script>");
    }
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
                <h1>Admin Panel</h1>
            </div>
            <div class="details">
                <div class="p1">
                    <p><?php echo $_SESSION['username']; ?></p>
                </div>
                <div class="p2">
                    <a href="../auth/logout.php">Log out</a>
                </div>
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
                    <form id="adminForm" action="../admin/dashboard.php" method="get">
                        <div class="search">
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
                        </div>
                        
                        <div class="addButton">
                            <button>Add Car</button>
                        </div>
                    </form>
                    <table border="3">
                        <tr>
                            <th>Marque</th>
                            <th>Modele</th>
                            <th>Annee</th>
                            <th>Immatriculation</th>
                            <th>disponibilité</th>
                            <th>Supprimer</th>
                            <th>Modifier</th>
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
                                        $disres=$disquery->fetch(PDO::FETCH_ASSOC);
                                        $date_deb=new DATETIME($disres["date_deb"]);
                                        $date_fin=new DATETIME($disres["date_fin"]);
                                        $days=$date_deb->diff($date_fin);
                                        echo "Non ( Available in  ".$days->days+1 ." days )";
                                    }
                                    else{
                                        echo "Yes";
                                    }
                                ?></td>
                                <td><button><a onclick="return confirm('Vous etes sur ?');" href="../admin/dashboard.php?id=<?php echo $row["id"] ?>">Supprimer </a></button></td>
                                <td><button>Modifier</button></td>
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