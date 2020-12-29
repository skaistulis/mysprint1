<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="all" href="./css/normalize.css">
    <link rel="stylesheet" type="text/css" media="all" href="./css/style.css">

    <title>Document</title>
</head>
<body>
<?php
//-----------------------------------login----------------------------------
    session_start(); 
    if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
        if ( $_POST['username'] == 'abc' && $_POST['password'] == '123' ) {
            $_SESSION['logged_in'] = true;
            $_SESSION['timeout'] = time();
            $_SESSION['username'] = 'abc';
            header('Location: ./test.php');
        } else $pwmsg = 'You have entered wrong username or password. Please try again.';       

    }
//----------------------------------logout----------------------------------
    if (isset($_GET['action']) and $_GET['action'] == 'logout') {
        session_start();
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        unset($_SESSION['logged_in']);
    }
?>

<form id="login" action="" method="post">
    <h2>LOGIN</h2>
    <br>
    <input class="username" type="text" name="username" placeholder="Username (abc)" required>
    <br>
    <input class="pass" type="password" name="password" placeholder="Password (123)" required>
    <br>
    <button class="btn" type="submit" name="login">Login</button>
    <h4 class="pwmsg"><?php echo $pwmsg;?></h4>
</form>
</body>
</html>