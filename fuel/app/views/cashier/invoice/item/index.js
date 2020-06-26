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
				// get all inputs from list after adding item 
				linesInputs = getLinesInputs();
				docTotalInputs = getDocTotalInputs();
				// update sales totals in summary panel
                recalculateDocTotals(linesInputs, docTotalInputs);

				el_checkbox_all = $('#select_all_rows > input');
                rowCount = $('#item_detail ' + ' tbody > tr').length;
                if (rowCount > 0)
                    el_checkbox_all.css('display', '');
                else
					el_checkbox_all.css('display', 'none');
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

			lineInputs[4].val((lineInputs[0].val() * lineInputs[1].val()).toFixed(2));
			lineInputs[5].text(lineInputs[4].val());
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

		docTotals[0].text(sum_line_total.toFixed(2)); // subtotal
		// docTotals[1].text(sum_discount_total.toFixed(2)); // discount
		docTotals[2].text(sum_tax_amount.toFixed(2)); // tax
		docTotals[3].text(sum_line_total.toFixed(2)); // total
		
		// $('#form_discount_total').val(sum_discount_amount.toFixed(2));
		$('#form_subtotal').val(sum_line_total.toFixed(2));
		$('#form_tax_total').val(sum_tax_amount.toFixed(2));
		$('#form_amount_due').val(sum_line_total.toFixed(2));
		unpaidBalance = $('#form_amount_due').val() - $('#form_amount_paid').val();
		$('#form_balance_due').val(unpaidBalance.toFixed(2));
	}

	$('#select_all_rows').on('click',
		function(e) {
			select_all_rows = $(this).is(':checked');

			$('#item_detail .select-row > input').each(
				function(e) {
					if (select_all_rows)
						$(this).prop('checked', true);
					else
						$(this).prop('checked', false);
				});

			if (select_all_rows)
				$('#del_item').css('display', '');
			else
				$('#del_item').css('display', 'none');
		});

	$('tbody#item_detail').on('click', '.select-row > input',
		function(e) {
			selected_rows = $('.select-row > input:checked');
			selected_row = $(this).is(':checked');
			
			if (selected_row)
				$('#del_item').css('display', '');
			else {
				$('#select_all_rows').prop('checked', false);
				if (selected_rows.length == 0)
					$('#del_item').css('display', 'none');
			}
		});

	$('#del_item').on('click',
		function(e) {
			e.preventDefault();
			$(this).css('display', 'none');
			deleteUrl = $(this).data('url');
			el_table_body = $('#items').find('tbody')
			rows = el_table_body.find('tr').length;
			
			$('td.select-row > input:checked').each(
				function(e) {
					// if (rows >= 1) {
					// 	$(this).prop('checked', false);
					// 	return false;
					// }
					el_table_row = $(this).closest('tr');
					el_id = el_table_row.find('td.select-row > .item-id');
					
					// skip AJAX call if item not exists in DB or single row in table
					if (el_id.val() != '')
					{
						$.ajax({
							url: deleteUrl,
							type: 'post',
							data: {
								'id': el_id.val(),
							},
							success: function(response) {							
								// alert(response);
							},
							error: function(jqXhr, textStatus, errorThrown) {
								console.log(errorThrown);
							}
						});
					}
					// assumes delete is successful if exists in DB
					el_table_row.remove();
				});

			// update totals fields
			lineInputs = getLineInputs(el_table_body);
			linesInputs = getLinesInputs();
			docTotalInputs = getDocTotalInputs();
			lineInputs[4].val((lineInputs[0].val() * lineInputs[1].val()).toFixed(2));
			lineInputs[5].text(lineInputs[4].val());
			recalculateDocTotals(linesInputs, docTotalInputs);

			el_checkbox_all = $('th > input#select_all_rows');
			el_checkbox_all.prop('checked', false);

			// rowCount = $('tbody#item_detail > tr').length;
			// if (rowCount > 0)
			// 	el_checkbox_all.css('display', '');
			// else
			// 	el_checkbox_all.css('display', 'none');
			// displaySelectAllCheckboxIf()

			// stops execution
			return false;
		});

	function displaySelectAllCheckboxIf() {
		countItemRows = $('tbody#item_detail > tr').length;
		if (countItemRows > 0)
			el_checkbox_all.css('display', '');
		else
			el_checkbox_all.css('display', 'none');
	}
});
