<?php
if ($_POST['status']=='like') {
    $user = UserInfo($_SESSION['id']);
    $quiz = QuizInfo($_POST['id']);


    $userLikes = AddToArraySQL($user['likes'], $_POST['id']);
    $quizLikes = AddToArraySQL($quiz['likes'], $_SESSION['id']);

    mysqli_query($MAINBD , "UPDATE `users` SET `likes` = '".$userLikes."' WHERE `id` = '".$_SESSION['id']."'");
	mysqli_query($MAINBD , "UPDATE `quizzes` SET `likes` = '".$quizLikes."' WHERE `id` = '".$_POST['id']."'");


} else {


    $user = UserInfo($_SESSION['id']);
    $quiz = QuizInfo($_POST['id']);

    $userLikes = DeleteFromArraySQL($user['likes'], $_POST['id']);
    $quizLikes = DeleteFromArraySQL($quiz['likes'], $_SESSION['id']);

    mysqli_query($MAINBD , "UPDATE `users` SET `likes` = '".$userLikes."' WHERE `id` = '".$_SESSION['id']."'");
	mysqli_query($MAINBD , "UPDATE `quizzes` SET `likes` = '".$quizLikes."' WHERE `id` = '".$_POST['id']."'");

}

    $quiz = QuizInfo($_POST['id']);
if ($quiz['likes'] == '') {
  $quizLikes = 0;
} else {
  $quizLikes = COUNT(TakeSQLArray($quiz['likes']));
}

echo $quizLikes;


?>
