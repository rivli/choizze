


    function funcBefore() {
        $("body").prepend('<div class="messageshow" style="background:#2b3540" >Загрузка</div>');
    }


    function funcSuccess(data) {
				$('.messageshow').remove();
        $('.sidebar').empty();
        $(".sidebar").prepend(data);
        $(".sidebar").animate({ scrollTop: 0 }, 600);
      /*  $(".popupBlock").fadeIn(); // Медленно выводим изображение
        $(".popup_bg").click(function() { // Событие клика на затемненный фон
            $(".popupBlock").fadeOut(); // Медленно убираем всплывающее окно
						$(".popup_bg").fadeOut(); // Удаляем разметку всплывающего окна
            setTimeout(function() { // Выставляем таймер
                $(".popupBlock").remove(); // Удаляем разметку всплывающего окна
                $(".popup_bg").remove(); // Удаляем разметку всплывающего окна
            }, 0);
        });*/
    }

function openQuiz(id) {
  $.ajax({
      cache: false,
      url: "/ajax/quiz.php",
      type: "POST",
      data: {
          id: id
      },
      dataType: "html",
      beforeSend: funcBefore,
      success: funcSuccess
  });
};



//-------------------Make a voice---------------------------//

function funcSuccess2(data) {
    $('.messageshow').remove();
    $('.quizSB').empty();
    $(".quizSB").prepend(data);
  /*  $(".popupBlock").fadeIn(); // Медленно выводим изображение
    $(".popup_bg").click(function() { // Событие клика на затемненный фон
        $(".popupBlock").fadeOut(); // Медленно убираем всплывающее окно
        $(".popup_bg").fadeOut(); // Удаляем разметку всплывающего окна
        setTimeout(function() { // Выставляем таймер
            $(".popupBlock").remove(); // Удаляем разметку всплывающего окна
            $(".popup_bg").remove(); // Удаляем разметку всплывающего окна
        }, 0);
    });*/
}

function ReloadVoicesNum(id) {
  $.ajax({
      cache: false,
      url: "/ajax/ReloadVoicesNum.php",
      type: "POST",
      data: {
          id: id
      },
      dataType: "html",
      beforeSend: funcBefore,
      success: function (data) {
          $('.messageshow').remove();
        $('.voicesNumber'+id).empty();
        $('.voicesNumber'+id).prepend(data);
      }
  });
}

function castaVote(elem) {
  var id = elem.id;
  var idArr = id.split('-',3);
  if (idArr[2] == 0) {//не голосовал еще
    $.ajax({
        cache: false,
        url: "/ajax/castavote.php",
        type: "POST",
        data: {
            id: id
        },
        dataType: "html",
        beforeSend: funcBefore,
        success: funcSuccess2
    });
  } else {
    if (idArr[1] != idArr[2]) {
      var sure = confirm("Вы уверены, что хотите изменить свой выбор?");
      if (sure) {
        $.ajax({
            cache: false,
            url: "/ajax/castavote.php",
            type: "POST",
            data: {
                id: id
            },
            dataType: "html",
            beforeSend: funcBefore,
            success: funcSuccess2
        });
      }
    } else {
      alert("Вы уже голосовали за этот вариант!");
    }
}

ReloadVoicesNum(idArr[0]);
};



//--------------------Обновление контента главной страницы версия 0.0.-------------------


/*
setInterval(
  function reloader() {
    var quizzy = $('.quiz');
  //alert(quizzy.html());
    for(i = 0;i < quizzy.length;i++) {
    var id = quizzy[i].id;
    $.ajax({
        cache: false,
        url: "/ajax/quizReloader.php",
        type: "POST",
        data: {
            id: id
        },
        dataType: "html",
        success: function(id) {
          id = JSON.parse(id)
          $('.messageshow').remove();
        $('#'+id['id']).empty();
          $("#" + id['id']).prepend(id['content']);
        }
    }); }
  }, 500
)
*/

function showDesc(elem) {
  // $('#quiz'+elem).off();
  //  $('#quiz'+elem).show(1000);
 }

 function hideDesc(elem) {
  //  $('#quiz'+elem).off();
  //  $('#quiz'+elem).hide(1000);
 }





 function share(id,name) {
   $("body").prepend(
       "<div class='popup_bg'></div>" + // Блок, который будет служить фоном затемненным
       "<div class='popupBlock'>" + //Добавляем в тело документа разметку всплывающего окна
       "<div class='popupMessage'>" +
       "<span class='popupName'>Ссылка</span><br>" +
       "<input type='text' class='popupLink' value='https://choizze.com/q/" + id + "' readonly><br>" +
       "<span class='popupName'>Html код</span><br>" +
        "<textarea class='popupHTMLlink' readonly>" + "<a href='https://choizze.com/q/" + id + "'>" + name + "</a></textarea>" +
        "</div>" +
       "</div>");

   $(".popup").fadeIn(0); // Медленно выводим изображение


   $(".popup_bg").click(function() { // Событие клика на затемненный фон
       $(".popupBlock").fadeOut(0); // Медленно убираем всплывающее окно
       setTimeout(function() { // Выставляем таймер
           $(".popupBlock").remove(); // Удаляем разметку всплывающего окна
           $(".popup_bg").remove(); // Удаляем разметку всплывающего окна
       }, 0);
   });
 }

