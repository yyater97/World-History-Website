$(document).ready(function(){

	$(document).scroll(function(){
		//alert($(document).scrollTop());
		if($(document).scrollTop()>0)
			$('.navbar').addClass('navbar-scroll');
		else
			$('.navbar').removeClass('navbar-scroll');
	});
});
