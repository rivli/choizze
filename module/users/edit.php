<?php
$title="Редактирование профиля ".$_SESSION['name']." ".$_SESSION['lastname'];

include 'blocks/header.php';
include 'blocks/menu.php';
include 'blocks/userprofile.php';

 ?>
 <div class="content">
<div class='boldText'>Редактирование профиля</div>
<form class='profileEditing' method="POST" action="/query/users/edit" enctype="multipart/form-data">
  <table>
    <tr>
      <td>Имя</td>
      <td><input type="text" name="name" placeholder="Имя" value="<?php echo $user['name']?>" maxlength="40" pattern="[A-Za-z-0-9-А-Яа-яЁё]{4,40}" title="Не менее 3 и не более 40 латынских символов или цифр." ></td>
    </tr>
    <tr>
      <td>Фамилия</td>
      <td><input type="text" name="lastname" placeholder="Фамилия" value="<?php echo $user['lastname']?>" maxlength="40" pattern="[A-Za-z-0-9-А-Яа-яЁё]{3,40}" title="Не менее 3 и не более 40 латынских символов или цифр." ></td>
    </tr>
    <tr>
      <td>Цитата</td>
      <td><input type="text" name="quote" placeholder="Цитата" value="<?php echo $user['quote']?>" maxlength="200" pattern="{3,2000}" title="Не менее 3 и не более 200 символов." ></td>
    </tr>
    <tr>
      <td>Почта</td>
      <td>
        <input type="email" name="email" readonly value="<?php echo $user['email']?>">
        <select name="showEmail" required>
          <option <?php if ($user['showEmail'] == 'nobody') echo 'selected'; ?> value="nobody">Никому не видна</option>
          <option <?php if ($user['showEmail'] == 'all') echo 'selected'; ?> value="all" >Видна всем</option>
          <option <?php if ($user['showEmail'] == 'friends') echo 'selected'; ?> value="friends">Видна только друзьям</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>Дата рождения</td>
      <td>
        <input type="date" name="birthday"  value="<?php if ($user['birthday'] != '0000-00-00') {echo $user['birthday'];} else {echo date("Y-m-d"); }?>" max="<?php echo date("Y-m-d"); ?>" min="<?php $year = date('Y')-150;echo $year.date("-m-d") ?>" >
        <select name="showBirthday" required>
          <option selected value="nobody">Никому не видна</option>
          <option value="all" >Видна всем</option>
          <option value="friends">Видна только друзьям</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>О себе</td>
      <td><textarea type="text" name="about" placeholder="О себе" cols="60" rows="10" ><?php echo $user['about'] ?></textarea></td>
    </tr>
    <tr>
      <td>Аватар</td>
      <td>
        <input type="file" name="avatar">
        <select name="Comments" required>
          <option selected value="1">Разрешить комментарии</option>
          <option  value="0" >Запретить комментарии</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>Описание Аватарки</td>
      <td><textarea type="text" name="avadescription" placeholder="Описание Изображения" cols="60" rows="5" ></textarea></td>
    </tr>
  </table>
<br><input type="submit" name="enter" value="Сохранить">
</form>

</div>
<?php include 'blocks/footer.php'; ?>
