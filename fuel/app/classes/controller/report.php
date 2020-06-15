<?php

class Controller_Report extends Controller_Authenticate
{
	public function action_sales_register($show_draft = false)
	{
		if ($show_draft)
			$data['pos_invoices'] = Model_Pos_Invoice::find('all');
		else
		{
			$status = Input::get('status');
			if (!$status)
				$status = Model_Pos_Invoice::INVOICE_STATUS_OPEN;

            $data['pos_invoices'] = Model_Pos_Invoice::find('all', 
                                        array('where' => array(
                                            array('status', '=', $status)
                                        ), 
                                        'order_by' => array('id' => 'desc'), 
                                        'limit' => 1000));
		}
		$data['status'] = $status;
        
		$this->template->title = "Sales Register";
		$this->template->content = View::forge('pos/report/index', $data);
	}

	public function action_item_wise_sales()
	{
		$status = Input::get('status');
		if (!$status)
			$status = Model_Pos_Invoice::INVOICE_STATUS_OPEN;

		$data['pos_invoices'] = Model_Pos_Invoice::find('all', 
									array('where' => array(
										array('status', '=', $status)
									), 
									'order_by' => array('id' => 'desc'), 
									'limit' => 1000));
		$data['status'] = $status;
        
		$this->template->title = "Item-wise Sales Register";
		$this->template->content = View::forge('pos/report/index', $data);
	}	
}
