$(document).ready(function(){

$('#addhref').click(function(){
/*var addhref = prompt('Введите ссылку', '');
if (addhref) {
  addhref = '<a href="'+addhref+'">Название ссылки</a>';
  document.getElementById('textarea').value += addhref;}*/
});





$(function(){
    $(".AnsweringButton").on("click", function(){
    var id = $(this).attr('id');
    var name = $(this).attr('value');
    document.getElementById('textarea').value += name+",";
    document.getElementById('mainid').value = id;
    var block = document.getElementById("popupBlock");
    block.scrollTop = block.scrollHeight;
    });
});




});
