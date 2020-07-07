$(window).on('load', function() 
{
// search for item and add to list with totals update
$('#item_search').on('change',
    function() {
		el_item = $(this);
		item_id = el_item.val();
        if (item_id == '')
			return false;

        el_table_body = $('#items').find('tbody');
        last_row_id = el_table_body.find('tr').not('#no_items').length;
        has_no_items = el_table_body.find('tr#no_items').length == 1;

        $.ajax({
            type: 'post',
            url: '/sales/invoice/item/search',
            data: {
                'item_id': item_id,
                'next_row_id': last_row_id + 1,
            },
            success: function(item) 
            {
				if (has_no_items)
					$('#no_items').remove();
	
                el_table_body.append(item);
				// get all inputs from list after add
				linesInputs = getLinesInputs();
				docTotalInputs = getDocTotalInputs();
				// update sale_total amounts
                recalculateDocTotals(linesInputs, docTotalInputs);
				// clear the selected item in search dropdown
				el_item.val(null).trigger('change');
            },
            error: function(jqXhr, textStatus, errorThrown) {
                console.log(errorThrown)
            }
        });
	});

	// fetch edited line item detail to update totals if qty/price/discount changes
	$('tbody#item_detail').on('change', 'td.qty input, td.price > input#unit_price, td.discount > input', 
		function(e) {
			if ($(this).val() == '')
				return false;

			lineInputs = getLineInputs($(this));
			linesInputs = getLinesInputs();
			docTotalInputs = getDocTotalInputs();

			lineInputs[4].val(lineInputs[0].val() * lineInputs[1].val());
			lineInputs[5].text(numeral(lineInputs[4].val()).format('0,0.00'));
			recalculateDocTotals(linesInputs, docTotalInputs);
		});

	// function getLineTotals(el) 
	// {
	// 	el_tbody = el.closest('tbody');
	// 	// fetch all line item amount column values
	// 	return el_tbody.find('.item-total > input');
	// }

	function getLinesInputs() 
	{
		el_tbody = $('tbody#item_detail');

		el_item_description = el_tbody.find('td.item > input.item-description');
		el_item_qty = el_tbody.find('td.qty > input');
		el_item_price = el_tbody.find('td.price > input#unit_price');
		el_item_discount = el_tbody.find('td.discount > input');
		el_item_tax = el_tbody.find('td.price > input#tax_rate');
		el_item_total = el_tbody.find('td.item-total > input');

		el_item_total_display = el_tbody.find('td.item-total > span');

		return [
			el_item_qty, 
			el_item_price, 
			el_item_tax, 
			el_item_discount, 
			el_item_total, 
			el_item_total_display, 
			el_item_description
		];
	}

	function getLineInputs(el) 
	{
		el_table_row = el.closest('tr');
		el_item_description = el_table_row.find('td.item > input.item-description');
		el_item_qty = el_table_row.find('td.qty > input');
		el_item_price = el_table_row.find('td.price > input#unit_price');
		el_item_discount = el_table_row.find('td.discount > input');
		el_item_tax = el_table_row.find('td.price > input#tax_rate');
		el_item_total = el_table_row.find('td.item-total > input');

		el_item_total_display = el_table_row.find('td.item-total > span');

		return [
			el_item_qty, 
			el_item_price, 
			el_item_tax, 
			el_item_discount, 
			el_item_total, 
			el_item_total_display, 
			el_item_description
		];
	}

	// Re-calculate the Line item total
	function recalculateLineTotal(line, item, lineTotalDisplay) 
	{
		line.val(
			(item.unit_price * item.quantity).toFixed(2)
		);
		
		lineTotalDisplay.text(line.val()); 
	}

	// Fetch the Sale summary inputs/labels
	function getDocTotalInputs() 
	{
		el_tfoot = $('#sale_summary');
		el_subtotal = el_tfoot.find('#sale_subtotal');
		el_discount = el_tfoot.find('#sale_discount');
		el_taxtotal = el_tfoot.find('#sale_tax_total');
		el_total = el_tfoot.find('#sale_total');

		return [el_subtotal, el_discount, el_taxtotal, el_total];
	}

    // Re-calculate the Sale summary totals
	function recalculateDocTotals(linesInputs, docTotals) 
	{
		sum_line_total = sum_discount_amount = sum_tax_amount = 0;
		rowCount = -1; // offset to start at 0
		linesInputs[4].each(
			function() {
				rowCount += 1;
				line_total = $(this).val();
				if (line_total == '')
					return false;
				sum_line_total += parseFloat(line_total);

				// discount_amount = line_total * item.disc_percent / (1 + item.disc_percent);
				// sum_discount_amount += parseFloat(discount_amount);
				
				taxRate = linesInputs[2][rowCount]['value'];
				// // skip tax calc if value is null
				if (taxRate)
				{
					tax_amount = line_total * taxRate / (1 + taxRate);
					sum_tax_amount += parseFloat(tax_amount);
				}
			});

		docTotals[0].text(numeral(sum_line_total).format('0,0.00')); // subtotal
		// docTotals[1].text(numeral(sum_discount_total).format('0,0.00')); // discount
		docTotals[2].text(numeral(sum_tax_amount).format('0,0.00')); // tax
		docTotals[3].text(numeral(sum_line_total).format('0,0.00')); // total
		
		// $('#form_discount_total').val(sum_discount_amount.toFixed(2));
		$('#form_subtotal').val(sum_line_total.toFixed(2));
		$('#form_tax_total').val(sum_tax_amount.toFixed(2));
		$('#form_amount_due').val(sum_line_total.toFixed(2));
		unpaidBalance = $('#form_amount_due').val() - $('#form_amount_paid').val();
		$('#form_balance_due').val(unpaidBalance.toFixed(2));
	}

	$('#item_detail').on('click', '.del-item', 
		function(e) {
			// e.preventDefault();
			
			el_table_body = $('#items').find('tbody')
			el_table_row = $(this).closest('tr');
			el_table_row.remove();

			// Only if tracking committed_qty in stock
			// deleteUrl = $(this).data('url');
			// el_id = el_table_row.find('td > .item-id');
			// if (el_id.val() != '')
			// {
			// 	$.ajax({
			// 		url: deleteUrl,
			// 		type: 'post',
			// 		data: {
			// 			'id': el_id.val(),
			// 		},
			// 		success: function(response) {							
			// 			// alert(response);
			// 		},
			// 		error: function(jqXhr, textStatus, errorThrown) {
			// 			console.log(errorThrown);
			// 		}
			// 	});
			// }

			// update sale_total amounts
			lineInputs = getLineInputs(el_table_body);
			linesInputs = getLinesInputs();
			docTotalInputs = getDocTotalInputs();
			lineInputs[4].val(lineInputs[0].val() * lineInputs[1].val());
			lineInputs[5].text(numeral(lineInputs[4].val()).format('0,0.00'));
			recalculateDocTotals(linesInputs, docTotalInputs);

			// stops execution
			return false;
		});

	$('#cash_sale').on('click', 
		function(e) {
			$('.credit-sale').css('display', 'none');
			$('.sales-return').css('display', 'none');
			$('#credit_sale').closest('li').removeClass('disabled');
			$('#sales_return').closest('li').removeClass('disabled');
			$('.cash-sale').css('display', 'table-row');
			$(this).closest('li').addClass('disabled');

			return false;
		});

	$('#credit_sale').on('click', 
		function(e) {
			$('.sales-return').css('display', 'none');
			$('.cash-sale').css('display', 'none');
			$('#cash_sale').closest('li').removeClass('disabled');
			$('#sales_return').closest('li').removeClass('disabled');
			$('.credit-sale').css('display', 'table-row');
			$(this).closest('li').addClass('disabled');

			return false;
		});

	$('#sales_return').on('click', 
		function(e) {
			$('.cash-sale').css('display', 'none');
			$('.credit-sale').css('display', 'none');
			$('.sales-return').css('display', 'table-row');
			$('#cash_sale').closest('li').removeClass('disabled');
			$('#credit_sale').closest('li').removeClass('disabled');
			$(this).closest('li').addClass('disabled');

			return false;
		});

	$('#hold').on('click', 
		function(e) {
			// Check if draft POS Invoices for current user + TODAY date exist in DB
			// if has_no_items then load draft POS Invoices if found
			// else save this Sale as draft status with items loaded
			return false;
		});

	$('#cancel').on('click', 
		function(e) {
			// Check if POS Profile for current user requires approval to cancel
			// if has_no_items then do nothing
			// else Cancel and release committed quantities if applicable
			return false;
		});		
});
