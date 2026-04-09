<?php
session_start();
if(!isset($_SESSION['admin'])) header("Location: login.php");

$questionsFile = "questions.json";
$data = json_decode(file_get_contents($questionsFile), true);
$questions = $data['NewPart'][0]['Questions'] ?? [];
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body{font-family:Poppins,sans-serif;background:#020617;color:white;padding:20px;}
h2{text-align:center;margin-bottom:20px;}
a.button{display:inline-block;margin:5px;padding:6px 12px;background:#3b82f6;color:white;text-decoration:none;border-radius:10px;}
.q-card{background:rgba(255,255,255,0.08);padding:10px;border-radius:10px;margin-bottom:5px;}
</style>
<script>
function deleteQuestion(id){
    if(confirm("Delete this question?")){
        fetch("delete_question.php?id="+encodeURIComponent(id)).then(()=>location.reload());
    }
}
</script>
</head>
<body>
<h2>📝 Manage Questions</h2>
<a href="admin.php" class="button">⬅ Back to Dashboard</a>
<a href="add_question.php" class="button" style="background:#facc15;">➕ Add Question</a>

<?php foreach($questions as $q): ?>
<div class="q-card">
    <b><?php echo $q['Question']; ?></b>
    <a href="javascript:void(0);" onclick="deleteQuestion('<?php echo $q['Id']; ?>')" style="background:#ef4444;" class="button">Delete</a>
</div>
<?php endforeach; ?>
</body>
</html>
