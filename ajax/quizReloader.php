<?php

$quiz = mysqli_fetch_array(mysqli_query($MAINBD, "SELECT * FROM `quizzes` WHERE `id` = '".$_POST['id']."'"))  or die("asdas");
$author = mysqli_fetch_array(mysqli_query($MAINBD, "SELECT * FROM `users` WHERE `id` = '".$quiz['author']."'"));

//---------------------VoicesCounting v0.0 ---------------------------
$query1="SELECT * FROM `".$_POST['id']."`";
  $result1 = mysqli_query($QUIZZESBD, $query1) or die("sadasda");
  $voicesNumSum=0;
  $voicedByMe=0;
while($row = mysqli_fetch_array($result1)) {
  $voices = json_decode($row['voices']);
  if (in_array($_SESSION['id'],$voices)) {
    $voicedByMe = $row['id'];
    //$voicedByMe Проверяет голосовал ли юзер за этот вариант и голосовал ли вообще
    /*
    0 - не голосовал вообще
    другое число - номер варианта за который голосвал
    */
  }

  $voices = COUNT($voices);
  $voicesNumSum += $voices;
}
  $query="SELECT * FROM `".$_POST['id']."`";
    $result = mysqli_query($QUIZZESBD, $query) or die("sadasda");
$data = array('id' => $_POST['id'], 'content' => '');

$data['content'] = $data['content'].'<span class="quizName" onclick="openQuiz('.$quiz['id'].')">'.$quiz['name'].'</span><br> ';



    while($row = mysqli_fetch_array($result)) {
      //  $VoicePercent = 100*$row['voices']/$voicesNumSum;
      //  echo '<div class="voice" id="'.$i.'-'.$row['id'].'"><span class="optionName">'.$row['name'].'</span><span class="voices">'.$row['voices'].'</span><div class="voicesBlockFiller" style="width:'.$VoicePercent.'%;"></div></div>';

        $row['voices'] = json_decode($row['voices']);
        if (!$row['voices']) {$VNumber = 0;} else {
        $VNumber = COUNT($row['voices']);
          };
        $VoicePercent = 100*$VNumber/$voicesNumSum;

        $data['content'] = $data['content'].'<div class="voice" id="'.$_POST['id'].'-'.$row['id'].'-'.$voicedByMe.'"onclick="castaVote(this) "><span class="optionName">'.$row['name'].'</span><span class="voices">'.$VNumber.'</span><div class="voicesBlockFiller"  style="';
        if ($row['id']==$voicedByMe) $data['content'] = $data['content']."background:rgb(242, 93, 73);";;
        $data['content'] = $data['content'].'width:'.$VoicePercent.'%;"></div></div>';

     };



echo json_encode($data);
 ?>
