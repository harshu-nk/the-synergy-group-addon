jQuery(document).ready(function($){
	$('.edit-pencil:not(.bio-edit-pencil)').click( function(e){
        e.preventDefault();
		$(this).toggleClass('active');
        $(this).parent('.line-row').find('.form-row').toggle();
        $(this).parent('.line-row').find('.form-curr-value').toggle();
   });

   $('.bio-edit-pencil').click(function(e){
	e.preventDefault();
	$('.bio').find('.form-curr-value').toggle();
	$('.bio').find('.form-row').toggle();
   });

});
