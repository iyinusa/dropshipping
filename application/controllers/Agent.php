<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Agent extends CI_Controller {

	function __construct() {
		parent::__construct();
    }
	
	public function index() {
		$this->shipping();
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
			if($log_role != 'agent') { redirect(base_url('profile')); }
			$data['log_id'] = $log_id;
			$data['log_role'] = $log_role;
		}

		$data['title'] =  'Shipping Pricing | '.app_name;
		$data['page_active'] = 'agent/shipping';

		$this->load->view('designs/header', $data);
		$this->load->view('agent/shipping', $data);
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

		$query = $this->Crud->filter_ship_price($limit, $offset, $search);
		$count = count($this->Crud->filter_ship_price('', '', $search));

		if(!empty($query)) {
			foreach($query as $q) {
				$id = $q->id;
				$state_id = $q->state_id;
				$state = $this->Crud->read_field('id', $state_id, 'state', 'name');
				if(empty($state)) { $state = 'All'; }
				$amount = (float)$q->amount;

				$edit_btn = '<a href="javascript:;" class="pop has-text-primary" pageName="'.base_url('agent/shipping_form/edit/'.$id).'" pageTitle="Manage '.$state.'"><i class="fa fa-cog"></i> Manage</a>';
				
				$del_btn = '<a href="javascript:;" class="pop has-text-danger" pageName="'.base_url('agent/shipping_form/delete/'.$id).'" pageTitle="Delete '.$state.'"><i class="fa fa-trash"></i> Delete</a>';
				// $del_btn = '';

				$item .= '
					<div class="flat-card is-auto cart-card">
						<ul class="cart-content">
							<li>
								<span class="product-info">
									<span class="small">State</span>
									<span>'.$state.'</span>
								</span>
								<span class="product-info">
									<span class="small">Cost</span>
									<span>&#8358;'.number_format($amount,2).'</span>
								</span>
								<span class="product-info">
									<span class="small"></span>
									<span>'.$edit_btn.'&nbsp;&nbsp;&nbsp;'.$del_btn.'</span>
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
		$data['form_link'] = base_url('agent/shipping_form/'.$type.'/'.$id);

		$e_id = '';
		$e_state_id = '';
		$e_amount = 0;

		if($id) {
			$rec = $this->Crud->read_single('id', $id, 'shipping');
			if(!empty($rec)) {
				foreach($rec as $r) {
					$e_id = $r->id;
					$e_state_id = $r->state_id;
					$e_amount = (float)$r->amount;
				}
			}
		}

		if($type == 'delete') {
			$data['d_id'] = $id;

			if($_POST) {
				$d_id = $this->input->post('d_ship_id');

				if($d_id) {
					if($this->Crud->delete('id', $d_id, 'shipping') > 0) {
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
			$data['e_state_id'] = $e_state_id;
			$data['e_amount'] = $e_amount;

			if($_POST) {
				$ship_id = $this->input->post('ship_id');
				$state_id = $this->input->post('state_id');
				$amount = $this->Crud->to_number($this->input->post('amount'));

				$upd['agent_id'] = $this->session->userdata('afrs_id');
				$upd['state_id'] = $state_id;
				$upd['amount'] = $amount;

				if($ship_id) {
					if($this->Crud->update('id', $ship_id, 'shipping', $upd) <= 0) {
						echo $this->Crud->msg('info', 'No Changes');
					} else {
						echo $this->Crud->msg('success', 'Record Updated');
						echo '<script>location.reload(false);</script>';
					}
				} else {
					if($this->Crud->create('shipping', $upd) <= 0) {
						echo $this->Crud->msg('danger', 'Please try later!');
					} else {
						echo $this->Crud->msg('success', 'Record Created');
						echo '<script>location.reload(false);</script>';
					}
				}

				die;
			}
		}

		$this->load->view('agent/shipping_form', $data);
	}
}
