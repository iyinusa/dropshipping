<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct() {
		parent::__construct();
    }
	
	public function index() {
		
	}

	////// CUSTOMERS
	public function customers() {
		// check login redirection
		$this->session->set_userdata('afrs_redirect', uri_string());
		if($this->session->userdata('afrs_id') == ''){
			redirect(base_url('auth'));	
		} else {
			$log_id = $this->session->userdata('afrs_id');
			$log_role = strtolower($this->Crud->read_field('id', $log_id, 'user', 'role'));
			if($log_role != 'administrator') { redirect(base_url('profile')); }
			$data['log_id'] = $log_id;
			$data['log_role'] = $log_role;
		}

		$data['title'] =  'Customers | '.app_name;
		$data['page_active'] = 'admin/customers';

		$this->load->view('designs/header', $data);
		$this->load->view('admin/customers', $data);
		$this->load->view('designs/footer', $data);
	}
	public function customers_directory($limit='', $offset='') {
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

		$query = $this->Crud->filter_customer($limit, $offset, $search);
		$count = count($this->Crud->filter_customer('', '', $search));

		if(!empty($query)) {
			foreach($query as $q) {
				$id = $q->id;
				$email = $q->email;
				$firstname = $q->firstname;
				$lastname = $q->lastname;
				$phone = $q->phone;
				$drole = $q->role;
				$img_id = $q->img_id;
				$request_agent = $q->request_agent;
				$img = $this->Crud->image($img_id, 'big');
				$reg_date = date('M d, Y h:i A', strtotime($q->reg_date));

				if($phone) { $phone .= '<br/>';}

				$status_color = '';
				if($drole == 'administrator') { $status_color = 'success'; }
				if($request_agent == 1) { $request_agent = '<small class="has-text-danger">Agent Pending</small>'; } else { $request_agent = ''; }

				$edit_btn = '<a href="javascript:;" class="pop has-text-primary" pageName="'.base_url('admin/customer_form/edit/'.$id).'" pageTitle="Manage '.$firstname.'"><small><i class="fa fa-cog"></i> Manage</small></a>';
				
				$del_btn = '<a href="javascript:;" class="pop has-text-danger" pageName="'.base_url('admin/customer_form/delete/'.$id).'" pageTitle="Delete '.$firstname.'"><small><i class="fa fa-trash"></i> Delete</small></a>';
				$del_btn = '';

				$item .= '
					<div class="flat-card is-auto cart-card">
						<ul class="cart-content">
							<li>
								<div class=""><img alt="" src="'.base_url($img).'" /></div>
								<span class="product-info">
									<span class="small">Customer</span>
									<span>
										<a href="'.base_url('profile/view/'.$id).'">'.$firstname.' '.$lastname.'</a>
										<div>'.$edit_btn.' &nbsp;'.$del_btn.'</div>
									</span>
								</span>
								<span class="product-info">
									<span class="small">Contact</span>
									<span>'.$phone.$email.'</span>
								</span>
								<span class="product-info">
									<span class="small">Type</span>
									<span class="has-text-'.$status_color.'">'.strtoupper($drole).'<br/>'.$request_agent.'</span>
								</span>
								<span class="product-info">
									<span class="small">Registered Date</span>
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
	public function customer_form($type='', $id='') {
		$data['type'] = $type;
		$data['id'] = $id;
		$data['form_link'] = base_url('admin/customer_form/'.$type.'/'.$id);

		$firstname = '';
		$lastname = '';
		$email = '';
		$role = '';
		$wallet = 0;

		if($id) {
			$rec = $this->Crud->read_single('id', $id, 'user');
			if(!empty($rec)) {
				foreach($rec as $r) {
					$firstname = $r->firstname;
					$lastname = $r->lastname;
					$email = $r->email;
					$role = $r->role;
					$wallet = (float)$r->wallet;
				}
			}
		}

		if($type == 'delete') {

		}

		if(empty($type) || $type == 'edit') {
			if($type == 'edit') {
				$data['firstname'] = $firstname;
				$data['lastname'] = $lastname;
				$data['role'] = $role;
				$data['wallet'] = $wallet;
			}

			if($_POST) {
				$roles = $this->input->post('roles');
				$wallets = $this->input->post('wallet');

				$upd['role'] = $roles;
				$upd['wallet'] = $wallets;
				if($roles == 'agent') { $upd['is_agent'] = 1; } else { $upd['is_agent'] = 0; }

				if($this->Crud->update('id', $id, 'user', $upd) <= 0) {
					echo $this->Crud->msg('info', 'No Changes');
				} else {
					echo $this->Crud->msg('success', 'Record Updated');
					echo '<script>location.reload(false);</script>';
				}

				die;
			}
		}

		$this->load->view('admin/customer_form', $data);
	}

	////// AGENTS
	public function agents() {
		// check login redirection
		$this->session->set_userdata('afrs_redirect', uri_string());
		if($this->session->userdata('afrs_id') == ''){
			redirect(base_url('auth'));	
		} else {
			$log_id = $this->session->userdata('afrs_id');
			$log_role = strtolower($this->Crud->read_field('id', $log_id, 'user', 'role'));
			if($log_role != 'administrator') { redirect(base_url('profile')); }
			$data['log_id'] = $log_id;
			$data['log_role'] = $log_role;
		}

		$data['title'] =  'Agents | '.app_name;
		$data['page_active'] = 'admin/agents';

		$this->load->view('designs/header', $data);
		$this->load->view('admin/agents', $data);
		$this->load->view('designs/footer', $data);
	}
	public function agents_directory($limit='', $offset='') {
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

		$query = $this->Crud->filter_agent($limit, $offset, $search);
		$count = count($this->Crud->filter_agent('', '', $search));

		if(!empty($query)) {
			foreach($query as $q) {
				$id = $q->id;
				$email = $q->email;
				$firstname = $q->firstname;
				$lastname = $q->lastname;
				$phone = $q->phone;
				$drole = $q->role;
				$img_id = $q->img_id;
				$request_agent = $q->request_agent;
				$img = $this->Crud->image($img_id, 'big');
				$reg_date = date('M d, Y h:i A', strtotime($q->reg_date));

				if($phone) { $phone .= '<br/>';}

				$status_color = '';
				if($drole == 'administrator') { $status_color = 'success'; }

				$edit_btn = '<a href="javascript:;" class="pop has-text-primary" pageName="'.base_url('admin/agent_form/edit/'.$id).'" pageTitle="Manage '.$firstname.' '.$lastname.'"><small><i class="fa fa-cog"></i> Manage</small></a>';
				
				$del_btn = '<a href="javascript:;" class="pop has-text-danger" pageName="'.base_url('admin/agent_form/delete/'.$id).'" pageTitle="Delete '.$firstname.' '.$lastname.'"><small><i class="fa fa-trash"></i> Delete</small></a>';
				$del_btn = '';

				$item .= '
					<div class="flat-card is-auto cart-card">
						<ul class="cart-content">
							<li>
								<div class=""><img alt="" src="'.base_url($img).'" /></div>
								<span class="product-info">
									<span class="small">Partner</span>
									<span>
										<a href="'.base_url('profile/view/'.$id).'">'.$firstname.' '.$lastname.'</a>
										<div>'.$edit_btn.' &nbsp;'.$del_btn.'</div>
									</span>
								</span>
								<span class="product-info">
									<span class="small">Contact</span>
									<span>'.$phone.$email.'</span>
								</span>
								<span class="product-info">
									<span class="small">Type</span>
									<span class="has-text-'.$status_color.'">'.strtoupper($drole).'</span>
								</span>
								<span class="product-info">
									<span class="small">Registered Date</span>
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
	public function agent_form($type='', $id='') {
		$data['type'] = $type;
		$data['id'] = $id;
		$data['form_link'] = base_url('admin/agent_form/'.$type.'/'.$id);

		$firstname = '';
		$lastname = '';
		$email = '';
		$role = '';
		$wallet = 0;

		if($id) {
			$rec = $this->Crud->read_single('id', $id, 'user');
			if(!empty($rec)) {
				foreach($rec as $r) {
					$firstname = $r->firstname;
					$lastname = $r->lastname;
					$email = $r->email;
					$role = $r->role;
					$wallet = (float)$r->wallet;
				}
			}
		}

		if($type == 'delete') {

		}

		if(empty($type) || $type == 'edit') {
			if($type == 'edit') {
				$data['firstname'] = $firstname;
				$data['lastname'] = $lastname;
				$data['role'] = $role;
				$data['wallet'] = $wallet;
			}

			if($_POST) {
				$roles = $this->input->post('roles');
				$wallets = $this->input->post('wallet');

				$upd['role'] = $roles;
				$upd['wallet'] = $wallets;
				if($roles == 'agent') { $upd['is_agent'] = 1; } else { $upd['is_agent'] = 0; }

				if($this->Crud->update('id', $id, 'user', $upd) <= 0) {
					echo $this->Crud->msg('info', 'No Changes');
				} else {
					echo $this->Crud->msg('success', 'Record Updated');
					echo '<script>location.reload(false);</script>';
				}

				die;
			}
		}

		$this->load->view('admin/agent_form', $data);
	}

	////// SHIPPING
	public function shipping() {
		// check login redirection
		$this->session->set_userdata('afrs_redirect', uri_string());
		if($this->session->userdata('afrs_id') == ''){
			redirect(base_url('auth'));	
		} else {
			$log_id = $this->session->userdata('afrs_id');
			$log_role = strtolower($this->Crud->read_field('id', $log_id, 'user', 'role'));
			if($log_role != 'administrator') { redirect(base_url('profile')); }
			$data['log_id'] = $log_id;
			$data['log_role'] = $log_role;
		}

		$data['title'] =  'Shipping Pricing | '.app_name;
		$data['page_active'] = 'admin/shipping';

		$this->load->view('designs/header', $data);
		$this->load->view('admin/shipping', $data);
		$this->load->view('designs/footer', $data);
	}
	public function shipping_directory($limit='', $offset='') {
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

		$query = $this->Crud->filter_shipping($limit, $offset, $search);
		$count = count($this->Crud->filter_shipping('', '', $search));

		if(!empty($query)) {
			foreach($query as $q) {
				$id = $q->id;
				$type = $q->type;
				$min = (float)$q->min;
				$max = (float)$q->max;
				$price = (float)$q->price;
				$duration = $q->duration;

				$edit_btn = '<a href="javascript:;" class="pop has-text-primary" pageName="'.base_url('admin/shipping_form/edit/'.$id).'" pageTitle="Manage '.$type.'"><small><i class="fa fa-cog"></i> Manage</small></a>';
				
				$del_btn = '<a href="javascript:;" class="pop has-text-danger" pageName="'.base_url('admin/shipping_form/delete/'.$id).'" pageTitle="Delete '.$type.'"><small><i class="fa fa-trash"></i> Delete</small></a>';
				// $del_btn = '';

				$item .= '
					<div class="flat-card is-auto cart-card">
						<ul class="cart-content">
							<li>
								<span class="product-info">
									<span class="small">Type</span>
									<span>'.$type.'</span>
								</span>
								<span class="product-info">
									<span class="small">Min. Kg</span>
									<span>'.number_format($min,2).'</span>
								</span>
								<span class="product-info">
									<span class="small">Max. Kg</span>
									<span>'.number_format($max,2).'</span>
								</span>
								<span class="product-info">
									<span class="small">Price/Kg</span>
									<span>'.number_format($price,2).'</span>
								</span>
								<span class="product-info">
									<span class="small">Delivery</span>
									<span>'.$duration.' days</span>
								</span>
								<span class="product-info">
									<span class="small"></span>
									<span>'.$edit_btn.'<br/>'.$del_btn.'</span>
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
	public function shipping_form($type='', $id='') {
		$data['type'] = $type;
		$data['id'] = $id;
		$data['form_link'] = base_url('admin/shipping_form/'.$type.'/'.$id);

		$e_id = '';
		$e_type = '';
		$e_min = 0;
		$e_max = 0;
		$e_price = 0;
		$e_duration = '';

		if($id) {
			$rec = $this->Crud->read_single('id', $id, 'ship_price');
			if(!empty($rec)) {
				foreach($rec as $r) {
					$e_id = $r->id;
					$e_type = $r->type;
					$e_min = $r->min;
					$e_max = $r->max;
					$e_duration = $r->duration;
					$e_price = (float)$r->price;
				}
			}
		}

		if($type == 'delete') {
			$data['d_id'] = $id;

			if($_POST) {
				$d_id = $this->input->post('d_ship_id');

				if($d_id) {
					if($this->Crud->delete('id', $d_id, 'ship_price') > 0) {
						echo $this->Crud->msg('success', 'Record Updated');
						echo '<script>location.reload(false);</script>';
					} else {
						echo $this->Crud->msg('danger', 'Please try later!');
					}
				}
				
				die;
			}
		}

		if(empty($type) || $type == 'edit') {
			$data['e_id'] = $e_id;
			$data['e_type'] = $e_type;
			$data['e_min'] = $e_min;
			$data['e_max'] = $e_max;
			$data['e_price'] = $e_price;
			$data['e_duration'] = $e_duration;

			if($_POST) {
				$ship_id = $this->input->post('ship_id');
				$types = $this->input->post('types');
				$min = $this->input->post('min');
				$max = $this->input->post('max');
				$price = $this->input->post('price');
				$duration = $this->input->post('duration');

				$upd['type'] = $types;
				$upd['min'] = $min;
				$upd['max'] = $max;
				$upd['price'] = $price;
				$upd['duration'] = $duration;

				if($ship_id) {
					if($this->Crud->update('id', $ship_id, 'ship_price', $upd) <= 0) {
						echo $this->Crud->msg('info', 'No Changes');
					} else {
						echo $this->Crud->msg('success', 'Record Updated');
						echo '<script>location.reload(false);</script>';
					}
				} else {
					if($this->Crud->create('ship_price', $upd) <= 0) {
						echo $this->Crud->msg('danger', 'Please try later!');
					} else {
						echo $this->Crud->msg('success', 'Record Created');
						echo '<script>location.reload(false);</script>';
					}
				}

				die;
			}
		}

		$this->load->view('admin/shipping_form', $data);
	}
}
