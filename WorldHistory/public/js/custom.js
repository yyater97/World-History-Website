$(document).ready(function(){

	$('#btnLogin-Account').click(function(){
    $('.modal-dialog').css('transform','translate(0,-25%)');
    $('.modal-content').css('top',$(document).scrollTop()+70);
    $('.modal-content').fadeIn();
  });

  $('.close-modal').click(function(){
    $('.modal-content').fadeOut();
  });

  $('#btnCancel-Login').click(function(){
    $('.modal-content').fadeOut();
  });

});


