<?php

if ($_SESSION['status']!='login') {MessageSend(1, 'Авторизуйтесь пожалуйста.', "/");};

$_POST['name'] = FormChars($_POST['name']);
$_POST['description'] = FormChars($_POST['description']);
$_POST['tags'] = FormChars($_POST['tags']);

for($i = 1;$i<=$_POST['optionsNum'];$i++) {
  $x = 'option'.$i;
  $_POST[$x] = FormChars($_POST['option'.$i]);
}



mysqli_query($MAINBD , "INSERT INTO `quizzes`  VALUES ('','norm', '".$_POST['name']."', '".$_POST['description']."', '".$_POST['tags']."','img', '".$_SESSION['id']."','0','0', NOW(), '".date("H:i:s")."')");


$query = "SELECT * FROM `quizzes` WHERE (`name` = '".$_POST['name']."') and (`description` = '".$_POST['description']."')";
$result = mysqli_query($MAINBD, $query);
$quiz = mysqli_fetch_array($result);


//==================Создаем таблицу комментов
$sql = "CREATE TABLE `".$quiz['id']."-Quiz` ( `id` INT NOT NULL AUTO_INCREMENT , `mainid` INT(255) NOT NULL , `user` INT(255) NOT NULL , `text` TEXT NOT NULL , `date` DATE NOT NULL , `time` TIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
mysqli_query($COMMENTSBD, $sql);

//==================Создаем таблицу жалоб - оповещений
$sql2 = "CREATE TABLE `".$quiz['id']."-Quiz` ( `id` INT NOT NULL AUTO_INCREMENT , `class` VARCHAR(255) NOT NULL , `mainid` INT(255) NOT NULL , `user` INT(255) NOT NULL , `text` TEXT NOT NULL , `date` DATE NOT NULL , `time` TIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
mysqli_query($ALERTSBD, $sql2);

//------------------Добавляем постер опроса
if (!file_exists("resources/posters/".$quiz['id'])) {mkdir("resources/posters/".$quiz['id'],0777);};

    $errorSubmit = false; // контейнер для ошибок
        if(isset($_FILES['poster']) && $_FILES['poster'] !=""){ // передали ли нам вообще файл или нет
            $whitelist = array(".gif", ".jpeg", ".png", ".jpg", ".bmp"); // список расширений, доступных для нашей аватарки
            // проверяем расширение файла
            //===>>>
            $error = true; //флаг, отвечающий за ошибку в расширении файла
            foreach  ($whitelist as  $item) {
                if(preg_match("/$item\$/i",$_FILES['poster']['name'])) $error = false;
            }
            //<<<===
            if($error){
                // если формат не корректный, заполняем контейнер для ошибок
                $errorSubmit = 'Не верный формат картинки!';
            }else{
                // если формат корректный, то сохраняем файл
                // и все остальную информацию о пользователе
                // Файл сохранится в папку /files/
                move_uploaded_file($_FILES["poster"]["tmp_name"], "resources/posters/".$quiz['id']."/".$_FILES["poster"]["name"]);
                $path_file = "https://choizze.com/resources/posters/".$quiz['id']."/".$_FILES["poster"]["name"];
              	mysqli_query($MAINBD , "UPDATE `quizzes` SET `poster` = '".$path_file."' WHERE `id` = '".$quiz['id']."'");

						}
        }


///Далее создаем таблицу для вариантов голосования

$sql3 = "CREATE TABLE `".$quiz['id']."` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(255) NOT NULL , `voices` TEXT NOT NULL, PRIMARY KEY (`id`)) ENGINE = InnoDB;";
mysqli_query($QUIZZESBD, $sql3) or die('json');//создаем таблицу для Друзей

for($z = 1;$z<=$_POST['optionsNum'];$z++) {
  $x = 'option'.$z;
  mysqli_query($QUIZZESBD , "INSERT INTO `".$quiz['id']."` VALUES ('','".$_POST[$x]."', '')") or die("don't know,don't work");

}
MessageSend(3, 'Опрос успешно добавлен.', "/q/".$quiz['id']);

//------------------------------------------------------------------------------------------------------

?>
