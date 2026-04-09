<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body{
    font-family: Poppins, sans-serif;
    background: #020617;
    color: white;
    text-align: center;
    padding: 50px;
}
h2{
    margin-bottom: 20px;
    font-size: 28px;
}
p{
    font-size: 20px;
    margin: 15px 0;
}
button{
    padding: 12px 25px;
    background: #3b82f6;
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 18px;
    cursor: pointer;
    margin-top: 20px;
}
button:hover{
    background: #2563eb;
}
</style>
</head>
<body>

<h2>🎉 Quiz Completed!</h2>

<?php
// Load last submitted result
$results = json_decode(file_get_contents("results.json"), true) ?? [];
$last = end($results);

if($last){
    echo "<p><b>Name:</b> ".$last['name']."</p>";
    echo "<p><b>Score:</b> ".$last['score']." / ".$last['total']."</p>";

    $passRate = 75; // change if needed
    $passed = ($last['score'] / $last['total'] * 100) >= $passRate;
    echo "<p>".($passed ? "✅ Congratulations! You passed." : "❌ Sorry! You failed.")."</p>";
}
?>

<form action="index.php" method="GET">
    <button type="submit">Back to Start</button>
</form>

</body>
</html>
