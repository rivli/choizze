<?php

$_POST['data'];
//0 - id Images
//1 - user id
$data = explode('-', $_POST['data']);
$Image = mysqli_fetch_array(mysqli_query($USERSDB , "SELECT * FROM `".$data[1]."-Images` WHERE `id` = '".$data[0]."'"));


 ?>

<div class='popup_bg'></div>
<div class='popupBlock' id='popupBlock'>
  <div  class='popup_imageBlock'>
    <center>
    <img src='<?php echo $Image['url'] ?>' class='popup_image' />
  </center>
  </div>
  <?php if ($Image['description']) { echo "<div class='popup_desc'>".$Image['description']."</div>";} ?>



<hr class="coolHR">
<div class='popupComments'>
    <div class='popupCommentsShow'>
<?php

//Comments

$commentsNumber = mysqli_fetch_array(mysqli_query($COMMENTSBD , "SELECT COUNT(*) FROM `".$data[0]."-".$data[1]."-Images`"));
$i = $commentsNumber[0];
$MainCommentsNumber = mysqli_fetch_array(mysqli_query($COMMENTSBD , "SELECT COUNT(*) FROM `".$data[0]."-".$data[1]."-Images` WHERE `mainid`=0 "));
echo '<center>Комментарии('.$MainCommentsNumber[0].')</center>';
if ($MainCommentsNumber[0] != '0') {
echo '<div style="display:inline-block;width:100%;">';
  $commentClassNum = 1;
while ($i >= 1) {
  if ($commentClassNum == 1) {
    $commentClass = "comments1";
    $daughterCommentClass = "daughterComment1";
    } else {
      $commentClass = "comments2";
      $daughterCommentClass = "daughterComment2";
    };
$comment = mysqli_fetch_array(mysqli_query($COMMENTSBD, "SELECT * FROM `".$data[0]."-".$data[1]."-Images` WHERE `id` = '".$i."'"));
if ($comment['mainid']=="0") {
$author = mysqli_fetch_array(mysqli_query($MAINBD, "SELECT * FROM `users` WHERE `id` = '".$comment['user']."'"));
echo '
<div class="'.$commentClass.'"><a href="/u/'.$comment['user'].'" class="postname" >'.$author['name'].' '.$author['lastname'].'</a><span style="font-size:10px;float:right;">  '.$comment['date'].' '.$comment['time'].'</span><br>'.$comment['text'];
if ($_SESSION['status']=='login' and $comment['user']!=$_SESSION['id']) echo '<br><div  class="AnsweringButton" id="'.$comment['id'].'"  style="display:inline-block;"  value="'.$author['name'].'"  id="AnsweringButton">Ответить</div>';
echo '</div>';

if ($commentClassNum == 0) {$commentClassNum = 1;} else {$commentClassNum = 0;};
}

$daughterCommentsCount = mysqli_fetch_array(mysqli_query($COMMENTSBD, "SELECT COUNT(*) FROM `".$data[0]."-".$data[1]."-Images` WHERE (`mainid` = '".$comment['id']."')"));
if ($daughterCommentsCount[0]) {
$daughterCommentResult = mysqli_query($COMMENTSBD, "SELECT * FROM `".$data[0]."-".$data[1]."-Images` WHERE (`mainid` = '".$comment['id']."') ORDER BY id ASC, date DESC LIMIT $daughterCommentsCount[0]");
while($daughterComment = mysqli_fetch_array($daughterCommentResult)) {
$author = mysqli_fetch_array(mysqli_query($MAINBD, "SELECT * FROM `users` WHERE `id` = '".$daughterComment['user']."'"));
echo '
<div class="'.$daughterCommentClass.'" ><a href="/u/'.$daughterComment['user'].'" class="postname" >'.$author['name'].' '.$author['lastname'].'</a><span style="font-size:10px;float:right;"> '.$daughterComment['date']." ".$daughterComment['time']."</span><br>".$daughterComment['text'];
if ($_SESSION['status']=='login' and $daughterComment['user']!=$_SESSION['id']) echo '<br><div  class="AnsweringButton" id="'.$daughterComment['id'].'"  style="display:inline-block;"  value="'.$author['name'].'"  id="AnsweringButton">Ответить</div>';
echo '</div>';
;};};
$i--;


};
echo '</div>'; };
echo '</div>';
if ($_SESSION['status']=='login') {
 ?>


<form id="commentform" class="commentForm" action="" method="post">
  <input type="hidden" id="id" name="id" value="<?php echo $url; ?>" >
    <input type="hidden" id="mainid" name="mainid" value="0" >
  <input type="hidden" id="commentsTableName" name="tablename" value="<?php echo $data[0]."-".$data[1]."-Images"; ?>" >
    <textarea type="text" id="Comment" name="text" placeholder="Text" required></textarea><br>
      <div class="addButton" style="display:inline-block;width:30px;" title="Вставить ссылку" id="addhref">С</div>
      <div class="addButton" style="display:inline-block;width:30px;" title="Вставить изображение" id="addimage">И</div>
      <div class="addButton" style="display:inline-block;width:30px;" title="Вставить аудиозапись" id="addaudio">А</div>
      <div class="addButton" style="display:inline-block;width:30px;" title="Вставить видео" id="addvideo">В</div>
  <input  type="button" name="enter" id="addComment" value="Отправить" >
</form>
<script type='text/javascript'>

$(function(){
    $(".AnsweringButton").on("click", function(){
    var id = $(this).attr('id');
    var name = $(this).attr('value');
    document.getElementById('Comment').value += name+",";
    document.getElementById('mainid').value = id;
    var block = document.getElementById("popupBlock");
    $(".popupBlock").animate({ scrollTop: block.scrollHeight }, 1000);
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
            success: funcSuccess1
        });
    });

</script>

<?php }; ?>
