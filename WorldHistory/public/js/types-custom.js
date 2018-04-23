

$(document).ready(function(){
	$(".menu1").next('ul').toggle();

	$(".menu1").click(function(event) {
		$(this).next("ul").toggle(500);
	});

	$('#btnSearch').click(function(){
    $('#txtSearch').fadeToggle();
  });

  $('#txtSearch').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
      var keyword = $('#txtSearch').val();
      $.post("search.php",{tukhoa:keyword},function(data){
        $('#datasearch').html(data);
      });
    } 
  });
});