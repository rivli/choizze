<?php


$user = UserInfo($_SESSION['id']);


if ($_POST['name']) {
	$_POST['name'] = FormChars($_POST['name']);
	mysqli_query($MAINBD , "UPDATE `users` SET `name` = '".$_POST['name']."' WHERE `id` = '".$_SESSION['id']."'");
};

if ($_POST['lastname']) {
	$_POST['lastname'] = FormChars($_POST['lastname']);
	mysqli_query($MAINBD , "UPDATE `users` SET `lastname` = '".$_POST['lastname']."' WHERE `id` = '".$_SESSION['id']."'");
};

if ($_POST['quote']) {
	$_POST['quote'] = FormChars($_POST['quote']);
	mysqli_query($MAINBD , "UPDATE `users` SET `quote` = '".$_POST['quote']."' WHERE `id` = '".$_SESSION['id']."'");
};

if ($_POST['about'] != $user['about']) {
	$_POST['about'] = FormChars($_POST['about']);
	mysqli_query($MAINBD , "UPDATE `users` SET `about` = '".$_POST['about']."' WHERE `id` = '".$_SESSION['id']."'");
};

if ($_POST['birthday']) {
	mysqli_query($MAINBD , "UPDATE `users` SET `birthday` = '".$_POST['birthday']."' WHERE `id` = '".$_SESSION['id']."'");
};

if ($_POST['showEmail']) {
	mysqli_query($MAINBD , "UPDATE `users` SET `showEmail` = '".$_POST['showEmail']."' WHERE `id` = '".$_SESSION['id']."'");
};

if ($_POST['showBirthday']) {
	mysqli_query($MAINBD , "UPDATE `users` SET `showBirthday` = '".$_POST['showBirthday']."' WHERE `id` = '".$_SESSION['id']."'");
};

if (!file_exists("resources/avatars/".$_SESSION['id'])) {mkdir("resources/avatars/".$_SESSION['id'],0777);};


//if ($user['avatar']) {unlink(substr($user['avatar'],24));};

    $errorSubmit = false; // контейнер для ошибок
        if(isset($_FILES['avatar']) && $_FILES['avatar'] !=""){ // передали ли нам вообще файл или нет
            $whitelist = array(".gif", ".jpeg", ".png", ".jpg", ".bmp"); // список расширений, доступных для нашей аватарки
            // проверяем расширение файла
            //===>>>
            $error = true; //флаг, отвечающий за ошибку в расширении файла
            foreach  ($whitelist as  $item) {
                if(preg_match("/$item\$/i",$_FILES['avatar']['name'])) $error = false;
            }
            //<<<===
            if($error){
                // если формат не корректный, заполняем контейнер для ошибок
                $errorSubmit = 'Не верный формат картинки!';
            }else{
                // если формат корректный, то сохраняем файл
                // и все остальную информацию о пользователе
                // Файл сохранится в папку /files/
                move_uploaded_file($_FILES["avatar"]["tmp_name"], "resources/avatars/".$_SESSION['id']."/".$_FILES["avatar"]["name"]);
                $path_file = "https://choizze.com/resources/avatars/".$_SESSION['id']."/".$_FILES["avatar"]["name"];
              	mysqli_query($USERSDB , "UPDATE `".$_SESSION['id']."-Images` SET `status` = 'waslogo' WHERE `status` = 'logo'");
								mysqli_query($USERSDB , "INSERT INTO `".$_SESSION['id']."-Images`  VALUES ('', 'logo','".$path_file."','".$_POST['avadescription']."','0','".$_POST['Comments']."','0')");
								$thisImageId = mysqli_fetch_array(mysqli_query($USERSDB , "SELECT COUNT(*) FROM `".$_SESSION['id']."-Images`"));
								$sql = "CREATE TABLE `".$thisImageId[0]."-".$_SESSION['id']."-Images` ( `id` INT NOT NULL AUTO_INCREMENT , `mainid` INT(255) NOT NULL , `user` INT(255) NOT NULL , `text` TEXT NOT NULL , `date` DATE NOT NULL , `time` TIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
								mysqli_query($COMMENTSBD, $sql);

						}
        }

MessageSend(3, 'обновлена', "/u/".$_SESSION['id']);

?>
