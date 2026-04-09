<?php
$results = json_decode(file_get_contents("results.json"), true) ?? [];

// Sort users by completion time (assuming newer users are appended at the end)
$results = array_reverse($results);

// Generate leaderboard sorted by score descending
$leaderboard = $results;
usort($leaderboard, function($a, $b){
    return $b['score'] - $a['score'];
});

// Display leaderboard
echo "<h3>🏆 Leaderboard</h3>";
echo "<ol>";
foreach($leaderboard as $user){
    echo "<li>".$user['name']." - ".$user['score']."/".$user['total']."</li>";
}
echo "</ol>";

// Display user results
foreach($results as $idx=>$user): ?>
<div class="user-card">
    <div class="user-header">
        <span onclick="toggleDetails('details<?php echo $idx; ?>')"><?php echo $user['name']; ?></span>
        <span><?php echo $user['score']."/".$user['total']; ?>
        <a href="javascript:void(0);" style="background:#ef4444;" onclick="deleteUser('<?php echo $user['name']; ?>')">Delete</a></span>
    </div>
    <div class="details" id="details<?php echo $idx; ?>">
        <?php
        $questions = json_decode(file_get_contents("questions.json"), true)['NewPart'][0]['Questions'];
        foreach($user['answers'] as $i=>$ans):
            $q = $questions[$i];
            $ua_text = ''; foreach($q['Options'] as $opt) if($opt['Id']==$ans) $ua_text=$opt['Choice'];
            $correct_text=''; foreach($q['Options'] as $opt) if($opt['Id']==$q['Answer']) $correct_text=$opt['Choice'];
        ?>
        <div><b>Q<?php echo $i+1; ?>:</b> <?php echo $q['Question']; ?><br>
            Your Answer: <span class="<?php echo ($ans==$q['Answer'])?'correct':'incorrect'; ?>"><?php echo $ua_text; ?></span><br>
            Correct Answer: <span class="correct"><?php echo $correct_text; ?></span>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endforeach; ?>
