<?php
session_start();
$questions = json_decode(file_get_contents("questions.json"), true)['NewPart'][0]['Questions'];

// Ask for username if not set
if(!isset($_SESSION['username'])){
    if(isset($_POST['username']) && $_POST['username'] != ""){
        $_SESSION['username'] = htmlspecialchars($_POST['username']);
        $_SESSION['current'] = 0;
        $_SESSION['answers'] = [];
    } else {
        echo '<!DOCTYPE html><html><head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
        body{font-family:Poppins,sans-serif;background:#020617;color:white;text-align:center;padding:50px;}
        input{padding:10px;width:80%;margin:10px 0;border-radius:10px;border:none;}
        button{padding:10px 20px;background:#3b82f6;color:white;border:none;border-radius:10px;font-size:16px;cursor:pointer;}
        </style></head><body>
        <h2>Welcome to the Quiz!</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Enter your name" required><br>
            <button type="submit">Start Quiz</button>
        </form></body></html>';
        exit;
    }
}

// Handle answer submission
if(isset($_POST['answer'])){
    $_SESSION['answers'][$_SESSION['current']] = $_POST['answer'];
    if(isset($_POST['action'])){
        if($_POST['action'] == "Next") $_SESSION['current']++;
        if($_POST['action'] == "Previous") $_SESSION['current']--;
    } else {
        $_SESSION['current']++;
    }
}

// Show question
if($_SESSION['current'] < count($questions)){
    $q = $questions[$_SESSION['current']];
    echo '<!DOCTYPE html><html><head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    body{font-family:Poppins,sans-serif;background:#020617;color:white;padding:20px;}
    h2,h3{margin-bottom:20px;}
    label{display:block;margin:10px 0;padding:10px;background:#1f2937;border-radius:10px;cursor:pointer;}
    input[type=radio]{margin-right:10px;}
    button{padding:10px 20px;background:#3b82f6;color:white;border:none;border-radius:10px;font-size:16px;cursor:pointer;margin-top:20px;margin-right:10px;}
    </style></head><body>';
    echo "<h2>Question ".($_SESSION['current']+1)." of ".count($questions)."</h2>";
    echo "<h3>".$q['Question']."</h3>";
    echo '<form method="POST">';
    foreach($q['Options'] as $opt){
        $checked = (isset($_SESSION['answers'][$_SESSION['current']]) && $_SESSION['answers'][$_SESSION['current']] == $opt['Id']) ? "checked" : "";
        echo '<label><input type="radio" name="answer" value="'.$opt['Id'].'" required '.$checked.'> '.$opt['Choice'].'</label>';
    }

    // Buttons
    if($_SESSION['current'] > 0){
        echo '<button type="submit" name="action" value="Previous">⬅ Previous</button>';
    }

    $buttonText = ($_SESSION['current']+1 == count($questions)) ? "Submit Quiz" : "Next Question";
    echo '<button type="submit" name="action" value="Next">'.$buttonText.'</button>';

    echo '</form></body></html>';
} else {
    // Quiz finished: calculate score and save
    $score = 0;
    foreach($questions as $i=>$q){
        if(isset($_SESSION['answers'][$i]) && $_SESSION['answers'][$i] == $q['Answer']) $score++;
    }
    $result = [
        "name"=>$_SESSION['username'],
        "answers"=>$_SESSION['answers'],
        "score"=>$score,
        "total"=>count($questions)
    ];
    $all_results = json_decode(file_get_contents("results.json"), true) ?? [];
    $all_results[] = $result;
    file_put_contents("results.json", json_encode($all_results, JSON_PRETTY_PRINT));
    session_destroy();
    header("Location: submit.php");
    exit;
}
?>
