<?php
if (ctype_digit($url2)) {
$user = UserInfo($url2);
};
if (!$user) {//если данных нет, выводим данные пользователя. Понадобится на странице редактирования и тп.
if (ctype_digit($url2)) {
  MessageSend("1","Пользователя с id = ".$url2." не существует","/");
} else {
  $user = UserInfo( $_SESSION['id']);
}
}


 ?>


<div class="sidebar">
  <div class="userAvatar" id="<?php echo $user['avatarID'].'-'.$url2 ?>" style="background-image: url(<?php echo $user['avatar']; ?>)"></div>

<div class="userInfoBlock">

  <div class="userData">
    <div class="name"><?php echo $user['name']." ".$user['lastname']; ?></div>
    <?php if ($user['quote'] != "" ) { ?><q> <?php echo $user['quote'].' </q>'; }; ?>
    <div class="userInfo">
      <?php if ($user['showEmail'] != "nobody" and $url2 != $_SESSION['id']) { ?>
        <span class="boldy">E-mail:</span>  <?php echo $user['email'];
      } else { if ($url2 == $_SESSION['id']) { ?>
        <span class="boldy">E-mail:</span>  <?php echo $user['email']; };}; ?>

      <?php if ($user['birthday'] != "0000-00-00" and $user['showBirthday'] != "nobody" and $url2 != $_SESSION['id']) { ?>
        <span class="boldy">Дата рождения:</span> <?php echo $user['birthday'];
      } else { if ($url2 == $_SESSION['id']) { ?>
        <br><span class="boldy">Дата рождения:</span> <?php echo $user['birthday']; };}; ?>
    </div>
  <?php if ($user['about']) { ?><hr class="profileHR"><span class="boldy">О себе:</span> <?php echo $user['about']; }; ?><br>

</div>

  </div>
</div>
