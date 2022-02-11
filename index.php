<?php
include "Config.php";
include __DIR__ . "/Classes/class.ChromeHelper.php";

$myChromeHelper = new ChromeHelper();
$myChromeHelper->loginInstagram();
$followersArray = $myChromeHelper->getFollowers("car8state");
echo "Followers->";
print_r($followersArray);
$followingArray = $myChromeHelper->getFollowing("car8state");

echo "Following->";
print_r($followingArray);