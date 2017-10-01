<div class="menu">
  <span class='logo'><a href="/" style="text-decoration:none;">
    <span class="logoSpan">Choizze</span>
  </a></span>
  <form action="/query/searching" method="post">
    <input type="text" name="search" class="searching" <?php if ($searchingWords) echo 'value="'.$searchingWords.'"' ?> placeholder="Найти">
  </form>

  <img src="/resources/design/userAva2.png"  id="userButton" <?php if ($_SESSION['status'] != 'login') {
    echo 'onclick="login()" title="Войти или Зарегистрироваться"';
  } else {
    echo 'onclick="profileButton()" title="Меню профиля"';
  }
  ?> alt="">
</div>

<div class="profileMenuCloser" onclick="profileMenuCloser()"></div>
<div class="profileMenu">
  <a href="/u/<?php echo $_SESSION['id'] ?>" id='first' title="<?php echo $_SESSION['name'].' '.$_SESSION['lastname'] ?>" >
  <table>
    <tr>
      <td><img src="/resources/design/userAva.png" class="menuPicture"></td>
      <td><span class="menuName">Профиль</span></td>
    </tr>
  </table>
  </a>

  <a href="/u/edit">
    <table>
      <tr>
        <td><img src="/resources/design/edit.png" class="menuPicture"></td>
        <td><span class="menuName">Редактировать</span></td>
      </tr>
    </table>
  </a>

  <a href="/u/alerts">
    <table>
      <tr>
        <td><img src="/resources/design/alerts.png" class="menuPicture"></td>
        <td><span class="menuName">Оповещения</span></td>
      </tr>
    </table>
  </a>

  <a href="/q/add">
    <table>
      <tr >
        <td><img src="/resources/design/plus.png" class="menuPicture"></td>
        <td><span class="menuName">Добавить опрос</span></td>
      </tr>
    </table>
  </a>
  <hr>
  <a href="/query/logout" id='last'>
    <table>
      <tr>
        <td><img src="/resources/design/exit.png" class="menuPicture"></td>
        <td><span class="menuName">Выйти</span></td>
      </tr>
    </table>
  </a>
</div>
