function checkPlacholder() {
    if ($(".main-input-placeholder").html()) {
        $(".main-input").empty();
    }
}
setInterval('InputChecker()',500);
    function InputChecker() {
    if ($(".main-input").is(':empty') && $(".main-input").is(':focus') == false) {
        $(".main-input").prepend('<span class="main-input-placeholder">Ваше сообщение</span>');
    }
    //alert($(".main-input").html().length);
    }


    $('#addlink').click(function(){

      $("body").prepend(
          "<div class='popup_bg' title='Отмена'></div>" + // Блок, который будет служить фоном затемненным
          "<div class='popupBlock'>" + //Добавляем в тело документа разметку всплывающего окна
          "<div class='popupInnerBlock'>" +
          "<span class='popupName'>Вставить ссылку</span><br>" +
          "<form>" +
          '<input type="text" id="link" name="link" placeholder="Ссылка" requiered><br>' +
          '<input type="text" id="linkName" name="linkName" placeholder="Название ссылки" requiered><br>' +
          '<input  type="button" name="inputLink" id="inputLink" value="Вставить" ><br>' +
          "</form>" +
           "</div>" +
          "</div>");

          $("#inputLink").bind("click",function() {
              var link   = $("#link").val();
              var linkName   = $("#linkName").val();
              if (link && linkName) {
                checkPlacholder();
                $(".main-input").append('<a href="'+link+'" class="coolLink">'+linkName+'</a>');
                $(".popupBlock").fadeOut(0); // Медленно убираем всплывающее окно
                setTimeout(function() { // Выставляем таймер
                    $(".popupBlock").remove(); // Удаляем разметку всплывающего окна
                    $(".popup_bg").remove(); // Удаляем разметку всплывающего окна
                }, 0);
              } else {
                alert('Вы не заполнили все поля');
              }
          });


      $(".popup").fadeIn(0); // Медленно выводим изображение


      $(".popup_bg").click(function() { // Событие клика на затемненный фон
          $(".popupBlock").fadeOut(0); // Медленно убираем всплывающее окно
          setTimeout(function() { // Выставляем таймер
              $(".popupBlock").remove(); // Удаляем разметку всплывающего окна
              $(".popup_bg").remove(); // Удаляем разметку всплывающего окна
          }, 0);
      });
    }
    );


    $('#addimage').click(function(){

            $("body").prepend(
                "<div class='popup_bg' title='Отмена'></div>" + // Блок, который будет служить фоном затемненным
                "<div class='popupBlock'>" + //Добавляем в тело документа разметку всплывающего окна
                "<div class='popupInnerBlock'>" +
                "<span class='popupName'>Вставить изображение</span><br>" +
                "<form>" +
                '<input type="text" id="linkToImage" name="linkToImage" placeholder="Ссылка на изображение" required><br>' +
                '<input  type="button" name="inputImage" id="inputImage" value="Вставить" ><br>' +
                "</form>" +
                 "</div>" +
                "</div>");

                $("#inputImage").bind("click",function() {
                    var linkToImage   = $("#linkToImage").val();
                    if (linkToImage) {
                      checkPlacholder();
                      $(".main-input").append('<img src="'+linkToImage+'" class="coolImg" onclick="popUp(this)">');
                      $(".popupBlock").fadeOut(0); // Медленно убираем всплывающее окно
                      setTimeout(function() { // Выставляем таймер
                          $(".popupBlock").remove(); // Удаляем разметку всплывающего окна
                          $(".popup_bg").remove(); // Удаляем разметку всплывающего окна
                      }, 0);
                    } else {
                      alert('Вы не заполнили все поля');
                    }
                });


            $(".popup").fadeIn(0); // Медленно выводим изображение


            $(".popup_bg").click(function() { // Событие клика на затемненный фон
                $(".popupBlock").fadeOut(0); // Медленно убираем всплывающее окно
                setTimeout(function() { // Выставляем таймер
                    $(".popupBlock").remove(); // Удаляем разметку всплывающего окна
                    $(".popup_bg").remove(); // Удаляем разметку всплывающего окна
                }, 0);
            });
    });


    $('#addaudio').click(function(){


                  $("body").prepend(
                      "<div class='popup_bg' title='Отмена'></div>" + // Блок, который будет служить фоном затемненным
                      "<div class='popupBlock'>" + //Добавляем в тело документа разметку всплывающего окна
                      "<div class='popupInnerBlock'>" +
                      "<span class='popupName'>Вставить аудиозапись</span><br>" +
                      "<form>" +
                      '<input type="text" id="audioName" name="audioName" placeholder="Название аудиозаписи" required><br>' +
                      '<input type="text" id="linkToAudio" name="linkToAudio" placeholder="Ссылка на аудиозапись" required><br>' +
                      '<input  type="button" name="inputAudio" id="inputAudio" value="Вставить" ><br>' +
                      "</form>" +
                       "</div>" +
                      "</div>");

                      $("#inputAudio").bind("click",function() {
                          var linkToAudio   = $("#linkToAudio").val();
                          var audioName   = $("#audioName").val();
                          if (linkToAudio) {
                            checkPlacholder();
                            $(".main-input").append('<div><p>'+audioName+'</p><audio src="'+linkToAudio+'" controls>Аудио</audio></div>');
                            $(".popupBlock").fadeOut(0); // Медленно убираем всплывающее окно
                            setTimeout(function() { // Выставляем таймер
                                $(".popupBlock").remove(); // Удаляем разметку всплывающего окна
                                $(".popup_bg").remove(); // Удаляем разметку всплывающего окна
                            }, 0);
                          } else {
                            alert('Вы не заполнили все поля');
                          }
                      });


                  $(".popup").fadeIn(0); // Медленно выводим изображение


                  $(".popup_bg").click(function() { // Событие клика на затемненный фон
                      $(".popupBlock").fadeOut(0); // Медленно убираем всплывающее окно
                      setTimeout(function() { // Выставляем таймер
                          $(".popupBlock").remove(); // Удаляем разметку всплывающего окна
                          $(".popup_bg").remove(); // Удаляем разметку всплывающего окна
                      }, 0);
                  });
      //конец
    });


    $('#addvideo').click(function(){
      $("body").prepend(
          "<div class='popup_bg' title='Отмена'></div>" + // Блок, который будет служить фоном затемненным
          "<div class='popupBlock'>" + //Добавляем в тело документа разметку всплывающего окна
          "<div class='popupInnerBlock'>" +
          "<span class='popupName'>Вставить видеозапись</span><br>" +
          "<form>" +
          '<textarea type="text" id="codeOfVideo" name="codeOfVideo" placeholder="Код видео" required></textarea><br>' +
          '<input  type="button" name="inputVideo" id="inputVideo" value="Вставить" ><br>' +
          "</form>" +
           "</div>" +
          "</div>");

          $("#inputVideo").bind("click",function() {
              var codeOfVideo   = $("#codeOfVideo").val();
              if (codeOfVideo) {
                checkPlacholder();
                $(".main-input").append(codeOfVideo);
                $(".popupBlock").fadeOut(0); // Медленно убираем всплывающее окно
                setTimeout(function() { // Выставляем таймер
                    $(".popupBlock").remove(); // Удаляем разметку всплывающего окна
                    $(".popup_bg").remove(); // Удаляем разметку всплывающего окна
                }, 0);
              } else {
                alert('Вы не заполнили все поля');
              }
          });


      $(".popup").fadeIn(0); // Медленно выводим изображение


      $(".popup_bg").click(function() { // Событие клика на затемненный фон
          $(".popupBlock").fadeOut(0); // Медленно убираем всплывающее окно
          setTimeout(function() { // Выставляем таймер
              $(".popupBlock").remove(); // Удаляем разметку всплывающего окна
              $(".popup_bg").remove(); // Удаляем разметку всплывающего окна
          }, 0);
      });
    });
