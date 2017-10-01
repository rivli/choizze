<div class="sidebar">
<?php


//Я не помню где это файл используеться, но основной файл опросов это - ajax/quiz.php


$quiz = mysqli_fetch_array(mysqli_query($MAINBD, "SELECT * FROM `quizzes` WHERE `id` = '".$url2."'"))  or die("mySQL connention error");

$author = UserInfo($quiz['author']);

//---------------------VoicesCounting v0.0 ---------------------------
$query1="SELECT * FROM `".$url2."`";
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
  $query="SELECT * FROM `".$url2."`";
    $result = mysqli_query($QUIZZESBD, $query) or die("sadasda");

    if ($quiz['status'] != 'deleted') { ?>
<div class="quizSB" >
<div class="editorLinks">

<?php if ($_SESSION['status'] == 'login') {
  echo '<a href="#" class="quizEditLink"><img src="/resources/design/quiz/like.png" height="20px" title="Like it" alt="Like it"></a>';
} ?>
<a href="#" class="quizEditLink"><img src="/resources/design/quiz/share.png" height="20px" title="Share" alt="Share"></a>

<?php if ($quiz['author'] == $_SESSION['id']) {
  echo '<a href="/q/'.$url2.'/delete" class="quizDeleteLink"><img src="/resources/design/quiz/delete.png" height="20px" title="Удалить" alt="Удалить"></a>';
  echo '<a href="/q/'.$url2.'/edit" class="quizEditLink"><img src="/resources/design/quiz/edit.png" height="20px" title="Редактировать" alt="Редактировать"></a>';
} ?>
</div>

<div class="quizSbName" id='.$url2.'><?php echo $quiz['name'] ?></div>

<?php if ($quiz['poster'] != "img") {echo '<img src="'.$quiz['poster'].'"  style="width:100%;">';};

while($row = mysqli_fetch_array($result)) {

  if ($row['voices']=='') {
    $VNumber = 0;
  } else {
  $VNumber = COUNT(TakeSQLArray($row['voices']));
};

$VoicePercent = 100*$VNumber/$voicesNumSum;
echo '<div class="voice" id="'.$url2.'-'.$row['id'].'-'.$voicedByMe.'"';
if ($_SESSION['status'] != 'login') {
  echo ' style="cursor:default;"';
} else {
  echo ' onclick="castaVote(this) ">';
};
echo '<span class="optionName">'.$row['name'];
if ($row['id']==$voicedByMe) echo ' <img src="/resources/design/quiz/checkmark.png" height=10px;>';
echo '</span><span class="voices">'.$VNumber.'</span><div class="voicesBlockFiller"  style="';
echo 'width:'.$VoicePercent.'%;"></div></div>';
};
?>
<div class="quizDesc"><?php echo $quiz['description'] ?></div></div>


<div class="authorBlock">
         <table>
           <tbody><tr>
             <td class="authorBlockLeft" style="text-align: left;">
              <a href="/u/<?php echo $author['id'] ?>" class="authorName"><img src="<?php echo $author['avatar'] ?>" class="authorAva" style="width: 100%;"></a>
             </td>
             <td class="authorBlockRight">
               <a href="/u/<?php echo $author['id'] ?>" class="authorName"><?php echo $author['name'].' '.$author['lastname'] ?></a>
               <span class="addTime"><?php echo $quiz['date']." ".$quiz['datetime'] ?></span>
               <span class="authorQuote"><?php echo $author['quote'] ?></span><br>
             </td>
           </tr>
         </tbody></table>
       </div>

<?php
//--------------Дальше комментарии----------------------
//Comments
/*
$commentsNumber = mysqli_fetch_array(mysqli_query($COMMENTSBD , "SELECT COUNT(*) FROM `".$url2."-Quiz`"));
$i = $commentsNumber[0];
$MainCommentsNumber = mysqli_fetch_array(mysqli_query($COMMENTSBD , "SELECT COUNT(*) FROM `".$url2."-Quiz` WHERE `mainid`=0 "));
if ($MainCommentsNumber[0] != '0') {
echo '<div><center>Комментарии('.$MainCommentsNumber[0].')</center></div>';
while ($i >= 1) {
  ShowComment($i,$url2);
$i--;
};
};
if ($_SESSION['status']=='login') {
 ?>

<div class="addCommentQuiz">
<form id="commentform" class="commentForm" action="" method="post">
  <input type="hidden" id="id" name="id" value="<?php echo $url; ?>" >
    <input type="hidden" id="mainid" name="mainid" value="0" >
  <input type="hidden" id="commentsTableName" name="tablename" value="<?php echo $url2."-Quiz"; ?>" >
    <textarea type="text" id="Comment" name="text" placeholder="Text" required></textarea><br>
      <div class="addButton" style="display:inline-block;width:30px;" title="Вставить ссылку" id="addhref">С</div>
      <div class="addButton" style="display:inline-block;width:30px;" title="Вставить изображение" id="addimage">И</div>
      <div class="addButton" style="display:inline-block;width:30px;" title="Вставить аудиозапись" id="addaudio">А</div>
      <div class="addButton" style="display:inline-block;width:30px;" title="Вставить видео" id="addvideo">В</div>
  <input  type="button" name="enter" id="addComment" value="Отправить" >
</form>
</div>

<script type='text/javascript'>

$(function(){
    $(".AnsweringButtonQuiz").on("click", function(){
    var id = $(this).attr('id');
    var name = $(this).attr('value');
    document.getElementById('Comment').value = name+", ";
    document.getElementById('mainid').value = id;
    var block = document.getElementById("sidebar");
    $(".sidebar").animate({ scrollTop: $(document).height() }, "slow");
    $("#Comment").focus();
    return false;
    });
});
   // Ждём загрузки страницы
    function funcBefore1() {
        $("body").prepend('<div class="messageshow" style="background:#2b3540" >Загрузка</div>');
    }


    function funcSuccess1(data2) {
		$("#Comment").val('');
		$(".messageshow").remove();
        $("body").prepend('<div class="messageshow" style="background:#2b3540" >Комментарий отправлен, но вы его не увидите, потому что СОМЕТа нет.Обновите страницу.</div>');
       // $(".popupCommentsShow"). (data);
      //  $(".popupCommentsShow").fadeIn(); // Медленно выводим изображение

    }



    $("#addComment").bind('click',function() {
        var comment   = $('#commentform').serialize();
        $.ajax({
            url: "/ajax/addComment.php",
            type: "POST",
            data: comment,
            dataType: "html",
            beforeSend: funcBefore1,
            success: openQuiz(<?php echo $url2; ?>)
        });
    });

</script>
<?php };

*/

}
 ?>
</div>
