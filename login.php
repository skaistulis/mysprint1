<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" media="all" href="./css/normalize.css">
    <link rel="stylesheet" type="text/css" media="all" href="./css/style.css">

    <title>Document</title>
</head>
<body>
<?php
session_start();
       
        if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password']) ) {
            if ( $_POST['username'] == 'admin' && $_POST['password'] == 'admin' ) {
                $_SESSION['logged_in'] = true;
                $_SESSION['timeout'] = time();
                $_SESSION['username'] = 'admin';
                header('location: ./test.php');
            } else {
                $pwmsg = 'Wrong username or password';
            }
        }
?>

<form id="login" action="" method="post">
<h2>LOGIN</h2>
<br>
<input class="username" type="text" name="username" placeholder="User Name (try: admin)" required>
<br>
<input class="pass" type="password" name="password" placeholder="Password (try: admin)" required>
<br>
<button class="btn" type="submit" name="login">Login</button>
<h4 class="pwmsg"><?php echo $pwmsg;?></h4>


</form>
</body>
</html>