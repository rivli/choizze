<?php
session_unset();
setcookie("userEmail",'',strtotime('-60 days'), '/');
setcookie("userPassword",'',strtotime('-60 days'), '/');
unset($_COOKIE['userEmail']);
unset($_COOKIE['userPassword']);
$_SESSION['status'] = 'logout';
header("location: /");
 ?>
