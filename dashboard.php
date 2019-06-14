<?php
include 'core/dbcon.php';
require 'core/steamauth.php';
require 'core/functions.php';
$stmt = $pdo->prepare("SELECT ssvalue FROM sitesetting");
$stmt->execute();
$ssdata = $stmt->fetchAll(PDO::FETCH_COLUMN);
if(!isset($_SESSION['steamid'])) {
    header("Location: ../error.php");
    die();
}
else {
    securecheck::chkusrreg();
}
?>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $ssdata[0]; ?> | Dashboard</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,900" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/styles-db.css">
</head>
<div>
<div class="container">
<br>
<br>
<div class="row">
<div class="col-md-6"><h1><?php echo $ssdata[0]; ?> <b>Dashboard</b></h1></div>
<div class="col-md-6"><?php logoutbutton();?></div>
</div>
<hr>
<br>
<ul class="nav nav-pills" id="pills-tab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-ss" role="tab" aria-controls="pills-home" aria-selected="true"><i class="fa fa-wrench" aria-hidden="true"></i> <b>site</b> settings</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-um" role="tab" aria-controls="pills-profile" aria-selected="false"><i class="fa fa-gavel fa-rotate-90" aria-hidden="true"></i> <b>user</b> management</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-sv" role="tab" aria-controls="pills-contact" aria-selected="false"><i class="fa fa-bolt" aria-hidden="true"></i> <b>server</b> query</a>
  </li>
  <li class="nav-item">

  </li>
</ul>
<br>
<hr>
<br>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-ss" role="tabpanel" aria-labelledby="pills-home-tab">
    <form method="post" action="core/form.php">
    <div class="input-group">
      <input type="text" class="form-control" name="stitle" value="<?php echo $ssdata[0]; ?>">
    </div>
    <p>Site Title</p>
    <div class="input-group">
      <input type="text" class="form-control" name="cta" value="<?php echo $ssdata[1]; ?>">
    </div>
    <p>Call To Action</p>
    <div class="input-group">
      <input type="text" class="form-control" name="fex" value="<?php echo $ssdata[2]; ?>">
    </div>
    <p>Features Explanation</p>
    <div class="row">
      <div class="col-md-4">
         <div class="input-group">
           <input type="text" class="form-control" name="f1t" value="<?php echo $ssdata[3]; ?>">
         </div>
         <p>Feature 1 title</p>
         <div class="input-group">
           <textarea class="form-control" name="f1d" rows="10"><?php echo $ssdata[6]; ?></textarea>
         </div>
         <p>Feature 1 description</p>
      </div>
      <div class="col-md-4">
         <div class="input-group">
           <input type="text" class="form-control" name="f2t" value="<?php echo $ssdata[4]; ?>">
         </div>
         <p>Feature 2 title</p>
         <div class="input-group">
           <textarea class="form-control" name="f2d" rows="10"><?php echo $ssdata[7]; ?></textarea>
         </div>
         <p>Feature 2 description</p>
      </div>
      <div class="col-md-4">
         <div class="input-group">
           <input type="text" class="form-control" name="f3t" value="<?php echo $ssdata[5]; ?>">
         </div>
         <p>Feature 3 title</p>
         <div class="input-group">
           <textarea class="form-control" name="f3d" rows="10"><?php echo $ssdata[8]; ?></textarea>
         </div>
         <p>Feature 3 description</p>
      </div>
    </div>
    <select class="form-control input-group" name="tname" required>
      <?php
      $stmt = $pdo->prepare("SELECT tname  FROM sitetheme");
      $stmt->execute();
      while ($stdata = $stmt->fetch(PDO::FETCH_ASSOC))
      {
       $themename = $stdata['tname'];
       if ($themename == $ssdata[9]) {
         echo '<option selected>'.$themename.'</option>';
       }
       else {
         echo '<option>'.$themename.'</option>';
       }
      }
      ?>
    </select>
    <p>Site Theme</p>
    <button type="submit" class="btn btn-outline-secondary" >save</button>
    </form>
