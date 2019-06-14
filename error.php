<?php
include 'core/dbcon.php';
$stmt = $pdo->prepare("SELECT ssvalue FROM sitesetting");
$stmt->execute();
$ssdata = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $ssdata[0]; ?> | Access Denied</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,900" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/styles-2.css">
</head>
<body>
<div class="container">
<br>
<br>
<h1><?php echo $ssdata[0]; ?> <br><b style="color: #ff1660;">Access Denied</b></h1>
<br>
<hr>
<br>
<div class="jumbotron">
  <h1 class="display-3">403 No Access</h1>
  <p class="lead">You are on this page because you do not have site administrator priviledges to access restricted content.</p>
  <hr class="my-4">
  <p>If you believe that this is an error please contact our support staff.</p>
  <p class="lead">
    <a class="btn btn btn-secondary" href="/" role="button">Go Back</a>
  </p>
</div>
<hr>
<footer>
<?php echo $ssdata[0]; ?> // All Rights Reserved // Site by <a href="https://levitate.co">levitate</a>
<br>
<img src="assets/img/logo01.png" class="f-logo" />

<br><br>
</footer>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script type="text/javascript" src="core/js/ajaxform.js"></script>
<script> toastr.error('Please sign in through steam with an administrator priviledge','Access Denied')</script>
</html>
