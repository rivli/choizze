
<?php
$query = "SELECT * FROM `users` WHERE (`id` = '".$_SESSION['id']."')";
$result = mysqli_query($MAINBD, $query);
$user = mysqli_fetch_array($result);

$title="Страница не найдена";

include 'blocks/header.php';
include 'blocks/menu.php';


 ?>

<div class="addCommentQuiz">
<form id="alertForm" class="commentForm" action="" method="post">
  <input type="hidden" id="id" name="id" value="<?php echo $url; ?>" >
    <input type="hidden" id="mainid" name="mainid" value="<?php echo $_POST['id']; ?>" >
    <input type="hidden" id="sender" name="sender" value="<?php echo $_POST['sender']; ?>" >
  <input type="hidden" id="commentsTableName" name="tablename" value="<?php echo $_POST['tablename']; ?>" >
  <div class="main-input" id="Comment" name="text" contenteditable="true" onclick="checkPlacholder()">
    <span class="main-input-placeholder">Ваше сообщение</span>
  </div>
    <br>
    <img src="/resources/design/addButtons/video.png" class="addButton" title="Вставить видео" alt="Вставить видео" id="addvideo">
    <img src="/resources/design/addButtons/audio.png" class="addButton" title="Вставить аудиозапись" alt="Вставить аудиозапись" id="addaudio">
    <img src="/resources/design/addButtons/image.png" class="addButton" title="Вставить изображение" alt="Вставить изображение" id="addimage">
    <img src="/resources/design/addButtons/link.png" class="addButton" title="Вставить ссылку" onclcik="addLink()" alt="Вставить ссылку" id="addlink">
  <input  type="button" name="SendComment" class="SendButton" style="float:right;" id="addAlert" value="Отправить" >
</form>
</div>
<script type="text/javascript" src="/js/form.js">
</script>


<?php include 'blocks/footer.php'; ?>
