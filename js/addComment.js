$(document).ready(function() { // Ждём загрузки страницы
    function funcBefore() {
        $("body").prepend('<div class="messageshow" style="background:#2b3540" >Загрузка</div>');
    }


    function funcSuccess(data) {
		$('.messageshow').remove();
		$(".popupCommentsShow").empry();
        $(".popupCommentsShow").prepend(data);
        $(".popupCommentsShow").fadeIn(); // Медленно выводим изображение
        
    }
/*
function addComment() {
    alert('noProblem');
/*
       var comment   = $('#commentform').serialize();
        $.ajax({
            url: "/ajax/addComment.php",
            type: "POST",
            data: comment,
            dataType: "html",
            beforeSend: funcBefore,
            success: funcSuccess
        });
}*/


    $("#addComment").bind('click',function() {alert('noProblem');
        /*var comment   = $('#commentform').serialize();
        $.ajax({
            url: "/ajax/addComment.php",
            type: "POST",
            data: comment,
            dataType: "html",
            beforeSend: funcBefore,
            success: funcSuccess
        });
    });*/
});
});