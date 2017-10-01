<?php

$_POST['email'] = FormChars($_POST['email']);
$_POST['password'] = GenPass(FormChars($_POST['password']), $_POST['email']);

$query = "SELECT * FROM `users` WHERE `email` = '".$_POST['email']."'";
$result = mysqli_query($MAINBD, $query);
$user = mysqli_fetch_array($result);


if (!$user[0]) {MessageSend(1,"Пользователя с email ".$_POST['email']." не существует.Пожалуйста повторите попытку.", "/");}
else if ($_POST['password'] != $user['password']) {
MessageSend(1, $user['name']." ".$user['lastname']." вы ввели неверно пароль.Пожалуйста повторите попытку.", "/");
} else {

  if (!$_POST['dontRememberMe']) {
    setcookie("userEmail",$_POST['email'],strtotime('+30 days'), '/');
    setcookie("userPassword",$_POST['password'],strtotime('+30 days'), '/');
  }

$_SESSION['id'] = $user['id'];
$_SESSION['name'] = $user['name'];
$_SESSION['email'] = $user['email'];
$_SESSION['acc_verification'] = $user['acc_verification'];
$_SESSION['lastname'] = $user['lastname'];
$_SESSION['avatar'] = $user['avatar'];
$_SESSION['position'] = $user['position'];
$_SESSION['status'] = "login";

MessageSend(3, "Добро пожаловать", "/u/".$_SESSION['id']);
};
?>
