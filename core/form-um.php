<?php
function addusr()
{
    include 'dbcon.php';
    require 'steamauth.php';
    require 'SteamConfig.php';
    $usrsteamid = $_POST['usrsteamid'];
    if (strlen($usrsteamid) == 17) {
        $usrpid = $_POST['usrpid'];
        $usrpname = $_POST['usrpname'];
        try {
            $url = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$steamauth['apikey']."&steamids=".$usrsteamid);
            $content = json_decode($url, true);
            $_sudata['steam_personaname'] = $content['response']['players'][0]['personaname'];
            $_sudata['steam_avatarmedium'] = $content['response']['players'][0]['avatarmedium'];
            $stmt = $pdo->prepare("INSERT INTO siteusers (steamname, steamid, steampic, pid, pname) VALUES (?,?,?,?,?) ON DUPLICATE KEY UPDATE steamid=VALUES(steamid);");
            $stmt->execute([$_sudata['steam_personaname'], $usrsteamid, $_sudata['steam_avatarmedium'], $usrpid, $usrpname]);
            header('Location: ../dashboard.php');
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    } else {
        echo "Invalid SteamID64. Redirecting back to dashboard in 5 seconds.";
        header("refresh:5; url=/../dashboard.php");
    }
}

function editusr()
{
    include 'dbcon.php';
    $usrsteamid = $_POST['usrsteamid'];
    $usrpid = $_POST['usrpid'];
    $usrpname = $_POST['usrpname'];
    try {
        $stmt = $pdo->prepare("UPDATE siteusers SET pid= ? , pname= ? WHERE steamid = ?");
        $stmt->execute([$usrpid, $usrpname, $usrsteamid]);
        header('Location: ../dashboard.php');
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
}

function deleteusr()
{
    include 'dbcon.php';
    $uid = $_POST['uid'];
    echo $uid;
    try {
        $stmt = $pdo->prepare("DELETE FROM siteusers WHERE uid = ?");
        $stmt->execute([$uid]);
        header('Location: ../dashboard.php');
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
}

if (isset($_POST['addusr'])):
    addusr();
elseif (isset($_POST['editusr'])):
    editusr();
elseif (isset($_POST['deleteusr'])):
    deleteusr();
else:
    die();
endif;
?>
