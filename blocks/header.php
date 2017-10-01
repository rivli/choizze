<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/quizSB.css">
    <link rel="stylesheet" href="/css/profile.css">
    <link rel="stylesheet" href="/css/quiz.css">
    <link rel="stylesheet" href="/css/popup.css">
    <link rel="stylesheet" href="/css/alerts.css">
    <link rel="stylesheet" href="/css/form.css">
  <SCRIPT type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></SCRIPT>
  <script type='text/javascript' src='/js/popup_img.js'></script>
  <script type='text/javascript' src='/js/formButtons.js'></script>
  <script type='text/javascript' src='/js/addComment.js'></script>
  <script type='text/javascript' src='/js/openQuiz.js'></script>
  <script type='text/javascript' src='/js/like.js'></script>
  <script type='text/javascript' src='/js/showAlert.js'></script>
  <?php if ($_SESSION['status'] != 'login') {
    echo '<link rel="stylesheet" href="/css/login.css">';
    echo '<script type="text/javascript" src="/js/login.js"></script>';
  } else {
    echo '<script type="text/javascript" src="/js/profileButton.js"></script>';
  } ?>
  </head>
  <body>
    <?php  if ($_SESSION['message']) MessageShow(); ?>
  <?php if ($_SESSION['status'] != 'login') { ?>
    <div class="logBlockClose" onclick="loginBlockClose()" title="Закрыть" ></div>
    <div class="logBlock">


      <div class="loginBlock">
        <button class="loginButton ">Login</button>
        <button class="registrationButton" onclick="showReg()">Registration</button>
        <form class="login" action="/query/login" method="post">
          <input type="email" id="first" name="email" placeholder="E-mail" required><br>
          <input type="password" name="password" placeholder="Password" required><br>
          <label><input type="checkbox" name="dontRememberMe">Не запоминать</label><br>
          <input type="submit" name="submit" value="GO">
        </form>
      </div>

      <div class="registrationBlock">
        <button class="loginButton" onclick="showLogin()">Login</button>
        <button class="registrationButton">Registration</button>
        <form class="login" action="/query/registration" method="post">
          <input type="text" id="first" name="name" placeholder="Имя" pattern="[A-Za-zА-Яа-яЁё]{3,40}" title="Не менее 3 и не более 20 символов на Английском или Русском языках." required>
            <input type="text" name="lastname" placeholder="Фамилия" pattern="[A-Za-zА-Яа-яЁё]{3,40}" title="Не менее 3 и не более 20 символов на Английском или Русском языках." required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="password" placeholder="Password" required><br>
            <select name="sex" required>
              <option disabled selected value="">Ваш пол</option>
              <option value="male" >Мужчина</option>
              <option value="female">Женщина</option>
            </select>

          <input type="submit" name="submit" value="Регистрация">
        </form>
      </div>
    </div>

  <?php } ?>
