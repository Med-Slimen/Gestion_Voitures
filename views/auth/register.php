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
                    <h1>Sign up for a new account !</h1>
                </div>
                <div class="details">
                    <form action="../../controllers/authController.php" method="post">
                        <label for="">Username</label>
                        <input type="text" required placeholder="Username" name="username" id="username"><br>
                        <label for="">Email</label>
                        <input type="email" required placeholder="Email adress" name="email" id="email"><br>
                        <label for="">Password</label>
                        <input type="password" required placeholder="Password" name="pass" id="pass"><br>
                        <label for="">Adresse</label>
                        <input type="text" required placeholder="Adresse" name="add" id="add"><br>
                        <label for="">Phone number</label>
                        <input type="text" required placeholder="Phone number" name="phone" id="phone"><br>
                        <input type="submit" name="register" value="Sign up" id="register">
                    </form>
                </div>
                <div class="reg">
                    <p>Already have an account ? <a href="./login.php">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>