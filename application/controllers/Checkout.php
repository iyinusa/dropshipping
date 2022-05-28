<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {
	private $payStaging;

	function __construct() {
		parent::__construct();
		$this->payStaging = 'test';
    }
	
	public function index() {
		$this->step(1);
	}

	public function step($step) {
		// check login redirection
		$this->session->set_userdata('afrs_redirect', uri_string());
		if($this->session->userdata('afrs_id') == ''){
			redirect(base_url('auth'));	
		} else {
			$log_id = $this->session->userdata('afrs_id');
			$data['log_id'] = $log_id;
		}

		$cart_bucket = count($this->Crud->read2('user_id', $log_id, 'new', 1, 'cart'));

		$data['step'] = $step;

		if($step == 2) {
			if($cart_bucket <= 0) { redirect(base_url('shop')); }

			// load agents
			$agents = '';
			$allagents = $this->Crud->read_single('is_agent', 1, 'user');
			$count = 1;
			if(!empty($allagents)) {
				foreach($allagents as $ag) {
					$a_id = $ag->id;
					$a_name = $ag->firstname.' '.$ag->lastname;
					$a_price = (float)$this->Crud->read_field('agent_id', $ag->id, 'shipping', 'amount');
					$a_img_id = $ag->img_id;
					$a_img = $this->Crud->agent($a_img_id, 'big');

					$active = '';
					if(!empty($this->session->userdata('c_agent_id'))) {
						if($this->session->userdata('c_agent_id') == $a_id) { $active = 'is-active'; }
					}

					$agents .= '
						<div class="column is-6" onclick="select_agent('.$a_id.', '.$a_price.');">
							<div class="mini-card '.$active.'">
								<img alt="" src="'.base_url($a_img).'" />
								<div class="shipping-method">'.$a_name.'</div>
								<div class="shipping-price">&#8358;'.number_format($a_price).'</div>
								<div class="active-indicator">
									<i data-feather="check"></i>
								</div>
							</div>
						</div>
					';
					$count += 1;
				}
			}
			$data['agents'] = $agents;

			// get shipping details
			$data['load_list_country'] = $this->load_select_country();
			$this->session->set_userdata('c_ship_address', '');
			if(!empty($this->session->userdata('c_ship_address'))) {
				$s_address = $this->session->userdata('c_ship_address');
			} else {
				$s_address = json_decode($this->Crud->read_field('id', $log_id, 'user', 'shipping_address'));
			}
			$data['s_address'] = $s_address;
			if(!empty($s_address)) {
				$country_id = $s_address->country_id;
				$state_id = $s_address->state_id;
				$data['country'] = $this->Crud->read_field('id', $country_id, 'country', 'name');
				$data['state'] = $this->Crud->read_field('id', $state_id, 'state', 'name');

				$data['load_list_country'] = $this->load_select_country($country_id);
				$data['load_list_state'] = $this->load_select_state($state_id);
			}
		}

		if($step == 3) {
			if($cart_bucket <= 0) { redirect(base_url('shop')); }

			// load cart
			$cart_items = ''; $cart_total = 0;
			$carts = $this->Crud->read2('user_id', $log_id, 'new', 1, 'cart');
			$count = count($carts);
			$cart_ids = array();

			if(!empty($carts)) {
				foreach($carts as $cart) {
					$cart_id = $cart->id;
					if(!in_array($cart_id, $cart_ids)) { $cart_ids[] = $cart_id; }

					$cart_name = $cart->name;
					$cart_img = $cart->img;
					$cart_amount = $cart->amount;
					$cart_qty = $cart->qty;
					$cart_sum = $cart->total;
					$cart_total += (float)$cart_sum;

					$cart_items .= '
						<div class="order-item has-popover-top">
							<div class="item-description">
								<span class="single">'.$cart_name.'</span>
							</div>
							<div class="item-quantity has-text-centered">
								<span>Qty</span>
								<span>'.$cart_qty.'</span>
							</div>
							<div class="item-price has-text-right">
								&#8358;'.number_format((float)$cart_sum,2).'
							</div>
						</div>
						<div class="webui-popover-content">
							<div class="popover-flex-block">
								<div class="icon-block">
									<img src="'.$cart_img.'" alt="">
								</div>
								<div class="content-block">'.$cart_name.'</div>
							</div>
						</div>
					';
				}

				// add shipping to list
				$agent_id = $this->session->userdata('c_agent_id');
				$agent_name = $this->Crud->read_field('id', $agent_id, 'user', 'firstname').' '.$this->Crud->read_field('id', $agent_id, 'user', 'lastname');
				$agent_img_id = $this->Crud->read_field('id', $agent_id, 'user', 'img_id');
				$agent_img = $this->Crud->agent($agent_img_id, 'big');
				$agent_amount = $this->session->userdata('c_agent_amount');
				$cart_total += $agent_amount;

				$cart_items .= '
					<div class="order-item has-popover-top">
						<div class="item-description">
							<span>Shipping</span>
							<span>'.$agent_name.'</span>
						</div>
						<div class="item-quantity has-text-centered">
							<span>Qty</span>
							<span>1</span>
						</div>
						<div class="item-price has-text-right">
							&#8358;'.number_format((float)$agent_amount,2).'
						</div>
					</div>
					<div class="webui-popover-content">
						<div class="popover-flex-block">
							<div class="icon-block">
								<img src="'.base_url($agent_img).'" alt="">
							</div>
							<div class="content-block">This is the shipping method that you chose in the previous step.</div>
						</div>
					</div>
				';
			}

			$this->session->set_userdata('c_cart_ids', $cart_ids);
			$this->session->set_userdata('c_cart_total', $cart_total);

			$data['cart_items'] = $cart_items;
			$data['pdt_count'] = $count;
			$data['cart_total'] = $cart_total;
		}

		if($step == 4) {
			if($cart_bucket <= 0) { redirect(base_url('shop')); }
			$payScript = '';

			$wallet = (float)$this->Crud->read_field('id', $log_id, 'user', 'wallet');

			$order_no = $this->session->userdata('c_order_no');
			$order_amount = (float)$this->Crud->read_field('no', $order_no, 'order', 'amount');
			$order_ship = (float)$this->Crud->read_field('no', $order_no, 'order', 'local_shipping');
			$order_item = $order_amount - $order_ship;

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
					$redirectURL = base_url('checkout/step/4/?pay_status=pass');
					$resp = $this->Crud->rave_save('order', $redirectURL, $status_msg, $ver);

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

								// update order
								$ord_id = $this->Crud->update('no', $order_no, 'order', array('pay_method'=>'card', 'status'=>'submitted', 'amount'=>$paid_amount, 'paid'=>1, 'upd_date'=>date(fdate)));
								if($ord_id > 0) {
									$this->Crud->update('id', $resp->id, 'transaction', array('item_id'=>$ord_id));

									// update cart
									$cart_ids = $this->Crud->read_field('no', $order_no, 'order', 'cart');
									if(!empty($cart_ids)) {
										foreach(json_decode($cart_ids) as $key=>$value) {
											$this->Crud->update('id', $value, 'cart', array('new'=>0));
										}
									}
									$this->session->set_userdata('c_order_no', '');

									redirect(base_url('checkout/step/5'));
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

			// rave amount 
			$amount = $order_amount;

			/////// RavePay Script ////////
			$firstname = $this->Crud->read_field('id', $log_id, 'user', 'firstname');
			$lastname = $this->Crud->read_field('id', $log_id, 'user', 'lastname');
			$phone = $this->Crud->read_field('id', $log_id, 'user', 'phone');
			$email = $this->Crud->read_field('id', $log_id, 'user', 'email');
			$meta = json_encode(array('metaname' => 'userid', 'metavalue' => $log_id));
			$subaccounts = json_encode(array('id' => ''));
			$passURL = base_url('checkout/step/4/?pay_status=pass');
			$failURL = base_url('checkout/step/4/?pay_status=fail');

			$payScript = $this->Crud->rave_script($this->payStaging, $firstname, $lastname, $phone, $email, $amount, app_name.' Payment', 'Order Purchase', 'card', $meta, $subaccounts, $passURL, $failURL);
			/////// RavePay Script ////////

			$data['wallet'] = $wallet;
			$data['order_no'] = $order_no;
			$data['order_amount'] = $order_amount;
			$data['order_ship'] = $order_ship;
			$data['order_item'] = $order_item;
			$data['payScript'] = $payScript;
		}

		$data['title'] =  'Checkout | '.app_name;
		$data['page_active'] = 'checkout';

		$this->load->view('designs/header', $data);
		$this->load->view('shop/checkout', $data);
		$this->load->view('designs/footer', $data);
	}

	public function submit_shipping() {
		$status = false;
		$msg = '';
		$redirect = '';

		$log_id = $this->session->userdata('afrs_id');
		if(empty($log_id)) {
			$msg = $this->Crud->msg('danger', 'Session Expired! Please login again');
		} else {
			if($_POST) {
				$agent_id = $this->input->post('agent_id');
				$agent_amount = $this->input->post('agent_amount');

				if(!$agent_id || !$agent_amount) {
					$msg = $this->Crud->msg('danger', 'Please select Local Agent');
				} else {
					$number = $this->input->post('number');
					$street = $this->input->post('street');
					$postal = $this->input->post('postal');
					$city = $this->input->post('city');
					$country_id = $this->input->post('country_id');
					$state_id = $this->input->post('state_id');

					if(!$number || !$street || !$city || !$country_id || !$state_id) {
						$msg = $this->Crud->msg('danger', 'All Shipping items are compulsory, except Postal Code');
					} else {
						$ship_data['number'] = $number;
						$ship_data['street'] = $street;
						$ship_data['city'] = $city;
						$ship_data['postal'] = $postal;
						$ship_data['country_id'] = $country_id;
						$ship_data['state_id'] = $state_id;

						$s_data['c_agent_id'] = $agent_id;
						$s_data['c_agent_amount'] = $agent_amount;
						$s_data['c_ship_address'] = json_encode($ship_data);

						$this->session->set_userdata($s_data);

						$status = true;

						$redirect = 'checkout/step/3';
					}
				}
			}
		}

		echo json_encode(array('status'=>$status, 'msg'=>$msg, 'redirect'=>$redirect));
		die;
	}

	public function submit_order() {
		$status = false;
		$msg = '';
		$redirect = '';

		$log_id = $this->session->userdata('afrs_id');
		if(empty($log_id)) {
			$msg = $this->Crud->msg('danger', 'Session Expired! Please login again');
		} else {
			$agent_id = $this->session->userdata('c_agent_id');
			$agent_amount = $this->session->userdata('c_agent_amount');
			$ship_address = $this->session->userdata('c_ship_address');
			$cart_ids = $this->session->userdata('c_cart_ids');
			$cart_total = $this->session->userdata('c_cart_total');
			$order_no = $this->Crud->order_no();

			if($order_no && $agent_id && !empty($cart_ids)) {
				$ord_data['user_id'] = $log_id;
				$ord_data['cart'] = json_encode($cart_ids);
				$ord_data['agent_id'] = $agent_id;
				$ord_data['local_shipping'] = $agent_amount;
				$ord_data['shipping_address'] = $ship_address;
				$ord_data['status'] = 'pending';
				$ord_data['amount'] = $cart_total;

				// check for existing order
				$order_id = 0;
				if($this->Crud->check2('user_id', $log_id, 'status', 'pending', 'order') > 0) {
					if(!empty($this->session->userdata('c_order_no'))) {
						$order_no = $this->session->userdata('c_order_no');
					} else {
						$order_no = $this->Crud->read_field2('user_id', $log_id, 'status', 'pending', 'order', 'no');
					}

					$order_id = $this->Crud->update('no', $order_no, 'order', $ord_data);
				}

				if(!$order_id) {
					$ord_data['no'] = $order_no;
					$ord_data['reg_date'] = date(fdate);

					if($this->Crud->check('no', $order_no, 'order') <= 0) {
						$order_id = $this->Crud->create('order', $ord_data);
					}
				}

				if($order_id > 0) {
					$this->session->set_userdata('c_order_no', $order_no);
					$status = true;
					$redirect = 'checkout/step/4';
				}
			}
		}

		echo json_encode(array('status'=>$status, 'msg'=>$msg, 'redirect'=>$redirect));
		die;
	}

	public function wallet_pay() {
		$status = false;
		$msg = '';
		$redirect = '';

		$log_id = $this->session->userdata('afrs_id');
		if(empty($log_id)) {
			$msg = $this->Crud->msg('danger', 'Session Expired! Please login again');
		} else {
			$order_no = $this->session->userdata('c_order_no');

			if($order_no) {
				$wallet = (float)$this->Crud->read_field('id', $log_id, 'user', 'wallet');
				$order_amount = (float)$this->Crud->read_field('no', $order_no, 'order', 'amount');

				if($order_amount > $wallet) {
					$msg = $this->Crud->msg('danger', 'Insufficient Amount! Please fund your Wallet or Pay with Card');
				} else  {
					if($this->Crud->check2('no', $order_no, 'paid', 1, 'order') <= 0) {
						// register wallet
						$ins_wallet['user_id'] = $log_id;
						$ins_wallet['type'] = 'Debit';
						$ins_wallet['purpose'] = 'Order Purchase';
						$ins_wallet['amount'] = $order_amount;
						$ins_wallet['reg_date'] = date(fdate);
						if($this->Crud->create('wallet', $ins_wallet) > 0) {
							$wallet -= $order_amount;
							$this->Crud->update('id', $log_id, 'user', array('wallet'=>$wallet));
							$this->Crud->update('no', $order_no, 'order', array('pay_method'=>'wallet', 'status'=>'submitted', 'amount'=>$order_amount, 'paid'=>1, 'upd_date'=>date(fdate)));
						}

						// update cart
						$cart_ids = $this->Crud->read_field('no', $order_no, 'order', 'cart');
						if(!empty($cart_ids)) {
							foreach(json_decode($cart_ids) as $key=>$value) {
								$this->Crud->update('id', $value, 'cart', array('new'=>0));
							}
						}
					}

					$status = true;
					$redirect = 'checkout/step/5';
				}
			}
		}

		echo json_encode(array('status'=>$status, 'msg'=>$msg, 'redirect'=>$redirect));
		die;
	}

	public function load_select_country($edit_id='') {
		$list = '';
		$lists = $this->Crud->read_order('country', 'name', 'asc');
		if(!empty($lists)) {
			foreach($lists as $ls) {
				if($edit_id == $ls->id){$sel = 'selected';} else {$sel = '';}
				$list .= '<option value="'.$ls->id.'" '.$sel.'>'.strtoupper($ls->name).'</option>';
			}
		}

		$list = '
			<select id="country_id" name="country_id" class="chosen-select form-control" style="width:100%;" onchange="load_state();">
				<option value="0">None</option>
				'.$list.'
			</select>
		';

		return $list;
		die;
	}

	public function load_select_state($edit_id='', $country_id='') {
		$list = '';
		if($country_id) {
			$lists = $this->Crud->read_single_order('country_id', $country_id, 'state', 'name', 'asc');
		} else {
			if($edit_id) {
				$ct_id = $this->Crud->read_field('id', $edit_id, 'state', 'country_id');
				$lists = $this->Crud->read_single_order('country_id', $ct_id, 'state', 'name', 'asc');
			} else {
				$lists = $this->Crud->read_order('state', 'name', 'asc');
			}
		}

		if(!empty($lists)) {
			foreach($lists as $ls) {
				if($edit_id == $ls->id){$sel = 'selected';} else {$sel = '';}
				$list .= '<option value="'.$ls->id.'" '.$sel.'>'.strtoupper($ls->name).'</option>';
			}
		}

		$list = '
			<select id="state_id" name="state_id" class="chosen-select form-control" style="width:100%;">
				<option value="0">None</option>
				'.$list.'
			</select>
			<br/><br/><br/><br/>
		';

		if($country_id) {
			echo $list;
		} else {
			return $list;
		}
		die;
	}
}
