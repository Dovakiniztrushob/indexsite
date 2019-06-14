<?php
//DB Detail - Must be same as setup.php
$servername = "localhost";
$dbname = "ravenous_index";
$username = "ravenous_index";
$password = "Mitch123413";
//Config for Sign IN Through Steam
$steamapik = "91A9F780BBDDB12BC49CA5A758341768"; // Your Steam WebAPI-Key found at http://steamcommunity.com/dev/apikey
$sdomain = "https://ravenousrp.com"; // your domain where this is hosted on

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo $e->getMessage();
    exit;
}
?>
