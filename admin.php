<?php
session_start();
if(!isset($_SESSION['admin'])) header("Location: login.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body{font-family:Poppins,sans-serif;background:#020617;color:white;padding:20px;}
h2{text-align:center;margin-bottom:20px;}
a.button{display:inline-block;margin:5px;padding:6px 12px;background:#3b82f6;color:white;text-decoration:none;border-radius:10px;}
.user-card{background:rgba(255,255,255,0.08);padding:12px;border-radius:12px;margin:10px 0;}
.user-header{display:flex;justify-content:space-between;font-weight:bold;cursor:pointer;}
.details{display:none;margin-top:10px;border-top:1px solid rgba(255,255,255,0.2);padding-top:5px;}
.correct{color:#22c55e;font-weight:bold;}
.incorrect{color:#ef4444;font-weight:bold;}
</style>
<script>
// Toggle user answers
function toggleDetails(id){
    var e=document.getElementById(id);
    e.style.display=(e.style.display==="block")?"none":"block";
}
// Delete user results
function deleteUser(name){
    if(confirm("Delete results of "+name+"?")){
        fetch("delete_user.php?name="+encodeURIComponent(name)).then(()=>fetchResults());
    }
}
// Fetch results + leaderboard
function fetchResults(){
    fetch('fetch_results.php')
    .then(r=>r.text())
    .then(html=>document.getElementById('results').innerHTML=html);
}
setInterval(fetchResults,5000);
window.onload=fetchResults;
</script>
</head>
<body>

<h2>🏆 Admin Dashboard</h2>

<a href="logout.php" class="button">Logout</a>
<a href="add_question.php" class="button" style="background:#facc15;">➕ Add Question</a>
<a href="manage_questions.php" class="button" style="background:#10b981;">📝 Manage Questions</a>
<a href="answer_key.php" class="button" style="background:#22c55e;">📖 Answer Key</a>

<h3>👥 User Results</h3>
<div id="results"></div>

</body>
</html>
