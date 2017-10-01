<?php
if ($_SESSION['status']!='login') {

 echo "Авторизуйтесь или зарегистрируйтесь!!!";
} else {

  $_POST['id'];
  //0 - id of quiz
  //1 - option id
  //2 - Last option, which User voted
  $data = explode('-', $_POST['id']);

//удаляем старый голос если таковой есть
  if ($data[2] != 0) {
    $query="SELECT * FROM `".$data[0]."` WHERE `id` = '".$data[2]."'";
    $result = mysqli_query($QUIZZESBD, $query) or die("connection error1");
    $quiz = mysqli_fetch_array($result)  or die("connection error2");
    $voices = DeleteFromArraySQL($quiz['voices'], $_SESSION['id']);
    mysqli_query($QUIZZESBD , "UPDATE `".$data[0]."` SET `voices` = '".$voices."' WHERE `id` = '".$data[2]."'") or die("connection error3");
  };

  $query="SELECT * FROM `".$data[0]."` WHERE `id` = '".$data[1]."'";
  $result = mysqli_query($QUIZZESBD, $query) or die("connection error1");
  $quiz = mysqli_fetch_array($result)  or die("connection error2");
  $voices = AddToArraySQL($quiz['voices'], $_SESSION['id']);
  mysqli_query($QUIZZESBD , "UPDATE `".$data[0]."` SET `voices` = '".$voices."' WHERE `id` = '".$data[1]."'") or die("connection error3");

  $quiz = mysqli_fetch_array(mysqli_query($MAINBD, "SELECT * FROM `quizzes` WHERE `id` = '".$data[0]."'"))  or die("asdas");
  $author = UserInfo($quiz['author']);
  $user = UserInfo($_SESSION['id']);
  $userLikes = TakeSQLArray($user['likes']);
  if ($quiz['likes'] == '') {
    $likesCounter = 0;
  } else {
    $likesCounter = COUNT(TakeSQLArray($quiz['likes']));
  }


  //---------------------VoicesCounting v0.0 ---------------------------
  $query1="SELECT * FROM `".$data[0]."`";
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
    $voices = COUNT($voices);
    $voicesNumSum += $VNumber;
  }
    $query="SELECT * FROM `".$data[0]."`";
      $result = mysqli_query($QUIZZESBD, $query) or die("sadasda");
//$voicedByMe Проверяет голосовал ли юзер за этот вариант и голосовал ли вообще
/*
0 - не голосовал вообще
1 - голосвал но за другой вариант
3 - голосовал за этот вариант
*/


if ($quiz['status'] != 'deleted') {

echo '<div class="editorLinks">';
if ($_SESSION['status'] == 'login') {
  if (in_array($quiz['id'], $userLikes) ) {
    $likeStatus = 'redlike';
  } else {
    $likeStatus = 'like';
  }
  echo '<div class="quizEditLink">';
  echo '<table style="border-spacing:0;"><tr><td>';
  echo '<img src="/resources/design/quiz/'.$likeStatus.'.png" onclick="ILikeThis('.$quiz['id'].')" height="20px" class="like-quiz-'.$quiz['id'].'" title="Like it" alt="Like it"></td>';
  echo '<td class="likesNumber'.$quiz['id'].'">'.$likesCounter.'</td>';
  echo '</tr></table></div>';
} else {
  echo '<div class="quizEditLink">';
  echo '<table style="border-spacing:0;"><tr><td>';
  echo '<img src="/resources/design/quiz/like.png" height="20px" class="like-quiz-'.$quiz['id'].'" title="Like it" alt="Like it"></td>';
  echo '<td class="likesNumber'.$quiz['id'].'">'.$likesCounter.'</td>';
  echo '</tr></table></div>';
}
  echo '<a href="#" class="quizEditLink"><img src="/resources/design/quiz/share.png" height="20px" title="Share" alt="Share"></a>';

if ($quiz['author'] == $_SESSION['id']) {
  echo '<a href="/q/'.$quiz['id'].'/delete" class="quizDeleteLink"><img src="/resources/design/quiz/delete.png" height="20px" title="Удалить" alt="Удалить"></a>';
  echo '<a href="/q/'.$quiz['id'].'/edit" class="quizEditLink"><img src="/resources/design/quiz/edit.png" height="20px" title="Редактировать" alt="Редактировать"></a>';
}
echo '</div>';

echo '<div class="quizSbName" id='.$quiz['id'].'>'.$quiz['name'].'</div> ';

if ($quiz['poster'] != "img") {echo '<img src="'.$quiz['poster'].'"  style="width:100%;">';};

while($row = mysqli_fetch_array($result)) {

if ($row['voices']=='') {
  $VNumber = 0;
} else {
$VNumber = COUNT(TakeSQLArray($row['voices']));
};

$VoicePercent = 100*$VNumber/$voicesNumSum;
echo '<div class="voice" id="'.$data[0].'-'.$row['id'].'-'.$voicedByMe.'" onclick="castaVote(this)"><span class="optionName">'.$row['name'];
if ($row['id']==$voicedByMe) echo ' <img src="/resources/design/quiz/checkmark.png" height=10px;>';
echo '</span><span class="voices">'.$VNumber.'</span><div class="voicesBlockFiller"  style="';
//  if ($row['id']==$voicedByMe) echo "background:rgb(242, 93, 73);";
echo 'width:'.$VoicePercent.'%;"></div></div>';
};

echo '<div class="quizDesc">'.$quiz['description'].'</div>';



}

};

 ?>
