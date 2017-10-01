<?php
$title="Редактировать опрос";

include 'blocks/header.php';
include 'blocks/menu.php';


 ?>
 <div class="content">
<div class='boldText'>Редактировать опрос</div>
<form class='profileEditing' method="POST" action="/query/quizzes/edit" enctype="multipart/form-data">
  <table id='formTable'>
    <tr>
      <td>Имя</td>
      <td><input type="text" name="name" placeholder="Имя" value="<?php echo $quiz['name'] ?>" maxlength="100" title="Не менее 4 и неболее 20 латынских символов или цифр." required></td>
    </tr>
    <tr>
      <td>Описание</td>
      <td><textarea type="text" name="description" placeholder="Описание Опроса" cols="60" rows="5" required><?php echo $quiz['description'] ?></textarea></td>
    </tr>
    <tr>
      <td>Теги</td>
      <td><input type="text" name="tags" value="<?php echo $quiz['tags'] ?>" placeholder="Теги" title="Теги через запятую." required></td>
    </tr>
    <tr id='poster'>
      <td>Постер</td>
      <td>
        <input type="file" name="poster" style="width:50%;">
        <select name="Comments" required>
          <option selected value="1">Разрешить комментарии</option>
          <option  value="0" >Запретить комментарии</option>
        </select>
      </td>
    </tr>


<?php
$query="SELECT * FROM `".$url2."`";
  $result = mysqli_query($QUIZZESBD, $query) or die("sadasda");

while($row = mysqli_fetch_array($result)) { ?>

  <tr>
    <td>Вариант №<?php echo $row['id'] ?></td>
    <td><input type="text" name="option<?php echo $row['id'] ?>"  value="<?php echo $row['name'] ?>" class="option" placeholder="Вариант №<?php echo $row['id'] ?>" title="Нельзя редактировать варинаты ответа." readonly></td>
  </tr>



 <?php };  ?>

  </table>
<br>
<center><input type="button" class='inputButton' style="width:50%;" name="addOption" id="addOption" onclick="addOptionGO()" value="Добавить еще один вариант"></center>
<input type="hidden" name="optionsNum" id="optionsNum" value="2">
<input type="hidden" name="quizID"  value="<?php echo $url2 ?>">
<input type="submit" name="enter" value="Сохранить">
</form>
</div>
<script type="text/javascript">


     var optionsNum = $('#optionsNum');
       function addOptionGO() {

         var optionS = $('.option');
          var NextOption = optionS.length + 1;
        var elem = document.createElement('tr');
          elem.innerHTML = '<td>Вариант №'+NextOption+'</td>'+
         '<td><input type="text" name="option'+NextOption+'" class="option" placeholder="Вариант №'+NextOption+'" maxlength="200"  pattern="{4,200}" title="Не менее 4 и не более 200 символов." required></td>';
         formTable.appendChild(elem);
         optionsNum = $('#optionsNum').val(NextOption);
   }


</script>
<?php
include 'blocks/quizSB.php';
 include 'blocks/footer.php'; ?>
