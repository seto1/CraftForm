$(function(){
	$('.craft_form_submit').click(function() {
		var options = {};
		$.craftForm.submit($(this).parents('form'), options);

		return false;
	});
});
