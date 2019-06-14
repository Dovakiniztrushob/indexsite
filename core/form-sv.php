<?php
function delete()
{
  include 'dbcon.php';
  $svid = $_POST['svid'];
  try {
      $stmt = $pdo->prepare("DELETE FROM serverlist WHERE sid = ?");
      $stmt->execute([$svid]);
      header('Location: ../dashboard.php');
      echo $stmt->rowCount() . " records updated successfully";
      }
  catch(PDOException $e)
      {
      echo $sql1 . "<br>" . $e->getMessage();
      }
}

function insert()
{
  include 'dbcon.php';
  $svip = $_POST['svip'];
  $svport = $_POST['svport'];
  try {
      $stmt = $pdo->prepare("INSERT INTO serverlist (serverip, serverport) VALUES (?, ?)");
      $stmt->execute([$svip, $svport]);
      header('Location: ../dashboard.php');
      echo $stmt->rowCount() . " records updated successfully";
      }
  catch(PDOException $e)
      {
      echo $sql1 . "<br>" . $e->getMessage();
      }
}

if (isset($_POST['dlsv'])):
   delete();
elseif (isset($_POST['adsv'])):
   insert();
else:
  echo 'error';
  die();
endif;
?>
