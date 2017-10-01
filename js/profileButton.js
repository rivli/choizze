function profileButton() {
  if ($(".profileMenu").css('display') == 'none') {
  $(".profileMenu").show();
  $(".profileMenuCloser").show();
} else {
  $(".profileMenu").hide();
}
}


function profileMenuCloser() {
    $(".profileMenu").hide();
   $(".profileMenuCloser").hide();
}

