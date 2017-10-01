

    function load() {
        $("body").prepend('<div class="messageshow" style="background:#2b3540" >Загрузка</div>');
    }




function ILikeThis(id) {
        var likeButton = $(".like-quiz-"+id);
        var source = likeButton.attr('src');
        var status;
        if (source == "/resources/design/quiz/like.png") {
          status = 'like';
        } else {
          status = 'unlike';
        }
  $.ajax({
      url: "/ajax/like.php",
      type: "POST",
      data: {
          id: id,
          status: status
      },
      dataType: "text",
      beforeSend: load,
      success:     function (data) {
		$('.messageshow').remove();
        var likeButton = $(".like-quiz-"+id);
        var source = likeButton.attr('src');
        if (source == "/resources/design/quiz/like.png") {
          likeButton.attr('src','/resources/design/quiz/redlike.png');
        } else {
          likeButton.attr('src','/resources/design/quiz/like.png');
        }
        $('.likesNumber'+id).empty();
        $('.likesNumber'+id).prepend(data);
    }
  });
}
