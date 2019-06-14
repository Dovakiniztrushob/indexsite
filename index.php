<?php
include 'core/dbcon.php';
require 'core/steamauth.php'; // Load OpenID library
require 'core/SteamConfig.php';
require __DIR__ . '/squery/bootstrap.php'; //Load Server Query Lib
use xPaw\SourceQuery\SourceQuery;
use phpFastCache\CacheManager; //Cache Lib
require __DIR__ . '/cache/src/autoload.php';
$InstanceCache = CacheManager::getInstance('devnull');
$key = "page_content";
$ssdata2 = $InstanceCache->getItem($key);
if (is_null($ssdata2->get())) {
    $stmt = $pdo->prepare("SELECT ssvalue FROM sitesetting");
    $stmt->execute();
    $ssdata3 = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $ssdata2->set($ssdata3)->expiresAfter(1200); //caching time in seconds
    $InstanceCache->save($ssdata2);
    $ssdata = $ssdata2->get();
} else {
    $ssdata = $ssdata2->get();
}
$stmt = $pdo->prepare("SELECT tpath FROM sitetheme WHERE tname = ?");
$stmt->execute([$ssdata[9]]);
$stdata = $stmt->fetch(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $ssdata[0]; ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo $stdata; ?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>

<body>
<div class="jumbotron pageheader01">
  <div class="navwrapper">
        <nav class="navbar navbar-toggleable-md pageheader01-navbar">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">-Home-</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="nb-features">-Features-</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="nb-staff">-Staff-</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="nb-server">-Server-</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="pageheader01-contentbox">
      <div class="cbwrapper">
            <h1 class="display-3"><?php echo $ssdata[1]; ?></h1>
            <p class="lead"><?php echo $ssdata[2]; ?></p>
      </div>
    </div>
</div>
<div class="container-fluid pagefeature" id="pagefeature">
    <h2 class="display-4 pageglobal-headericon"><i class="fa fa-diamond" aria-hidden="true"></i></h2>
    <h4 class="display-5 pageglobal-headertitle">- Features -</h4>
    <p class="lead pageglobal-headersubtitle">Three reason explaining why you should choose us</p>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="pagefeature-card">
                    <div class="pagefeature-cardtitle"><?php echo $ssdata[3]; ?></div>
                    <div class="pagefeature-cardicon"><i class="fa fa-cogs pagefeature-cardiconspl" aria-hidden="true"></i></div>
                    <div class="pagefeature-carddescription"><?php echo $ssdata[6]; ?></div>
                </div>
        </div>
        <div class="col-md-4">
            <div class="pagefeature-card">
                <div class="pagefeature-cardtitle"><?php echo $ssdata[4]; ?></div>
                <div class="pagefeature-cardicon"><i class="fa fa-user-plus pagefeature-cardiconspl" aria-hidden="true"></i></div>
                <div class="pagefeature-carddescription"><?php echo $ssdata[7]; ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="pagefeature-card">
                <div class="pagefeature-cardtitle"><?php echo $ssdata[5]; ?></div>
                <div class="pagefeature-cardicon"><i class="fa fa-flask pagefeature-cardiconspl" aria-hidden="true"></i></div>
                <div class="pagefeature-carddescription"><?php echo $ssdata[8]; ?></div>
            </div>
        </div>
    </div>
    </div>
</div>
<div class="container-fluid pagestaff" id="pagestaff">
    <div class="pagestaff-title">
    <h2 class="display-4 pageglobal-headericon ph2"><i class="fa fa-bullhorn" aria-hidden="true"></i></h2>
    <h4 class="display-5 pageglobal-headertitle ph2">- Staff -</h4>
    <p class="lead pageglobal-headersubtitle ph2">A list of our friendly staff</p>
    <br>
    </div>
    <div class="container">
        <div class="row">
          <?php
          $key2 = "page_staff";
          $stafflist2 = $InstanceCache->getItem($key2);
          if (is_null($stafflist2->get())) {
              $stmt = $pdo->prepare("SELECT steamname, steamid, steampic, pname FROM siteusers WHERE pname is not null AND pname !=''");
              $stmt->execute();
              $stafflist3 = array();
              while ($sudata = $stmt->fetch(PDO::FETCH_ASSOC))
              {
                  $url = file_get_contents("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$steamauth['apikey']."&steamids=".$sudata['steamid']);
                  $content = json_decode($url, true);
                  $_sudata['steam_personastate'] = $content['response']['players'][0]['personastate'];
                  $status_output_array = ["Offline", "Online", "Busy", "Away", "Snooze", "Looking to trade", "Looking to play"];
                  $status_output = $status_output_array[$_sudata['steam_personastate']];
                  $stafflist3[] = '<div class="col-md-6"><div class="pagestaff-steaminfobox"><div class="pagestaff-steamname">'.$sudata['steamname'].'</div><div class="pagestaff-steamposition">'.$sudata['pname'].'</div><p class="pagestaff-steamstatus">'.$status_output.'</p>
          </div><img class="pagestaff-steamavatar" src="'.$sudata['steampic'].'" alt="notfound"></div>';
              }
              $stafflist2->set($stafflist3)->expiresAfter(600); //caching time in seconds
              $InstanceCache->save($stafflist2);
              $stafflist = $stafflist2->get();
              foreach ($stafflist as $key => $val) {
                  echo $val;
              }
          } else {
              $stafflist = $stafflist2->get();
              foreach ($stafflist as $key => $val) {
                  echo $val;
              }
          } ?>
        </div>
    </div>
</div>
<div class="container-fluid pageserver" id="pageserver">
    <div class="pageserver-title">
        <h2 class="display-4 pageglobal-headericon ph2"><i class="fa fa-cubes" aria-hidden="true"></i></h2>
        <h4 class="display-5 pageglobal-headertitle ph2">- Servers -</h4>
        <p class="lead pageglobal-headersubtitle ph2">Join our servers listed below</p>
        <br>
    </div>
    <div class="container">
      <div class="row">
        <?php
        $stmt = $pdo->prepare("SELECT serverip, serverport FROM serverlist");
        $stmt->execute();
        while ($svdata = $stmt->fetch(PDO::FETCH_ASSOC))
        {
        $svip = $svdata['serverip'];
        $svp = $svdata['serverport'];
        $svipp = $svip.':'.$svp; //merge ip and port number
        $Query = new SourceQuery( );
      	try
      	{
      		$Query->Connect( $svip, $svp, 1, SourceQuery::SOURCE );
      		$svqdata = ( $Query->GetInfo( ) );
          echo '<div class="col-md-6">
            <a class="sv-joinbtn" href="steam://connect/'.$svipp.'">
              <i class="fa fa-paper-plane" aria-hidden="true"></i>
              <div>connect</div>
            </a>
            <div class="sv-wrapper">
              <div class="sv-apptitle">'.$svqdata['ModDir'].'</div>
              <div class="sv-title">'.$svqdata['HostName'].'</div>
              <hr>
              <div class="row">
                <div class="col-md-6">
                  <div class="sv-cnumber">'.$svqdata['Players'].'<b> / players</b></div>
                </div>
                <div class="col-md-6">
                  <div class="sv-cnumber">'.$svqdata['MaxPlayers'].' <b>/ max</b></div>
                </div>
              </div>
              <hr>
              <div class="sv-cinfo">'.$svipp.'</div>
              <br>
            </div>
          </div>';
      	}
      	catch( Exception $e )
      	{
      		echo $e->getMessage( );
      	}
      	finally
      	{
      		$Query->Disconnect( );
      	}
        }?>
    </div>
    </div>
</div>
<img src="assets/img/footer.svg" class="footer-img" alt="not-found">
<footer>
  <div class="container">
    <div class="ft-wrapper">
    <div class="row">
      <div class="col-md-10">
        <div class="ft-title"><?php echo $ssdata[0]; ?></div>
      </div>
      <div class="col-md-2 ft-btnwrapper">
        <?php
        if(!isset($_SESSION['steamid'])) {
            loginbutton();
        }  else {
            logoutbutton();
        }
        ?>
      </div>
    </div>
    <div class="w-hr"></div>
    <a class="ft-linksfix" href="#">Forums</a>|<a href="#">Steam Group</a>|<a href="#">Donate</a>
    <div class="ft-des">All Right Reserved 2017 // Powered by Steam // Site by levitate design</div>
  </div>
  </div>
</footer>

<script src="https://code.jquery.com/jquery-3.2.1.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script>
$("#nb-features").click(function() {
    $('html, body').animate({
        scrollTop: $("#pagefeature").offset().top
    }, 2000);
});
$("#nb-staff").click(function() {
    $('html, body').animate({
        scrollTop: $("#pagestaff").offset().top
    }, 2000);
});
$("#nb-server").click(function() {
    $('html, body').animate({
        scrollTop: $("#pageserver").offset().top
    }, 2000);
});
</script>
</body>
</html>
