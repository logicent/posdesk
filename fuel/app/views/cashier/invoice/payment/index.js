$(window).on('load', function() 
{
	// fetch edited line payment detail to update totals if amount changes
	$('tbody#payment_detail').on('change', 'td.amount_paid > input', 
		function(e) {
			if ($(this).val() == '')
				return false;

			lineInputs = getLineInputs($(this));
			linesInputs = getLinesInputs();
			docTotalInputs = getDocTotalInputs();

			lineInputs[4].val((lineInputs[0].val() * lineInputs[1].val()).toFixed(2));
			lineInputs[5].text(lineInputs[4].val());
			recalculateDocTotals(linesInputs, docTotalInputs);
		});

	function getLinesInputs() 
	{
		el_tbody = $('tbody#payment_detail');

		el_payment_amount_paid = el_tbody.find('td.amount_paid > input');
		el_payment_amount_paid_display = el_tbody.find('td.amount_paid > span');

		return [
			el_payment_amount_paid, 
			el_payment_amount_paid_display
		];
	}

	// Fetch the Sale summary inputs/labels
	function getDocTotalInputs() 
	{
		el_tfoot = $('#sale_summary');
		el_amount_paid = el_tfoot.find('#sale_amount_paid');
		el_change_due = el_tfoot.find('#sale_change_due');

		return [el_amount_paid, el_change_due];
	}
});
