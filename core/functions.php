<?php
include 'dbcon.php';
require 'userInfo.php';

class securecheck
{
 function getipaddr()
 {
     if (!empty($_SERVER['HTTP_CLIENT_IP']))
     {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
     }
     elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
     {
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
     }
     else
     {
        $ip=$_SERVER['REMOTE_ADDR'];
     }
     return ($ip);
 }

 function chkusrreg()
 {
    global $pdo;
    $ip = self::getipaddr();
    $stmt = $pdo->prepare("SELECT steamid, pid from siteusers where steamid = ?");
    $stmt->execute([$_SESSION['steamid']]);
    if ($stmt->fetchColumn() > 0){
        $stmt = $pdo->prepare("UPDATE siteusers SET lastip = ? WHERE steamid = ?");
        $stmt->execute([$ip, $_SESSION['steamid']]);
        self::checkperm();
     }
     else
     {
        $stmt = $pdo->prepare("INSERT INTO siteusers (steamname,steamid,lastip) VALUES (?, ?, ?)");
         $stmt->execute([$_SESSION['steam_personaname'],$_SESSION['steamid'],$ip]);
        self::checkperm();
     }
 }

 function checkperm()
 {
   global $pdo;
   $stmt = $pdo->prepare("SELECT pid from siteusers where steamid = ?");
   $stmt->execute([$_SESSION['steamid']]);
   $pid = $stmt->fetchColumn();
   if ($pid == 1){
     echo "";
   }
   else{
     header("Location: ../error.php");
     die();
   }
  }

}
