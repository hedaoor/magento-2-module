require(
	[
	'jquery',
	], function($){ 
		$('.submit-btn').click(function(){
			$('.testimonial-form').show();
			$(this).hide();
		})
	}
);