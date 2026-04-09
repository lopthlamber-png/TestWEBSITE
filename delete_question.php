<?php
session_start();
if(!isset($_SESSION['admin'])) exit;

if(isset($_GET['id'])){
    $data = json_decode(file_get_contents("questions.json"), true);
    $part = &$data['NewPart'][0]['Questions'];
    $part = array_filter($part, function($q){
        return $q['Id'] !== $_GET['id'];
    });
    $part = array_values($part); // reindex
    file_put_contents("questions.json", json_encode($data, JSON_PRETTY_PRINT));
}
?>
