<?php
	    $commentClass = "commentsQuiz";
	    $daughterCommentClass = "daughterCommentsQuiz";

	$comment = mysqli_fetch_array(mysqli_query($ALERTSBD, "SELECT * FROM `".$_POST['tablename']."` WHERE `id` = '".$_POST['id']."'"));
	if ($comment['mainid']=="0") {
	$author = UserInfo($comment['user']);
	?>
  <div class="addCommentQuiz">
  <form id="alertForm" class="commentForm" action="" method="post">
    <input type="hidden" id="id" name="id" value="<?php echo $url; ?>" >
      <input type="hidden" id="mainid" name="mainid" value="<?php echo $_POST['id']; ?>" >
      <input type="hidden" id="sender" name="sender" value="<?php echo $_POST['sender']; ?>" >
    <input type="hidden" id="commentsTableName" name="tablename" value="<?php echo $_POST['tablename']; ?>" >
      <textarea type="text" id="Comment" name="text" placeholder="Text" required></textarea><br>
      <img src="/resources/design/addButtons/video.png" class="addButton" title="Вставить видео" alt="Вставить видео" id="addvideo">
      <img src="/resources/design/addButtons/audio.png" class="addButton" title="Вставить аудиозапись" alt="Вставить аудиозапись" id="addaudio">
      <img src="/resources/design/addButtons/image.png" class="addButton" title="Вставить изображение" alt="Вставить изображение" id="addimage">
      <img src="/resources/design/addButtons/link.png" class="addButton" title="Вставить ссылку" onclcik="addLink()" alt="Вставить ссылку" id="addlink">
    <input  type="button" name="SendComment" class="SendButton" style="float:right;" id="addAlert" value="Отправить" >
  </form>
  </div>

	<div class="<?php echo $commentClass ?>" style="margin-bottom:10px;">

	<?php }

	$daughterCommentsCount = mysqli_fetch_array(mysqli_query($ALERTSBD, "SELECT COUNT(*) FROM `".$_POST['tablename']."` WHERE (`mainid` = '".$_POST['id']."')"));
	if ($daughterCommentsCount[0]) {
	$daughterCommentResult = mysqli_query($ALERTSBD, "SELECT * FROM `".$_POST['tablename']."` WHERE (`mainid` = '".$_POST['id']."') ORDER BY id DESC, date DESC LIMIT $daughterCommentsCount[0]");
	while($daughterComment = mysqli_fetch_array($daughterCommentResult)) {
	$author = UserInfo($daughterComment['user']);

	?>
	<div class="<?php echo $daughterCommentClass ?>" >
	              <table>
	                <tbody><tr>
	                  <td class="commentAuthorBlockLeft" style="text-align: left;">
	                    <a href="/u/<?php echo $author['id'] ?>" class="commentAuthorName"><img src="<?php echo $author['avatar'] ?>" class="commentAuthorAva" style="width: 100%;"></a>
	                  </td>
	                  <td class="commentAuthorBlockRight">
	                    <a href="/u/<?php echo $author['id'] ?>" class="authorName"><?php echo $author['name'].' '.$author['lastname'] ?></a>
	                    <span class="addTime"><?php echo $daughterComment['date']." ".$daughterComment['time'] ?></span>
	                    <span class="authorQuote"><?php echo $daughterComment['text'] ?><?php //echo $author['quote'] ?></span>
	                  </td>
	                </tr>
	              </tbody>
							</table>
	<!--<div class="commentTextQuiz"><?php //echo $daughterComment['text'] ?></div>-->

	</div>

<?php	;};
};
$author = UserInfo($comment['user']); ?>

<table>
              <tbody>
              <tr>
                <td class="commentAuthorBlockLeft" style="text-align: left;">
                  <a href="/u/<?php echo $author['id'] ?>" class="commentAuthorName"><img src="<?php echo $author['avatar'] ?>" class="commentAuthorAva" style="width: 100%;"></a>
                </td>
                <td class="commentAuthorBlockRight">
                  <a href="/u/<?php echo $author['id'] ?>" class="authorName"><?php echo $author['name'].' '.$author['lastname'] ?></a>
                  <span class="addTime"><?php echo $comment['date'].' '.$comment['time'] ?></span>
                  <span class="authorQuote"><?php echo $comment['text'] ?><?php //echo $author['quote'] ?></span>
               </td>
              </tr>
            </tbody>
            </table>
<!--<div class="commentTextQuiz"><?php echo $comment['text'] ?></div>-->

</div>



<script type='text/javascript'>

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



    $("#addAlert").bind('click',function() {
        var comment   = $('#alertForm').serialize();
        $.ajax({
            url: "/ajax/SendAlert.php",
            type: "POST",
            data: comment,
            dataType: "html",
            beforeSend: funcBefore1,
            success: function(data) {
              showAlert(<?php echo '"'.$_POST['tablename'].'"'; ?>,<?php echo $_POST['id']; ?>,<?php echo $_POST['sender']; ?>)
            }
        });
    });

    $('#addlink').click(function(){
        var addhref = prompt('Введите ссылку', '');
        if (addhref) {
          addhref = '<a href="'+addhref+'" target="_blank" class="anchor">Название ссылки</a>';
          document.getElementById('Comment').value += addhref;}
    });


</script>
