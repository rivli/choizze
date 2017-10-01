<?php

if(count($_POST) != 5) {
  header('Location: /');
}

$_POST['email'] = FormChars($_POST['email']);
$_POST['password'] = GenPass(FormChars($_POST['password']), $_POST['email']);
$_POST['name'] = FormChars($_POST['name']);
$_POST['lastname'] = FormChars($_POST['lastname']);



$Row = mysqli_fetch_array(mysqli_query($MAINBD, "SELECT `email` FROM `users` WHERE `email` = '".$_POST['email']."'"));
if ($Row['email']) exit('E-Mail <b>'.$_POST['email'].'</b> уже используеться.');
mysqli_query($MAINBD , "INSERT INTO `users`  VALUES ('','notVerificated', '".$_POST['name']."', '".$_POST['lastname']."', '".$_POST['email']."','nobody', '".$_POST['password']."',NOW(),'','nobody','','".$_POST['sex']."','Привет, Я новенький.','')");


$query = "SELECT * FROM `users` WHERE (`email` = '".$_POST['email']."') and (`password` = '".$_POST['password']."')";
$result = mysqli_query($MAINBD, $query);
$user = mysqli_fetch_array($result);


///Далее создаем таблицы для пользоваетля Images,messages,friends,articles,communities с id = $user['id']


$sql3 = "CREATE TABLE `".$user['id']."-Friends` ( `id` INT NOT NULL AUTO_INCREMENT , `userid` INT(255) NOT NULL , `status` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
mysqli_query($USERSDB, $sql3);//создаем таблицу для Друзей

$sql4 = "CREATE TABLE `".$user['id']."-Messages` ( `id` INT NOT NULL AUTO_INCREMENT , `userid` INT(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
mysqli_query($USERSDB, $sql4);//создаем таблицу для Переписчиков

$sql2 = "CREATE TABLE `".$user['id']."-Images` ( `id` INT NOT NULL AUTO_INCREMENT , `status` VARCHAR(255) NOT NULL , `url` VARCHAR(255) NOT NULL , `description` TEXT NOT NULL , `likes` TEXT NOT NULL , `comments` INT(255) NOT NULL , `album` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
mysqli_query($USERSDB, $sql2);//создаем таблицу для Изображений

$sql5 = "CREATE TABLE `".$user['id']."-Alerts` ( `id` INT NOT NULL AUTO_INCREMENT , `status` VARCHAR(255) NOT NULL , `tableName` VARCHAR(255) NOT NULL , `mainid` INT(255) NOT NULL , `sender` INT(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
mysqli_query($USERSDB, $sql5);//создаем таблицу для ссылок на оповещения

//==================Создаем таблицу жалоб - оповещений
$sql6 = "CREATE TABLE `".$user['id']."-user` ( `id` INT NOT NULL AUTO_INCREMENT , `class` VARCHAR(255) NOT NULL , `mainid` INT(255) NOT NULL , `user` INT(255) NOT NULL , `text` TEXT NOT NULL , `date` DATE NOT NULL , `time` TIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
mysqli_query($ALERTSSBD, $sql6);

//------------------------------------------------------------------------------------------------------

$_SESSION['id'] = $user['id'];
$_SESSION['name'] = $user['name'];
$_SESSION['lastname'] = $user['lastname'];
$_SESSION['position'] = $user['position'];
$_SESSION['status'] = "login";



$Code = base64_encode($_POST['email']);
mail($_POST['email'], 'Регистрация на Choizze', 'Ссылка для активации: https://choizze.com/query/verification/'.substr($Code, -5).substr($Code, 0, -5), 'From: admin@choizze.com');
MessageSend(3, 'Регистрация акаунта успешно завершена. На указанный E-mail адрес <b>'.$_POST['email'].'</b> отправленно письмо о подтверждении регистрации.', "/u/".$_SESSION['id']);


?>
