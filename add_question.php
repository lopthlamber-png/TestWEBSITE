<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $questionText = trim($_POST['question']);
    $options = [
        trim($_POST['option1']),
        trim($_POST['option2']),
        trim($_POST['option3']),
        trim($_POST['option4']),
    ];
    $correctIndex = $_POST['correct']; // 0,1,2,3

    if(!$questionText || in_array('', $options)){
        $error = "All fields must be filled.";
    } else {
        $data = json_decode(file_get_contents("questions.json"), true);

        // Generate unique IDs
        $partId = $data['NewPart'][0]['Id'];
        $qId = uniqid('Q');

        $questionEntry = [
            "Id"=>$qId,
            "WithSelection"=>false,
            "QuestionType"=>"Multiple Choice",
            "PartType"=>"Multiple Choice",
            "Question"=>$questionText,
            "Answer"=>"", // will set below
            "Options"=>[]
        ];

        foreach($options as $i=>$opt){
            $optId = $partId.$qId."O000".($i+1);
            $questionEntry['Options'][] = [
                "Id"=>$optId,
                "Choice"=>$opt,
                "IsCorrect"=>$i == $correctIndex
            ];
            if($i == $correctIndex){
                $questionEntry['Answer'] = $optId;
            }
        }

        $data['NewPart'][0]['Questions'][] = $questionEntry;

        file_put_contents("questions.json", json_encode($data, JSON_PRETTY_PRINT));
        $success = "Question added successfully!";
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
    background:linear-gradient(135deg,#020617,#1e3a8a);
    color:white;
    padding:20px;
}
h2{text-align:center;margin-bottom:20px;}
input, textarea, select{
    width:100%;
    padding:8px;
    margin:5px 0 10px 0;
    border-radius:8px;
    border:none;
    font-size:14px;
}
button{
    padding:10px 20px;
    background:#22c55e;
    border:none;
    color:white;
    border-radius:12px;
    font-weight:bold;
    cursor:pointer;
}
.message{margin:10px 0;padding:10px;border-radius:10px;}
.success{background:#22c55e;}
.error{background:#ef4444;}
a.button{display:inline-block;margin-top:10px;padding:8px 15px;background:#3b82f6;color:white;text-decoration:none;border-radius:10px;}
</style>
</head>
<body>

<h2>➕ Add New Question</h2>

<?php if(isset($success)): ?>
    <div class="message success"><?php echo $success; ?></div>
<?php endif; ?>
<?php if(isset($error)): ?>
    <div class="message error"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST">
    <label>Question:</label>
    <textarea name="question" required></textarea>

    <label>Option 1:</label>
    <input type="text" name="option1" required>

    <label>Option 2:</label>
    <input type="text" name="option2" required>

    <label>Option 3:</label>
    <input type="text" name="option3" required>

    <label>Option 4:</label>
    <input type="text" name="option4" required>

    <label>Correct Answer:</label>
    <select name="correct">
        <option value="0">Option 1</option>
        <option value="1">Option 2</option>
        <option value="2">Option 3</option>
        <option value="3">Option 4</option>
    </select>

    <button type="submit">Add Question</button>
</form>

<a href="admin.php" class="button">⬅ Back to Admin Dashboard</a>

</body>
</html>
