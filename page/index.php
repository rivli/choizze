<?php
$title = 'Главная';
include 'blocks/header.php';
include 'blocks/menu.php';
 ?>
 <div class="content">
   <?php if ($_SESSION['status'] == 'login') { ?>
<!--<a href="/q/add" style="text-decoration:none;"><div id="addQuiz">Добавить Опрос</div></a>-->
<?php }; ?>
<table class="quizTable">
<?
$quizzesNumber = mysqli_fetch_array(mysqli_query($MAINBD , "SELECT COUNT(*) FROM `quizzes`"));
$TrCounter = 1;
$i = $quizzesNumber[0];
while ($i >= 1) {
$quiz = QuizInfo($i);
$author = UserInfo($quiz['author']);


//---------Здесь узнаем голосовали ли мы в этом опросе ------------------------
$query1="SELECT * FROM `".$i."`";
  $result1 = mysqli_query($QUIZZESBD, $query1) or die("sadasda");
  $voicesNumSum=0;
  $voicedByMe=0;
while($row = mysqli_fetch_array($result1)) {


  if ($row['voices']=='') {
    $VNumber = 0;
  } else {
  $VNumber = COUNT(TakeSQLArray($row['voices']));
  };


  $voices = TakeSQLArray($row['voices']);
  if (in_array($_SESSION['id'],$voices)) {
    $voicedByMe = $row['id'];
    //$voicedByMe Проверяет голосовал ли юзер за этот вариант и голосовал ли вообще
    /*
    0 - не голосовал вообще
    другое число - номер варианта за который голосвал
    */
  }

  $voicesNumSum += $VNumber;
}
//--------------------------------end------------------------------------------




if ($quiz['likes'] == '') {
  $likesCounter = 0;
  $likeStatus = 'like';
} else {
  $likes = TakeSQLArray($quiz['likes']);
  if (in_array($_SESSION['id'], $likes)) {
    $likeStatus = 'redlike';
  } else {
  $likeStatus = 'like';
  }
  $likesCounter = COUNT(TakeSQLArray($quiz['likes']));
}
/*
$userLikes = TakeSQLArray(UserInfo($_SESSION['id'])['likes']);
if (in_array($quiz['id'], $userLikes) ) {
  $likeStatus = 'redlike';
} else {
  $likeStatus = 'like';
}
*/
if ($quiz['status']!='deleted') {
if ($TrCounter == 1) {
  echo '<tr>';
}

?>
  <td class="quiz"  id="<?php echo $i; ?>">
    <div class="quizBlock">
        <div class="name" onclick="openQuiz(<?php echo $quiz['id']; ?>)" title="<?php echo $quiz['name']; ?>"><?php echo cropStr($quiz['name'],35); ?></div>
      <div class="bg"  style="background-image:url(<?php echo $quiz['poster']; ?>)"  onclick="openQuiz(<?php echo $quiz['id']; ?>)"></div>
      <div class="voicesMainContent" title="Количество проголосовавших">
        <table style="border-spacing:0;">
          <tr>
            <td>
              <img src="/resources/design/quiz/VoicesNum.png" height="20px" style="opacity:0.8;">
            </td>
            <td class='voicesNumber<?php echo $i; ?>'><?php echo $voicesNumSum; ?></td>
          </tr>
        </table>

      </div>
      <div class="likesNumber" title="Количество лайков">
        <table style="border-spacing:0;">
          <tr>
            <td>
              <img src="/resources/design/quiz/<?php echo $likeStatus ?>.png" <?php if ($_SESSION['status'] == 'login') {?> onclick="ILikeThis(<?php echo $quiz['id'] ?>)" <?php ;}; ?> height="20px" class="like-quiz-<?php echo $quiz['id'] ?>" title="Like it" alt="Like it">
            </td>
            <td class="likesNumber<?php echo $quiz['id'] ?>"><?php echo $likesCounter;  ?></td>
          </tr>
        </table>
      </div>
    </div>
  </td>
<?php
if ($TrCounter == 2) {echo '</tr>';}
$TrCounter++;
if ($TrCounter == 3) $TrCounter = 1;
};
$i--;
};
 ?>
</table>
 </div>
<?php include 'blocks/sidebar.php';include 'blocks/footer.php'; ?>
