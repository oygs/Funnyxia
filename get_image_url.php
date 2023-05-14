<?php
session_start();

$imageUrls = file('images.txt', FILE_IGNORE_NEW_LINES);
$excludedIndexes = isset($_SESSION['excluded_indexes']) ? $_SESSION['excluded_indexes'] : array();
$availableIndexes = array_diff(range(0, count($imageUrls) - 1), $excludedIndexes);
if (empty($availableIndexes)) {
    $availableIndexes = range(0, count($imageUrls) - 1);
    $_SESSION['excluded_indexes'] = array();
}
$randomIndex = array_rand($availableIndexes);
$imageUrl = $imageUrls[$availableIndexes[$randomIndex]];
$_SESSION['excluded_indexes'][] = $availableIndexes[$randomIndex];
echo $imageUrl;
?>