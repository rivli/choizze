<?php
$quiz = mysqli_fetch_array(mysqli_query($MAINBD, "SELECT * FROM `quizzes` WHERE `id` = '".$_POST['id']."'"))  or die("asdas");

$author = UserInfo($quiz['author']);
$user = UserInfo($_SESSION['id']);
$userLikes = TakeSQLArray($user['likes']);
if ($quiz['likes'] == '') {
  $likesCounter = 0;
} else {
  $likesCounter = COUNT(TakeSQLArray($quiz['likes']));
}

//---------------------VoicesCounting v0.0 ---------------------------
$query1="SELECT * FROM `".$_POST['id']."`";
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
  $query="SELECT * FROM `".$_POST['id']."`";
    $result = mysqli_query($QUIZZESBD, $query) or die("sadasda");


         if ($quiz['status'] != 'deleted') {
echo '<div class="quizSB" >';
  echo '<div class="editorLinks">';
  if ($_SESSION['status'] == 'login') {
    if (in_array($quiz['id'], $userLikes) ) {
      $likeStatus = 'redlike';
    } else {
      $likeStatus = 'like';
    }
    echo '<div class="quizEditLink">';
    echo '<table style="border-spacing:0;"><tr><td>';
    echo '<img src="/resources/design/quiz/'.$likeStatus.'.png" onclick="ILikeThis('.$quiz['id'].')" height="25px" class="like-quiz-'.$quiz['id'].'" title="Like it" alt="Like it"></td>';
    echo '<td class="likesNumber'.$quiz['id'].'">'.$likesCounter.'</td>';
    echo '</tr></table></div>';
  } else {
    echo '<div class="quizEditLink">';
    echo '<table style="border-spacing:0;"><tr><td>';
    echo '<img src="/resources/design/quiz/like.png" height="25px" class="like-quiz-'.$quiz['id'].'" title="Like it" alt="Like it"></td>';
    echo '<td class="likesNumber'.$quiz['id'].'">'.$likesCounter.'</td>';
    echo '</tr></table></div>';
  }
    echo '<div class="quizEditLink"><img src="/resources/design/quiz/share.png" onclick=\'share('.$quiz['id'].',"'.addslashes(nl2br($quiz['name'])).'")\' height="25px" title="Share" alt="Share"></div>';

  if ($quiz['author'] == $_SESSION['id']) {
    echo '<a href="/q/'.$quiz['id'].'/delete" class="quizDeleteLink"><img src="/resources/design/quiz/delete.png" height="25px" title="Удалить" alt="Удалить"></a>';
    echo '<a href="/q/'.$quiz['id'].'/edit" class="quizEditLink"><img src="/resources/design/quiz/edit.png" height="25px" title="Редактировать" alt="Редактировать"></a>';
  } else {
    echo '<div class="quizEditLink"><img src="/resources/design/quiz/appeal.png" height="25px" title="Пожаловаться" onclick="sendAlert()" alt="Пожаловаться"></div>';
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
    echo '<div class="voice" id="'.$_POST['id'].'-'.$row['id'].'-'.$voicedByMe.'" ';
    if ($_SESSION['status'] != 'login') {
      echo 'style="cursor:default;"';
    } else {
      echo 'onclick="castaVote(this) ">';
    };
    echo '<span class="optionName">'.$row['name'];
  if ($row['id']==$voicedByMe) { echo ' <img src="/resources/design/quiz/checkmark.png" height=10px;>';}
    echo '</span><span class="voices">'.$VNumber.'</span><div class="voicesBlockFiller"  style="';
  echo 'width:'.$VoicePercent.'%;"></div></div>';
 };

 echo '<div class="quizDesc">'.$quiz['description'].'</div></div>';


echo '
<div class="authorBlock">
              <table>
                <tbody><tr>
                  <td class="authorBlockLeft" style="
    text-align: left;
">
                    <a href="/u/'.$author['id'].'" class="authorName"><img src="'.$author['avatar'].'" class="authorAva" style="width: 100%;"></a>
                  </td>
                  <td class="authorBlockRight">
                    <a href="/u/'.$author['id'].'" class="authorName">'.$author['name'].' '.$author['lastname'].'</a>
                    <span class="addTime">'.$quiz['date']." ".$quiz['datetime'].'</span>
                    <span class="authorQuote">'.$author['quote'].'</span><br>
                  </td>
                </tr>
              </tbody></table>
            </div>
';

/*
//--------------Дальше комментарии----------------------
//Comments

$commentsNumber = mysqli_fetch_array(mysqli_query($COMMENTSBD , "SELECT COUNT(*) FROM `".$_POST['id']."-Quiz`"));
$i = $commentsNumber[0];
$MainCommentsNumber = mysqli_fetch_array(mysqli_query($COMMENTSBD , "SELECT COUNT(*) FROM `".$_POST['id']."-Quiz` WHERE `mainid`=0 "));

if ($MainCommentsNumber[0] != '0') {
  echo '<center>Комментарии('.$MainCommentsNumber[0].')</center>';
while ($i >= 1) {
ShowComment($i,$_POST['id']);
$i--;
};
 };
if ($_SESSION['status']=='login') {
 ?>

 <div class="addCommentQuiz">
<form id="commentform" class="commentForm" action="" method="post">
   <input type="hidden" id="id" name="id" value="<?php echo $url; ?>" >
     <input type="hidden" id="mainid" name="mainid" value="0" >
   <input type="hidden" id="commentsTableName" name="tablename" value="<?php echo $_POST['id']."-Quiz"; ?>" >
   <div class="main-input" id="Comment" name="text" contenteditable="true" onclick="checkPlacholder()">
     <span class="main-input-placeholder">Ваше сообщение</span>
   </div>
     <br>
     <img src="/resources/design/addButtons/video.png" class="addButton" title="Вставить видео" alt="Вставить видео" id="addvideo">
     <img src="/resources/design/addButtons/audio.png" class="addButton" title="Вставить аудиозапись" alt="Вставить аудиозапись" id="addaudio">
     <img src="/resources/design/addButtons/image.png" class="addButton" title="Вставить изображение" alt="Вставить изображение" id="addimage">
     <img src="/resources/design/addButtons/link.png" class="addButton" title="Вставить ссылку" onclcik="addLink()" alt="Вставить ссылку" id="addlink">
  <input  type="button" name="SendComment" class="SendButton" style="float:right;" id="addComment" value="Отправить" >
 </form>
 </div>
 <script type="text/javascript" src="/js/form.js">
 </script>
*/
if ($_SESSION['status']=='login') {  ?>
<script type='text/javascript'>

function sendAlert() {
  $("body").prepend(
      "<div class='popup_bg'></div>" + // Блок, который будет служить фоном затемненным
      "<div class='popupBlock'>" + //Добавляем в тело документа разметку всплывающего окна
      "<div class='popupInnerBlock'>" +
      "<span class='popupName'>Отправить жалобу</span><br>" +
      "<form id='SendAlertForm'>" +
      <?php if ($_SESSION['position'] == 'admin') {?> '<input type="checkbox" name="byadmin" value="admin">От имени администрации?' + <?php }?>
      '<input type="hidden" id="quizid" name="quizid" value="<?php echo $quiz['id']; ?>" >' +
        '<input type="hidden" id="id" name="id" value="<?php echo $url; ?>" >' +
        '<input type="hidden" id="alertsTableName" name="tablename" value="<?php echo $_POST['id']."-Quiz"; ?>" >' +
       "<textarea placeholder='Текст' class='textareaInput' name='text' ></textarea>" +
       '<div class="buttonPlacer"><input  type="button" name="SendAlert" class="SendButton" id="SendAlert" value="Отправить" ></div>' +
       "</form>" +
       "</div>" +
      "</div>");


      $("#SendAlert").bind("click",function() {
          var alert1   = $("#SendAlertForm").serialize();
          $.ajax({
              url: "/ajax/SendAlert.php",
              type: "POST",
              data: alert1,
              dataType: "html",
              beforeSend: funcBefore1,
              success: function (data) {
          		$(".messageshow").remove();
                $("body").prepend("<div class=\"messageshow\" style=\"background:#114f96\" >Жалоба отправлена</div>");
                setTimeout(function(){$('.messageshow').fadeOut('swing')},5000);  //10000 = 10 секунд
              }
          });
      });


  $(".popup").fadeIn(0); // Медленно выводим изображение


  $(".popup_bg").click(function() { // Событие клика на затемненный фон
      $(".popupBlock").fadeOut(0); // Медленно убираем всплывающее окно
      setTimeout(function() { // Выставляем таймер
          $(".popupBlock").remove(); // Удаляем разметку всплывающего окна
          $(".popup_bg").remove(); // Удаляем разметку всплывающего окна
      }, 0);
  });
}



// Ждём загрузки страницы
 function funcBefore1() {
     $("body").prepend('<div class="messageshow" style="background:#2b3540" >Загрузка</div>');
 }

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


/*
    function funcSuccess1(data2) {
		$("#Comment").val('');
		$(".messageshow").remove();
        $("body").prepend('<div class="messageshow" style="background:#2b3540" >Комментарий отправлен, но вы его не увидите, потому что СОМЕТа нет.Обновите страницу.</div>');
       // $(".popupCommentsShow"). (data);
      //  $(".popupCommentsShow").fadeIn(); // Медленно выводим изображение

    }*/

/*
    $("#addComment").bind('click',function() {
        var comment   = $('#commentform').serialize();
        var text   = $('#Comment').html();
        comment += '&text=' + text;
        $.ajax({
            url: "/ajax/addComment.php",
            type: "POST",
            data: comment,
            dataType: "html",
            beforeSend: funcBefore1,
            success: function () {openQuiz(<?php //echo $_POST['id']; ?>);}
        });
    });*/



    $(".coolImg").click(function() { // Событие клика на маленькое изображение
        var img = $(this); // Получаем изображение, на которое кликнули
        var src = img.attr('src'); // Достаем из этого изображения путь до картинки
        $("body").prepend(
            "<div class='popup_bg'></div>" + // Блок, который будет служить фоном затемненным
            "<div class='popupBlock'>" + //Добавляем в тело документа разметку всплывающего окна
            "<div  class='popup_imageBlock'>" +
            "<img src='" + src + "' class='popup_image' />" + // Само увеличенное фото
            "</div></div>");
        $(".popup").fadeIn(0); // Медленно выводим изображение
        $(".popup_bg").click(function() { // Событие клика на затемненный фон
            $(".popupBlock").fadeOut(0); // Медленно убираем всплывающее окно
            setTimeout(function() { // Выставляем таймер
                $(".popupBlock").remove(); // Удаляем разметку всплывающего окна
                $(".popup_bg").remove(); // Удаляем разметку всплывающего окна
            }, 0);
        });
    });
</script>
<?php };

*/

}

 ?>
