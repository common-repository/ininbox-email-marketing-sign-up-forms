jQuery(document).ready(function($){
	$('.type').change(function(){

		if( $(this).val() == 'direct' ){
			var point = $(this).parents('.widget-content');
			$('.anchor', point).slideDown();
		
		}else{
			var point = $(this).parents('.widget-content');
			$('.anchor', point).slideUp();
		}
	})
	

$('.preview_thing').click(function(){
	var id = $(this).attr('data-id');
	
		var txt = '';
		var myWindow = window.open('','','width=640,height=480,scrollbars=yes,location=no,toolbar=no');
		

		txt = $('.form_'+id).html();
		
		myWindow.document.write('<html><body>'+txt+'</body></html>');
		myWindow.focus();
	
})


}); // main jquery container
