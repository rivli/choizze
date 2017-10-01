function funcBefore() {
    $("body").prepend('<div class="messageshow" style="background:#2b3540" >Загрузка</div>');
}


function funcSuccess(data) {
    $('.messageshow').remove();
    $('.sidebar').empty();
    $(".sidebar").prepend(data);
    $(".sidebar").animate({ scrollTop: 0 }, 600);
}

function showAlert(tablename,id,sender) {
$.ajax({
  cache: false,
  url: "/ajax/alertMessages.php",
  type: "POST",
  data: {
      id: id,tablename: tablename,sender: sender
  },
  dataType: "html",
  beforeSend: funcBefore,
  success: funcSuccess
});
};
