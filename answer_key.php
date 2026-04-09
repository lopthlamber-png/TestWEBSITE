<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

// Load questions
$questions = json_decode(file_get_contents("questions.json"), true)['NewPart'][0]['Questions'];
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body{
    font-family:Poppins,sans-serif;
    background:linear-gradient(135deg,#020617,#1e3a8a);
    color:white;
    padding:20px;
}
h2{text-align:center;margin-bottom:20px;}
.question{
    background:rgba(34,197,94,0.1);
    padding:12px;
    border-radius:12px;
    margin-bottom:10px;
}
.correct{color:#22c55e;font-weight:bold;}
a.button{
    display:inline-block;
    margin:10px 0;
    padding:10px 20px;
    background:#3b82f6;
    color:white;
    border-radius:12px;
    text-decoration:none;
    font-weight:bold;
}
</style>
</head>
<body>

<h2>📖 Answer Key</h2>

<?php foreach($questions as $i=>$q):
    $correct_text = '';
    foreach($q['Options'] as $opt){
        if($opt['Id'] == $q['Answer']){
            $correct_text = $opt['Choice'];
        }
    }
?>
<div class="question">
    <b>Q<?php echo $i+1; ?>:</b> <?php echo $q['Question']; ?><br>
    Correct Answer: <span class="correct"><?php echo $correct_text; ?></span>
</div>
<?php endforeach; ?>

<a href="admin.php" class="button">⬅ Back to Admin Dashboard</a>

</body>
</html>