</div>
  <div class="tab-pane fade" id="pills-um" role="tabpanel" >
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ausrmodal">Add A User</button>
    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#eusrmodal">Edit A User</button>
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#dusrmodal">Delete A User</button>
    <br><br>
      <div class="modal fade" id="ausrmodal" tabindex="-1" role="dialog" aria-labelledby="ausrmodal" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Add A User</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <form method="post" action="core/form-um.php">
                      <div class="modal-body">
                          <div class="input-group">
                              <input type="number" class="form-control" name="usrsteamid" size="17" required>
                          </div>
                          <p>steamid // must be steamid 64</p>
                          <div class="input-group">
                              <select class="form-control" name="usrpid">
                                  <option>0</option>
                                  <option>1</option>
                              </select>
                          </div>
                          <p>Permission // 0 for no access / 1 for admin access</p>
                          <div class="input-group">
                              <input type="text" class="form-control" name="usrpname">
                          </div>
                          <p>Staff Title // Remain empty for no display</p>
                      </div>
                      <div class="modal-footer"><button type="submit" class="btn btn-info" name="addusr">Confirm</button></div>
                  </form>
              </div>
          </div>
      </div>
      <div class="modal fade" id="eusrmodal" tabindex="-1" role="dialog" aria-labelledby="eusrmodal" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Edit A User</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <form method="post" action="core/form-um.php">
                      <div class="modal-body">
                          <div class="input-group">
                              <input type="number" class="form-control" name="usrsteamid" required>
                          </div>
                          <p>User's steam64 ID </p>
                          <div class="input-group">
                              <select class="form-control" name="usrpid">
                                  <option>0</option>
                                  <option>1</option>
                              </select>
                          </div>
                          <p>User's Permission // 0 for no access / 1 for admin access</p>
                          <div class="input-group">
                              <input type="text" class="form-control" name="usrpname">
                          </div>
                          <p>Staff Title // Remain empty for no display</p>
                      </div>
                      <div class="modal-footer"><button type="submit" class="btn btn-warning" name="editusr">Confirm</button></div>
                  </form>
              </div>
          </div>
      </div>
      <div class="modal fade" id="dusrmodal" tabindex="-1" role="dialog" aria-labelledby="dusrmodal" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Delete A User</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <form method="post" action="core/form-um.php">
                      <div class="modal-body">
                          <div class="input-group">
                              <input type="number" class="form-control" name="uid" required>
                          </div>
                          <p>uid of user to be deleted // Can be found in the table</p>
                      </div>
                      <div class="modal-footer"><button type="submit" class="btn btn-danger" name="deleteusr">Confirm</button></div>
                  </form>
              </div>
          </div>
      </div>
    <br>
    <?php
    $stmt = $pdo->prepare("SELECT uid, steamname, steamid, pid, pname, lastip  FROM siteusers");
    $stmt->execute();
    echo '<table class="table">
    <thead>
      <tr>
        <th>uid</th>
        <th>steamname</th>
        <th>steamid</th>
        <th>permission level</th>
        <th>staff title</th>
        <th>lastip</th>
      </tr>
    </thead>
    <tbody>';
    while ($umdata = $stmt->fetch(PDO::FETCH_ASSOC))
    {$uid = $umdata['uid'];
    $steamname = $umdata['steamname'];
    $steamid = $umdata['steamid'];
    $pid = $umdata['pid'];
    $pname = $umdata['pname'];
    $lastip = $umdata['lastip'];
    echo '<tr><td>'.$uid.'</td>';
    echo '<td>'.$steamname.'</td>';
    echo '<td>'.$steamid.'</td>';
    echo '<td>'.$pid.'</td>';
    echo '<td>'.$pname.'</td>';
    echo '<td>'.$lastip.'</td></tr>';
    }
    echo '</tbody></table>';
    ?>
    <hr>
  </div>
  <div class="tab-pane fade" id="pills-sv" role="tabpanel">
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#asvmodal">Add A Server</button>
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#dsvmodal">Delete A Server</button>
    <br>
    <br>
    <div class="modal fade" id="asvmodal" tabindex="-1" role="dialog" aria-labelledby="asvmodal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add A Server</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <form method="post" action="core/form-sv.php">
          <div class="modal-body">
            <div class="input-group">
              <input type="text" class="form-control" name="svip" required>
            </div>
            <p>server ip</p>
            <div class="input-group">
              <input type="text" class="form-control" name="svport" required>
            </div>
            <p>server port</p>
          </div>
          <div class="modal-footer"><button type="submit" class="btn btn-info" name="adsv">Proceed</button></div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="dsvmodal" tabindex="-1" role="dialog" aria-labelledby="dsvmodal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete A Server</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <form method="post" action="core/form-sv.php">
          <div class="modal-body">
            <div class="input-group">
              <input type="text" class="form-control" name="svid" required>
            </div>
            <p>server id // Can be found in the table</p>
          </div>
          <div class="modal-footer"><button type="submit" class="btn btn-warning" name="dlsv">Confirm</button></div>
        </form>
        </div>
      </div>
    </div>
    <?php
    $stmt = $pdo->prepare("SELECT sid, serverip, serverport FROM serverlist");
    $stmt->execute();
    echo '<table class="table"><thead><tr><th>serverid</th><th>serverip</th><th>serverport</th></tr></thead><tbody>';
    while ($svdata = $stmt->fetch(PDO::FETCH_ASSOC)){
    echo '<tr><td>'.$svdata['sid'].'</td><td>'.$svdata['serverip'].'</td><td>'.$svdata['serverport'].'</td></tr>';
    }
    echo '</tbody></table>';
    ?>
  </div>
</div>
<br>
<hr>
<footer>
<?php echo $ssdata[0]; ?> // All Rights Reserved // Site by <a href="https://steamcommunity.com/id/vivedigitalsOMNI/">levitate
<br>
<hr>
<img src="assets/img/logo01.png" class="f-logo" />

<br><br>
</footer>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script> toastr.success('Welcome <?php echo $_SESSION['steam_personaname']; ?>, Your ip have been logged.','Hello You!')</script>
</html>
