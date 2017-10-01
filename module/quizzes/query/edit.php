<?php
if ($_SESSION['status']!='login') {MessageSend(1, 'Авторизуйтесь пожалуйста.', "/");};

$quiz = mysqli_fetch_array(mysqli_query($MAINBD, "SELECT * FROM `quizzes` WHERE `id` = '".$_POST['quizID']."'"))  or die("mySQL connention error");

$query1="SELECT COUNT(*) FROM `".$_POST['quizID']."`";
$result1 = mysqli_query($QUIZZESBD, $query1) or die("mySQL connention error");
$row = mysqli_fetch_array($result1);


if ($_POST['optionsNum'] > $row[0]) {
for($i = $row[0]+1;$i<=$_POST['optionsNum'];$i++) {
  $x = 'option'.$i;
  $_POST[$x] = FormChars($_POST['option'.$i]);
  mysqli_query($QUIZZESBD , "INSERT INTO `".$quiz['id']."` VALUES ('','".$_POST[$x]."', '[]')") or die("don't know,don't work");
}
}


if ($_POST['name']) {
	$_POST['name'] = FormChars($_POST['name']);
	mysqli_query($MAINBD , "UPDATE `quizzes` SET `name` = '".$_POST['name']."' WHERE `id` = '".$quiz['id']."'");
};

if ($_POST['description']) {
	$_POST['description'] = FormChars($_POST['description']);
	mysqli_query($MAINBD , "UPDATE `quizzes` SET `description` = '".$_POST['description']."' WHERE `id` = '".$quiz['id']."'");
};

if ($_POST['tags']) {
	$_POST['tags'] = FormChars($_POST['tags']);
	mysqli_query($MAINBD , "UPDATE `quizzes` SET `tags` = '".$_POST['tags']."' WHERE `id` = '".$quiz['id']."'");
};


//------------------Добавляем постер опроса
if (!file_exists("resources/posters/".$quiz['id'])) {mkdir("resources/posters/".$quiz['id'],0777);};

    $errorSubmit = false; // контейнер для ошибок
        if(isset($_FILES['poster']) && $_FILES['poster'] !=""){ // передали ли нам вообще файл или нет

          //------------------Удаляем старый постер если есть
          if ($quiz['poster'] and $_POST['poster']) {unlink(substr($quiz['poster'],20));};

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

MessageSend(3, 'Опрос успешно обновлен.', "/q/".$quiz['id']);

//------------------------------------------------------------------------------------------------------

?>
