$(function(){
	$('.craft-form-rule-select').click(function() {
		var ruleName = $(this).attr('data-craftFormSelectRule');
		$('#CraftFormRuleType').val(ruleName);
		if (ruleName.match(/validate|sendLimit/)) {
			$('.craft-form-rule-table-error-message').show();
		} else {
			$('.craft-form-rule-table-error-message').hide();
		}
		$('.craft-form-rule-select').css('background', 'none');
		$(this).css('background', '#ffffde');
		$('.craft-form-rule-table tr').hide();
		$('.mailfield-rules-' + ruleName).show();
	});

	var ruleType = $('#CraftFormRuleType').val();
	if (ruleType) {
		$('li[data-craftFormSelectRule="' + ruleType + '"]').click();
	}
});
