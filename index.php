<?php
include "Config.php";
include __DIR__ . "/Classes/class.ChromeHelper.php";

$myChromeHelper = new ChromeHelper();
$myChromeHelper->loginInstagram();
$baseData = $myChromeHelper->getBaseDataOfUser("javaci");
print_r($baseData);
die();
$followersArray = $myChromeHelper->getFollowers("javaci");
$followingArray = $myChromeHelper->getFollowing("javaci");
