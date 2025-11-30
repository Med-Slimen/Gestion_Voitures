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