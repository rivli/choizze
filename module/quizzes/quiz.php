<?php

$quiz = mysqli_fetch_array(mysqli_query($MAINBD, "SELECT * FROM `quizzes` WHERE `id` = '".$url2."'"))  or die("mySQL connention error");
if ($quiz['status'] == 'deleted') {
  MessageSend(1, 'Этот опрос удален', "/");
}

$title=$quiz['name'];
include 'blocks/header.php';
include 'blocks/menu.php';
include 'blocks/quizSB.php';


 ?>
 <div class="content">
Здесь можно случайные опросы или топ опросов

</div>

<?php include 'blocks/footer.php'; ?>
