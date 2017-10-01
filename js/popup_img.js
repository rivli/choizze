$(document).ready(function() { // Ждём загрузки страницы

    $(".popupimage").click(function() { // Событие клика на маленькое изображение
        var img = $(this); // Получаем изображение, на которое кликнули
        var src = img.attr('src'); // Достаем из этого изображения путь до картинки
        $("body").prepend(
            "<div class='popup_bg'></div>" + // Блок, который будет служить фоном затемненным
            "<div class='popupBlock'>" + //Добавляем в тело документа разметку всплывающего окна
            "<div  class='popup_imageBlock'>" +
            "<img src='" + src + "' class='popup_image' />" + // Само увеличенное фото
            "</div></div>");
        $(".popup").fadeIn(0); // Медленно выводим изображение
        $(".popup_bg").click(function() { // Событие клика на затемненный фон
            $(".popupBlock").fadeOut(0); // Медленно убираем всплывающее окно
            setTimeout(function() { // Выставляем таймер
                $(".popupBlock").remove(); // Удаляем разметку всплывающего окна
                $(".popup_bg").remove(); // Удаляем разметку всплывающего окна
            }, 0);
        });
    });



    $(".coolImg").click(function() { // Событие клика на маленькое изображение
        var img = $(this); // Получаем изображение, на которое кликнули
        var src = img.attr('src'); // Достаем из этого изображения путь до картинки
        $("body").prepend(
            "<div class='popup_bg'></div>" + // Блок, который будет служить фоном затемненным
            "<div class='popupBlock'>" + //Добавляем в тело документа разметку всплывающего окна
            "<div  class='popup_imageBlock'>" +
            "<img src='" + src + "' class='popup_image' />" + // Само увеличенное фото
            "</div></div>");
        $(".popup").fadeIn(0); // Медленно выводим изображение
        $(".popup_bg").click(function() { // Событие клика на затемненный фон
            $(".popupBlock").fadeOut(0); // Медленно убираем всплывающее окно
            setTimeout(function() { // Выставляем таймер
                $(".popupBlock").remove(); // Удаляем разметку всплывающего окна
                $(".popup_bg").remove(); // Удаляем разметку всплывающего окна
            }, 0);
        });
    });


    /*
      $(".userAvatar").click(function(){	// Событие клика на маленькое изображение
    	  	var img = $(this);	// Получаем изображение, на которое кликнули
    			var desc = $("#AvaDesc").html();
          if (desc) {
            desc = "<div class='popup_desc'>"+desc+"</div>";
          } else {desc = '';};
    		var src = img.css('background-image'); // Достаем из этого изображения путь до картинки
        src = src.replace('url(','').replace(')','').replace(/\"/gi, "");
    		$("body").prepend("<div class='popup_bg'></div><div class='popupBlock'>"+ //Добавляем в тело документа разметку всплывающего окна
    						 "<div  class='popup_imageBlock'>"+ // Блок, который будет служить фоном затемненным
    						 "<img src='"+src+"' class='popup_image' />"+ // Само увеличенное фото
    						 "</div>"+
    						 desc+
    						 "</div>");
    		$(".popupBlock").fadeIn(800); // Медленно выводим изображение
    		$(".popup_bg").click(function(){	// Событие клика на затемненный фон
    			$(".popupBlock").fadeOut(800);	// Медленно убираем всплывающее окно
    			setTimeout(function() {	// Выставляем таймер
    			  $(".popupBlock").remove(); // Удаляем разметку всплывающего окна
    			  $(".popup_bg").remove(); // Удаляем разметку всплывающего окна
    			}, 800);
    		});
    	});

    });*/



    function funcBefore() {
        $("body").prepend('<div class="messageshow" style="background:#2b3540" >Загрузка</div>');
    }


    function funcSuccess(data1) {
				$('.messageshow').remove();
        $("body").prepend(data1);
        $(".popupBlock").fadeIn(); // Медленно выводим изображение
        $(".popup_bg").click(function() { // Событие клика на затемненный фон
            $(".popupBlock").fadeOut(); // Медленно убираем всплывающее окно
						$(".popup_bg").fadeOut(); // Удаляем разметку всплывающего окна
            setTimeout(function() { // Выставляем таймер
                $(".popupBlock").remove(); // Удаляем разметку всплывающего окна
                $(".popup_bg").remove(); // Удаляем разметку всплывающего окна
            }, 0);
        });
    }


    $(".userAvatar").click(function() {
        $.ajax({
            cache: false,
            url: "/ajax/popup.php",
            type: "POST",
            data: {
                data: $(this).attr('id')
            },
            dataType: "html",
            beforeSend: funcBefore,
            success: funcSuccess
        });
    });
});
