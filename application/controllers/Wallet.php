<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Wallet extends CI_Controller {
	private $payStaging;

	function __construct() {
		parent::__construct();
		$this->payStaging = 'test';
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

		///////// payment notification status
		$payment_notify = $this->input->get('pay_status');
		if(!empty($payment_notify)) {
			$status_ref = $this->input->get('flw_ref');
			$status_msg = $this->input->get('flw_msg');
			$pay_msg = '';

			if($payment_notify == 'fail') {
				$pay_msg = '
					<div class="col-sm-12 text-center">
						<h2 class="text-danger">
							<b><i class="ti-close"></i><br />
							'.$status_msg.'</b>
						</h2>
					</div>
				';
			} 
			
			if($payment_notify == 'pass') {
				// verify transaction on RavePay
				$ver_data = array(
					'SECKEY' => $this->Crud->rave_key($this->payStaging, 'secret'),
					'flw_ref' => $status_ref,
					'normalize' => '1'
				);
				$ver = $this->Crud->rave_verify($ver_data, $this->payStaging);
				$redirectURL = base_url('wallet/?pay_status=pass');
				$resp = $this->Crud->rave_save('wallet', $redirectURL, $status_msg, $ver);

				if($resp->status) {
					if($resp->status == false) {
						$pay_msg = '
							<div class="col-sm-12 text-center">
								<h2 class="text-danger">
									<b><i class="ti-close"></i><br />
									'.$resp->msg.'</b>
								</h2>
							</div>
						';
					} else {
						if($resp->id > 0) {
							// register payment
							$user_id = $log_id;
							$paid_by = $this->Crud->read_field('id', $user_id, 'user', 'firstname').' '.$this->Crud->read_field('id', $user_id, 'user', 'lastname');
							$paid_phone = $this->Crud->read_field('id', $user_id, 'user', 'phone');
							$paid_amount = (float)$this->Crud->read_field('id', $resp->id, 'transaction', 'amount');

							// register wallet
							$w_data['user_id'] = $user_id;
							$w_data['type'] = 'Credit';
							$w_data['purpose'] = 'Wallet Funding';
							$w_data['amount'] = $paid_amount;
							$w_data['reg_date'] = date(fdate);
							$w_id = $this->Crud->create('wallet', $w_data);
							if($w_id > 0) {
								$this->Crud->update('id', $resp->id, 'transaction', array('item_id'=>$w_id));

								$wallet_amt = $this->Crud->read_field('id', $user_id, 'user', 'wallet');
								$wallet_amt += $paid_amount;
								$this->Crud->update('id', $user_id, 'user', array('wallet'=>$wallet_amt));

								redirect(base_url('wallet'));
							}
						}

						$pay_msg = '
							<div class="col-sm-12 text-center">
								<h2 class="text-success">
									<b><i class="ti-check"></i><br />
									'.$resp->msg.'</b>
								</h2>
							</div>
						';
					}
				}
			}

			$data['pay_msg'] = $pay_msg;
		}
		///////// payment notification status

		$spent = 0; $balance = 0;
		$getwallet = $this->Crud->read_single('user_id', $log_id, 'wallet');
		if(!empty($getwallet)) {
			foreach($getwallet as $gw) {
				if(strtolower($gw->type) == 'debit') { $spent += (float)$gw->amount; }
			}
		}
		$data['spent'] = $spent;
		$data['balance'] = $this->Crud->read_field('id', $log_id, 'user', 'wallet');;

		$data['title'] =  'Wallet | '.app_name;
		$data['page_active'] = 'wallet';

		$this->load->view('designs/header', $data);
		$this->load->view('user/wallet', $data);
		$this->load->view('designs/footer', $data);
	}

	public function directory($limit='', $offset='') {
		$log_id = $this->session->userdata('afrs_id');
		$rec_limit = 10;
		$item = '';

		if($limit == '') {$limit = $rec_limit;}
		if($offset == '') {$offset = 0;}

		$search = $this->input->get('search');
		$status = $this->input->get('status');

		if($search == 'null' || $search == 'undefined'){$search = '';}
		if($status == '' || $status == 'undefined'){$status = '';}

		$query = $this->Crud->filter_wallet($limit, $offset, $search, $status);
		$count = count($this->Crud->filter_wallet('', '', $search, $status));

		if(!empty($query)) {
			foreach($query as $q) {
				$id = $q->id;
				$type = $q->type;
				$purpose = $q->purpose;
				$amount = $q->amount;
				$reg_date = date('M d, Y h:i A', strtotime($q->reg_date));

				$status_color = 'success';
				if(strtolower($type) == 'debit') { $status_color = 'danger'; }				

				$item .= '
					<div class="flat-card is-auto cart-card">
						<ul class="cart-content">
							<li>
								<div class="has-text-'.$status_color.'"><i class="fa fa-money fa-3x"></i></div>
								<span class="product-info">
									<span class="small">Purpose</span>
									<span>'.$purpose.'</span>
								</span>
								<span class="product-info">
									<span class="small">Type</span>
									<span class="has-text-'.$status_color.'">'.$type.'</span>
								</span>
								<span class="product-info">
									<span class="small">Amount</span>
									<span class="has-text-'.$status_color.'"><small>&#8358;</small><b>'.number_format($amount,2).'</b></span>
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

	public function get_pay($amount) {
		$log_id = $this->session->userdata('afrs_id');
		$amt = 0;
		$btn = '';

		if($amount && $log_id) {
			$amount = $this->Crud->to_number($amount);

			$amt = '
				<div class="has-text-centered"><br/>
					<div class="has-text-grey">ABOUT TO PAY:</div><hr/>
					<h2>&#8358;<b>'.number_format($amount).'</b></h2>
				</div>
			';

			/////// RavePay Script ////////
			$firstname = $this->Crud->read_field('id', $log_id, 'user', 'firstname');
			$lastname = $this->Crud->read_field('id', $log_id, 'user', 'lastname');
			$phone = $this->Crud->read_field('id', $log_id, 'user', 'phone');
			$email = $this->Crud->read_field('id', $log_id, 'user', 'email');
			$meta = json_encode(array('metaname' => 'userid', 'metavalue' => $log_id));
			$subaccounts = json_encode(array('id' => ''));
			$passURL = base_url('wallet/?pay_status=pass');
			$failURL = base_url('wallet/?pay_status=fail');

			$payScript = $this->Crud->rave_script($this->payStaging, $firstname, $lastname, $phone, $email, $amount, app_name.' Payment', 'Fund Wallet', 'card', $meta, $subaccounts, $passURL, $failURL);

			$btn = '<a class="button is-success" onClick="payWithRave();"><i class="fa fa-credit-card"></i>&nbsp;&nbsp; Pay Now</a>'.$payScript;
			/////// RavePay Script ////////
		}

		echo json_encode(array('amount'=>$amt, 'btn'=>$btn));
	}
}
