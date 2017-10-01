function login() {
  if ($(".logBlock").css('display') == 'none') {
  $(".loginBlock").show();
  $(".logBlock").show();
  $(".logBlockClose").show();
}
}

function loginBlockClose() {
  $(".loginBlock").hide();
  $(".logBlock").hide();
  $(".registrationBlock").hide();
  $(".logBlockClose").hide();
}

function showReg () {
  $(".loginBlock").hide();
  $(".registrationBlock").show();
}
  function showLogin () {
  $(".loginBlock").show();
  $(".registrationBlock").hide();
}
