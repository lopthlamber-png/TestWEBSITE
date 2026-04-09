<?php
session_start();
$ADMIN_USER = "admin";
$ADMIN_PASS = "12345";
$error = "";

if(isset($_POST['username']) && isset($_POST['password'])){
    if($_POST['username'] === $ADMIN_USER && $_POST['password'] === $ADMIN_PASS){
        $_SESSION['admin'] = true;
        header("Location: admin.php");
        exit;
    } else {
        $error = "Wrong username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body{
    font-family:Poppins,sans-serif;
    background:linear-gradient(135deg,#0f172a,#1e3a8a);
    color:white;
    text-align:center;
    padding-top:100px;
}
input{
    padding:12px;
    margin:5px 0;
    border-radius:12px;
    border:none;
    width:80%;
}
button{
    padding:12px 25px;
    border:none;
    border-radius:12px;
    background:#3b82f6;
    color:white;
    font-weight:bold;
    margin-top:10px;
}
.error{
    color:#ef4444;
    margin-bottom:15px;
}
</style>
</head>
<body>

<h2>Admin Login</h2>

<form method="POST">
<?php if($error): ?>
<div class="error"><?php echo $error; ?></div>
<?php endif; ?>
<input type="text" name="username" placeholder="Username" required><br>
<input type="password" name="password" placeholder="Password" required><br>
<button type="submit">Login</button>
</form>

</body>
</html>
