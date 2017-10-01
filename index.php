<?php
session_start();
include_once 'setting.php';
include_once 'php/UMC.php';

//Авторизация через куки
if ($_SESSION['status'] != 'login' && $_COOKIE['userEmail'] && $_COOKIE['userPassword']) {
  $query = "SELECT * FROM `users` WHERE `email` = '".$_COOKIE['userEmail']."' and `password` = '".$_COOKIE['userPassword']."'";
  $result = mysqli_query($MAINBD, $query);
  $user = mysqli_fetch_array($result);


  $_SESSION['id'] = $user['id'];
  $_SESSION['name'] = $user['name'];
  $_SESSION['email'] = $user['email'];
  $_SESSION['acc_verification'] = $user['acc_verification'];
  $_SESSION['lastname'] = $user['lastname'];
  $_SESSION['avatar'] = $user['avatar'];
  $_SESSION['position'] = $user['position'];
  $_SESSION['status'] = "login";


}




/*
if ($_SESSION['position'] == 'admin') {
error_reporting(E_ALL);
ini_set('display_errors', 1);
};
*/
$params = array();// Массив параметров из URI запроса.
$query_string = str_replace("q=","",trim($_SERVER['REQUEST_URI']));//получили строку
$url = $query_string;
$query_string = urldecode($query_string);//получили строку
$query_params = explode("/",$query_string);// разбиваем на массив
foreach ($query_params as $query_param) // и проверяем
 if ($query_param != "")                // а вдруг в конец слеш не дописали
    $params[] =  $query_param;

$url1 = array_shift($params);
$url2 = array_shift($params);
$url3 = array_shift($params);
$url4 = array_shift($params);

/*

if (file_exists(substr($url, 1))) { //Добавляет стили
    include substr($url, 1);
  };
  if (!$url1) {include 'page/index.php';} else {
    if (!$url2 and $url1=='edit') {include 'module/users/edit.php';};
  if ($url1 == "query") {
    if ( file_exists("query/".$url2.".php")) {
      include "query/".$url2.".php";
    } else {
      if (file_exists('module/'.$url2."/query/".$url3.".php")) include 'module/'.$url2."/query/".$url3.".php";
    }
  } else {
    if (!$url2 and file_exists("page/".$url1.".php")) {include "page/".$url1.".php";} else {
      if ($url1 == 'u') {
        if (ctype_digit($url2)) {
          if (!$url3) { include "module/users/profile.php"; } else {
            if (!$url4) {
              if ($url3 == 'edit') include 'module/users/'.$url3.'.php';}
          }
        }
      }
  }
}}
*/

//-----------------------Версия 2-------------------


if (file_exists(substr($url, 1))) { //Добавляет стили
    include substr($url, 1);$include=1;
  };

  if (!$url1) {include 'page/index.php';$include=1;}

  if ($url1 == "query") {
    if (file_exists("query/".$url2.".php")) {
      include "query/".$url2.".php";$include=1;
    } else {
      if (file_exists('module/'.$url2."/query/".$url3.".php")) {include 'module/'.$url2."/query/".$url3.".php";$include=1;}
    }
}

    if (!$url2 and file_exists("page/".$url1.".php")) {include "page/".$url1.".php";$include=1;}


      if ($url1 == 'u') {
        if (ctype_digit($url2)) {
          if (!$url3) { include "module/users/profile.php"; $include=1;}
        }

        if ($url2 == 'edit' and !$url3) {include 'module/users/'.$url2.'.php';$include=1;}
        if ($url2 == 'alerts' and !$url3) {include 'module/users/'.$url2.'.php';$include=1;}
      }

      if ($url1 == 'q') {
        if (ctype_digit($url2)) {
          if (!$url3) { include "module/quizzes/quiz.php"; $include=1;}
          if (file_exists('module/quizzes/'.$url3.'.php') and !$url4) {include 'module/quizzes/'.$url3.'.php';$include=1;}
        }

        if (file_exists('module/quizzes/'.$url2.'.php') and !$url3) {include 'module/quizzes/'.$url2.'.php';$include=1;}
      }

      if ($url1 == 's') {
          if (!$url3) { include "module/searching/searching.php"; $include=1;}
        }

        if ($url1 == 'new2.html') {
            if (!$url3) { include "page/new2.html"; $include=1;}
          }

      if ($include!=1) {
        include "page/404.php";
      }

?>
