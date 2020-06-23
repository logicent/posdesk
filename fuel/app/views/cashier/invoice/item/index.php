<table id="items" class="table table-hover">
	<thead>
		<tr>
			<!-- TODO: hide this column if view mode -->
			<th class="col-md-1 text-center">
				<?= Form::checkbox('select_all_rows', false, array('id' => 'select_all_rows')) ?>
			</th>
			<th class="col-md-5">Item</th>
			<th class="col-md-2">Qty</th>
			<th class="col-md-2">Price</th>
			<!-- show discount if allowed for user -->
			<!-- <th class="col-md-1">Disc %</th> -->
			<th class="col-md-2 text-right">Amount</th>
		</tr>
	</thead>
	<tbody id="item_detail">
<?php 
	if ($pos_invoice_items) : 
        foreach ($pos_invoice_items as $row_id => $item) :
			echo render('cashier/invoice/item/_form', array('invoice_item' => $item, 'row_id' => $row_id));
        endforeach;
    else : ?>
        <tr id="no_data" style="font-size: 115%;">
			<td style="height: 41px" class="text-muted text-center" colspan="5">No data</td>
		</tr>
<?php
    endif ?>
	</tbody>
</table>

<!-- TODO: hide buttons if view mode -->
<div class="form-group">
    <div class="col-md-6">
        <button id="del_item" data-url="/sales/invoice/item/delete" class="btn btn-sm btn-danger" style="display: none;"><i class="fa fa-fw fa-lg fa-trash-o"></i></button>
        <button id="add_item" data-url="/sales/invoice/item/create" class="btn btn-sm btn-default text-muted"><i class="fa fa-fw fa-lg fa-plus"></i></button>
    </div>
	<!--
    <div class="col-md-6 text-right">
        <?php Form::hidden('amounts_tax_inc', Input::post('amounts_tax_inc', isset($pos_invoice) ? $pos_invoice->amounts_tax_inc : '0')); ?>
        <?php Form::checkbox('cb_amounts_tax_inc', null, array('class' => 'cb-checked', 'data-input' => 'amounts_tax_inc')); ?>
        <?php Form::label('Amount is VAT incl.', 'cb_amounts_tax_inc', array('class'=>'control-label')); ?>		
    </div>-->
</div>

<script>
$(window).on('load', function() 
{
	$('#add_item').on('click',
		function(e) {
			el_table_body = $('#items').find('tbody')
			last_row_id = el_table_body.find('tr').not('#no_data').length
			has_no_data = el_table_body.find('tr#no_data').length == 1
			
			if (has_no_data)
				$('#no_data').remove();
			
			$.ajax({
				url: $(this).data('url'),
				type: 'post',
				data: {
					'next_row_id': last_row_id + 1
				},
				success: function(response) {
					el_table_body.append(response);
					el_checkbox_all = $('#select_all_rows > input');

					rowCount = $('#item_detail ' + ' tbody > tr').length;
					if (rowCount > 0)
						el_checkbox_all.css('display', '');
					else
						el_checkbox_all.css('display', 'none');
					// displaySelectAllCheckboxIf()
				},
				error: function(jqXhr, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});
			// stops execution
			return false
		});

	function getLineTotals(el) 
	{
		el_tbody = el.closest('tbody');
		// fetch all line item amount column values
		return el_tbody.find('.item-total > input');
	}

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

	// Re-calculate the Line item totals
	function recalculateLineTotal(line, item, lineTotalDisplay) 
	{
		line.val(
			(item.unit_price * item.quantity).toFixed(2)
		);
		
		lineTotalDisplay.text(line.val()); 
	}

	// Re-calculate the Document totals
	function getDocTotalInputs() 
	{
		el_tfoot = $('#sale_summary');
		el_subtotal = el_tfoot.find('#sale_subtotal');
		el_discount = el_tfoot.find('#sale_discount');
		el_taxtotal = el_tfoot.find('#sale_tax_total');
		el_total = el_tfoot.find('#sale_total');

		return [el_subtotal, el_discount, el_taxtotal, el_total];
	}

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
		
		// $('#form_disc_total').val(sum_discount_amount.toFixed(2));
		$('#form_tax_total').val(sum_tax_amount.toFixed(2));
		$('#form_amount_due').val(sum_line_total.toFixed(2));
		unpaidBalance = $('#form_amount_due').val() - $('#form_amount_paid').val();
		$('#form_balance_due').val(unpaidBalance.toFixed(2));
	}

	// fetch line item detail
	$('#item_detail').on('change', 'td.item > select',
		function() { 
			if ($(this).val() == '')
				return false;

			// linesTotals = getLineTotals($(this));
			lineInputs = getLineInputs($(this));
			linesInputs = getLinesInputs();
			docTotalInputs = getDocTotalInputs();
			lineDesc = $(this).closest('.item-description');

			$.ajax({
				type: 'post',
				url: '/sales/invoice/item/read',
				data: {
					'item_id': $(this).val(),
				},
				success: function(item) 
				{
					item = JSON.parse(item);
					// check if negative stock qty is allowed and/or warn if quantity below 0
					// if (item.quantity <= 0)
					// 	alert(item.item_name + ' is below 0'); // use bootbox or sweetalert

					// set qty to default 1
					item.quantity = 1;
					lineInputs[0].val(item.quantity);
					lineInputs[1].val(item.unit_price);
					lineInputs[2].val(item.tax_rate);
					recalculateLineTotal(lineInputs[4], item, lineInputs[5]);
					recalculateDocTotals(linesInputs, docTotalInputs);
					lineDesc.val(item.description);
				},
				error: function(jqXhr, textStatus, errorThrown) {
					console.log(errorThrown)
				}
			});
		});

	// update line and doc totals if qty/price/discount changes
	$('tbody#item_detail').on('change', 'td.qty input, td.price input#unit_price',
		function(e) {
			if ($(this).val() == '')
				return false;

			// linesTotal = getLineTotals($(this));
			lineInputs = getLineInputs($(this));
			linesInputs = getLinesInputs();
			docTotalInputs = getDocTotalInputs();

			lineInputs[4].val((lineInputs[0].val() * lineInputs[1].val()).toFixed(2));
			lineInputs[5].text(lineInputs[4].val());
			recalculateDocTotals(linesInputs, docTotalInputs);
		});

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
			linesTotal = getLineTotals(el_table_body);
			lineInputs = getLineInputs(el_table_body);
			docTotalInputs = getDocTotalInputs();
			lineInputs[4].val((lineInputs[0].val() * lineInputs[1].val()).toFixed(2));
			lineInputs[5].text(lineInputs[4].val());
			recalculateDocTotals(linesTotal, docTotalInputs);

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
</script>
