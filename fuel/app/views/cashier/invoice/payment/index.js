$(window).on('load', function() 
{
	// fetch edited line payment detail to update totals if amount changes
	$('tbody#payment_detail').on('change', 'td.amount-paid > input', 
		function(e) {
			if ($(this).val() == '')
				return false;

			// lineInputs = getLineInputs($(this));
			paidInputs = getPaymentInputs();
			saleTotalInputs = getSaleTotalInputs();

			recalculateSaleTotals(paidInputs, saleTotalInputs);
		});

	function getPaymentInputs() 
	{
		el_tbody = $('tbody#payment_detail');

		el_payment_amount_paid = el_tbody.find('td.amount-paid > input');
		// el_payment_amount_paid_display = el_tbody.find('td.amount-paid > span');

		return [
			el_payment_amount_paid, 
			// el_payment_amount_paid_display
		];
	}

	// Fetch the Sale summary inputs/labels
	function getSaleTotalInputs() 
	{
		el_tbody = $('#sale_summary');
		el_amount_due = el_tbody.find('#form_amount_due');
		el_amount_paid = el_tbody.find('#form_amount_paid');
		el_change_due = el_tbody.find('#form_change_due');
		el_balance_due = el_tbody.find('#form_balance_due');
		el_paid_display = el_tbody.find('#sale_amount_paid');
		el_change_display = el_tbody.find('#sale_change_due');

		return [
			el_amount_due,
			el_amount_paid,
			el_change_due,
			el_balance_due,
			el_paid_display,
			el_change_display
		];
	}

    // Re-calculate the Sale summary totals
	function recalculateSaleTotals(paidInputs, saleTotals) 
	{
		console.log(paidInputs);

		sum_paid_total = 0;
		rowCount = -1; // offset to start at 0
		paidInputs[0].each(
			function() {
				rowCount += 1;
				paid_total = $(this).val();
				if (paid_total == '')
					return false;
				sum_paid_total += parseFloat(paid_total);
			});

		// amount_paid
		saleTotals[1].val(sum_paid_total.toFixed(2));
		// amount paid display
		saleTotals[4].text(saleTotals[1].val());
		// change_due = amount_paid - amount_due
		saleTotals[2].val(saleTotals[1].val() - saleTotals[0].val());
		// change display
		saleTotals[5].text(saleTotals[2].val());
		// balance_due = amount_due - amount_paid
		saleTotals[3].val(saleTotals[0].val() - saleTotals[1].val());
		
	}
});
