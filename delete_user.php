<?php
session_start();
if(!isset($_SESSION['admin'])){
    echo "Not authorized";
    exit;
}

if(!isset($_GET['name'])) exit;

$nameToDelete = $_GET['name'];
$resultsFile = "results.json";
$results = file_exists($resultsFile) ? json_decode(file_get_contents($resultsFile), true) : [];

// Filter out the user
$results = array_filter($results, function($r) use($nameToDelete){
    return $r['name'] !== $nameToDelete;
});

file_put_contents($resultsFile, json_encode(array_values($results), JSON_PRETTY_PRINT));
echo "Deleted";
