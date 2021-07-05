<?php
$name=$_POST['name'];
$email=$_POST['email'];
$telephone=$_POST['telephone'];
$db = mysqli_connect('localhost','root','root','praktika','3306');
$res = mysqli_query ($db,"INSERT INTO `oc_forma` (`forma_id`, `firstname`, `email`, `telephone`) VALUES (NULL, '$name', '$email', '$telephone');");
if($res) {header("Location: http://prakrika/index.php?route=information/information&information_id=7");
}
?>
