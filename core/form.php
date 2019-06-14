<?php
include 'dbcon.php';
$stitle = $_POST['stitle'];
$cta = $_POST['cta'];
$fex = $_POST['fex'];
$f1t = $_POST['f1t'];
$f1d = $_POST['f1d'];
$f2t = $_POST['f2t'];
$f2d = $_POST['f2d'];
$f3t = $_POST['f3t'];
$f3d = $_POST['f3d'];
$tname = $_POST['tname'];
try {
    $stmt = $pdo->prepare("UPDATE sitesetting
    SET ssvalue = (case when ssn = 'stitle' then ?
                        when ssn = 'cta' then ?
                        when ssn = 'fex' then ?
                        when ssn = 'f1t' then ?
                        when ssn = 'f2t' then ?
                        when ssn = 'f3t' then ?
                        when ssn = 'f1d' then ?
                        when ssn = 'f2d' then ?
                        when ssn = 'f3d' then ?
                        when ssn = 'tname' then ? end)
    WHERE ssn in ('stitle', 'cta', 'fex', 'f1t', 'f2t', 'f3t', 'f1d', 'f2d', 'f3d', 'tname')");
    $stmt->execute([$stitle, $cta, $fex, $f1t, $f2t, $f3t, $f1d, $f2d, $f3d, $tname]);
    header('Location: ../dashboard.php');
}
catch(PDOException $e)
{
    echo $e->getMessage();
}
?>
