<?php 
include_once("../../config/init.php");
if(isset($_SESSION["username"])){
    if($_SESSION["admin"]){
        header("Location: ../admin/dashboard.php");
    }
    else{
        header("Location: ../client/list_voitures.php");
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
    <div class="signPage">
        <div class="container">
            <div class="box">
                <div class="text">
                    <p>Please enter your Details</p>
                    <h1>Welcome Back</h1>
                </div>
                <?php if(isset($_SESSION["loginerror"])):?>
                <div class="alert error">
                    <?php 
                        echo $_SESSION["loginerror"]; 
                        unset($_SESSION["loginerror"]);
                    ?>
                </div>
                <?php endif; ?>
                <div class="details">
                    <form action="../../controllers/authController.php" method="post">
                        <label for="">Email</label>
                        <input type="email" required placeholder="Email adress" name="email" id="email"><br>
                        <label for="">Password</label>
                        <input type="password" required placeholder="Password" name="pass" id="pass"><br>
                        <input type="submit" name="log_in" value="Login" id="login">
                    </form>
                </div>
                <div class="reg">
                    <p>Don't have an account ? <a href="./register.php">Sign up</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>