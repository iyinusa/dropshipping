<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Transactions extends CI_Controller {

	function __construct() {
		parent::__construct();
    }
	
	public function index() {
		// check login redirection
		$this->session->set_userdata('afrs_redirect', uri_string());
		if($this->session->userdata('afrs_id') == ''){
			redirect(base_url('auth'));	
		} else {
			$log_id = $this->session->userdata('afrs_id');
			$data['log_id'] = $log_id;
		}

		$data['title'] =  'Transactions | '.app_name;
		$data['page_active'] = 'transactions';

		$this->load->view('designs/header', $data);
		$this->load->view('user/transaction', $data);
		$this->load->view('designs/footer', $data);
	}

	public function directory($limit='', $offset='') {
		$log_id = $this->session->userdata('afrs_id');
		$log_role = $this->Crud->read_field('id', $log_id, 'user', 'role');
		$rec_limit = 10;
		$item = '';

		if($limit == '') {$limit = $rec_limit;}
		if($offset == '') {$offset = 0;}

		$search = $this->input->get('search');
		// $status = $this->input->get('status');

		if($search == 'null' || $search == 'undefined'){$search = '';}
		// if($status == '' || $status == 'undefined'){$status = '';}

		$query = $this->Crud->filter_transaction($limit, $offset, $search);
		$count = count($this->Crud->filter_transaction('', '', $search));

		if(!empty($query)) {
			foreach($query as $q) {
				$id = $q->id;
				$user_id = $q->user_id;
				$item_id = $q->item_id;
				$item_type = $q->item_type;
				$pay_code = $q->pay_code;
				$ref = $q->trnx_ref;
				$status = $q->trnx_status;
				$msg = $q->trnx_msg;
				$amount = (float)$q->amount;
				$reg_date = date('M d, Y h:i A', strtotime($q->reg_date));

				$status_color = 'success';
				if(strtolower($status) != 'successful') { $status_color = 'danger'; }	
				
				$rave_ref = ''; $user_box = '';
				if(strtolower($log_role) == 'administrator') {
					$rave_ref = '
						<div style="font-size:x-small; margin-top:3px;">
							<u>Flutterwave Ref:</u><br/>
							'.$ref.'
						</div>
					';

					$username = $this->Crud->read_field('id', $user_id, 'user', 'firstname').' '.$this->Crud->read_field('id', $user_id, 'user', 'lastname');
					$user_box = '
						<div style="font-size:x-small; margin-top:3px;">
							<u>Payment By:</u><br/>
							<a href="'.base_url('profile/view/'.$user_id).'">'.$username.'</a>
						</div>
					';
				}

				$item .= '
					<div class="flat-card is-auto cart-card">
						<ul class="cart-content">
							<li>
								<div class="has-text-'.$status_color.'"><i class="fa fa-credit-card fa-3x"></i></div>
								<span class="product-info">
									<span class="small">Code</span>
									<span>'.$pay_code.$rave_ref.'</span>
								</span>
								<span class="product-info">
									<span class="small">Item</span>
									<span>'.$item_type.'</span>
								</span>
								<span class="product-info">
									<span class="small">Amount</span>
									<span class="has-text-'.$status_color.'"><small>&#8358;</small><b>'.number_format($amount,2).'</b>'.$user_box.'</span>
								</span>
								<span class="product-info">
									<span class="small">Date</span>
									<span>'.$reg_date.'</span>
								</span>
							</li>
						</ul>
					</div>
				';
			}
		}

		$resp['item'] = $item;

		$more_record = $count - ($offset + $rec_limit);
		$resp['left'] = $more_record;

		if($count > ($offset + $rec_limit)) { // for load more records
			$resp['limit'] = $rec_limit;
			$resp['offset'] = $offset + $limit;
		} else {
			$resp['limit'] = 0;
			$resp['offset'] = 0;
		}

		echo json_encode($resp);
		die;
	}
}
