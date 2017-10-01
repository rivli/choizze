<?php



if (!$_POST['text']) {MessageSend(2, 'Вы отправили пустое сообщение', '/'.$_POST['id']);
} else {
  $_POST['text'] = addslashes(nl2br(trim($_POST['text'])));
  $quiz = QuizInfo($_POST['quizid']);
  if ($_SESSION['position']=='admin') {
      $class = "red";
  } else {
      $class = "norm";
  }

  if ($_POST['sender']) {
    $ALERT = mysqli_fetch_array(mysqli_query($USERSDB, "SELECT * FROM `".$_SESSION['id']."-Alerts` WHERE `tableName` = '".$_POST['tablename']."' and `sender` = '".$_POST['sender']."' "))  or die("here1!!");
  } else {
    $ALERT = mysqli_fetch_array(mysqli_query($USERSDB, "SELECT * FROM `".$_SESSION['id']."-Alerts` WHERE `tableName` = '".$_POST['tablename']."' "));
  }

  if ($ALERT) {
    if ($_POST['mainid']) {
      $mainId['id'] = $_POST['mainid'];
    } else {
    $mainId = mysqli_fetch_array(mysqli_query($ALERTSBD , "SELECT * FROM `".$_POST['tablename']."` WHERE `mainid` = '' and `user` = '".$_SESSION['id']."'")) or die("here!!");
  }
    mysqli_query($ALERTSBD , "INSERT INTO `".$_POST['tablename']."`  VALUES ('','".$class."','".$mainId['id']."','".$_SESSION['id']."', '".$_POST['text']."', NOW(), '".date("H:i:s")."')") or die("Ошибка подключения к базе данных".mysql_error());

    } else {
    mysqli_query($ALERTSBD , "INSERT INTO `".$_POST['tablename']."`  VALUES ('','".$class."','','".$_SESSION['id']."', '".$_POST['text']."', NOW(), '".date("H:i:s")."')") or die("Ошибка подключения к базе данных".mysql_error());

    $mainId = mysqli_fetch_array(mysqli_query($ALERTSBD , "SELECT * FROM `".$_POST['tablename']."` WHERE `mainid` = '' and `user` = '".$_SESSION['id']."'")) or die("here!!");

    mysqli_query($USERSDB , "INSERT INTO `".$_SESSION['id']."-Alerts`  VALUES ('','unread', '".$_POST['tablename']."', '".$mainId['id']."', '".$_SESSION['id']."')") or die("Ошибка подключения к базе данных".mysql_error());
    mysqli_query($USERSDB , "INSERT INTO `".$quiz['author']."-Alerts`  VALUES ('','unread', '".$_POST['tablename']."', '".$mainId['id']."', '".$_SESSION['id']."')") or die("Ошибка подключения к базе данных".mysql_error());
  }

};

 ?>
