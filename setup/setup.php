<?php
include '../core/dbcon.php';
require '../core/steamauth.php';
require '../core/SteamConfig.php';

$servername = ""; //server address/ server ip
$dbname =""; //database name
$username = ""; //db username
$password = ""; //dbpassword
$adminsid64 =""; //steam64ID of default admin DO NOT ADD ANY SYMBOL


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE siteusers (
     uid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
     steamname VARCHAR(50) NOT NULL,
     steamid VARCHAR(50) NOT NULL UNIQUE,
     steampic VARCHAR(150) NOT NULL,
     pid INT(1) DEFAULT '0',
     pname VARCHAR(50) DEFAULT NULL,
     lastip VARCHAR(15) NOT NULL
    )";
    $conn->exec($sql);
    echo "User Datatable created successfully<br>"; //User Table



    //
    $url = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$steamauth['apikey']."&steamids=".$adminsid64);
    $content = json_decode($url, true);
    $_sudata['steam_personaname'] = $content['response']['players'][0]['personaname'];
    $_sudata['steam_avatarmedium'] = $content['response']['players'][0]['avatarmedium'];
    $stmt = $pdo->prepare ("INSERT INTO siteusers (steamname, steamid, steampic, pid, pname)
            VALUES(?, ?, ?, ?, ?)");
    $stmt->execute([$_sudata['steam_personaname'], $adminsid64, $_sudata['steam_avatarmedium'], '1', 'siteadmin']);
    echo "Deafult Admin has been created successfully<br>"; //Deafault Admin Created
    //




    $sql = "CREATE TABLE serverlist (
     sid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
     serverip VARCHAR(15) NOT NULL,
     serverport INT(6) NOT NULL
    )";
    $conn->exec($sql);
    echo "Server Datatable created successfully<br>"; //Server Table
    $sql = "CREATE TABLE sitesetting (
     sid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
     ssn VARCHAR(30) NOT NULL,
     ssvalue VARCHAR(500) NOT NULL
    )";
    $conn->exec($sql);
    echo "SiteSetting Datatable created successfully<br>";
    $sql = "INSERT INTO sitesetting (ssn, ssvalue)
            VALUES('stitle', 'CommunityName'),
                  ('cta', 'Welcome to gmod'),
                  ('fex', 'home of garry newman'),
                  ('f1t', 'professional'),
                  ('f2t', 'friendly'),
                  ('f3t', 'quick'),
                  ('f1d', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
                  ('f2d', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
                  ('f3d', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
                  ('tname', 'default-zen');";
    $conn->exec($sql);
    echo "SiteSetting Datatable has been populated successfully<br>"; //SiteCMS Table
    $sql = "CREATE TABLE sitetheme (
     tid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
     tname VARCHAR(50) NOT NULL,
     tpath VARCHAR(50) NOT NULL)";
    $conn->exec($sql);
    echo "Theme Datatable created successfully<br>"; //Theme Table
    $sql = "INSERT INTO sitetheme (tname, tpath)
            VALUES('default-zen', 'assets/css/default-zen/styles.css'),
                  ('default-dessert', 'assets/css/default-dessert/styles.css'),
                  ('default-wildlife', 'assets/css/default-wildlife/styles.css'),
                  ('default-city', 'assets/css/default-city/styles.css'),
                  ('default-island', 'assets/css/default-island/styles.css'),
                  ('default-christmas', 'assets/css/default-christmas/styles.css')";
    $conn->exec($sql);
    echo "Deafult Themes has been installed successfully<br>"; //Install Theme
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
?>
