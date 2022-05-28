<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

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


		$data['title'] =  'Orders | '.app_name;
		$data['page_active'] = 'orders';

		$this->load->view('designs/header', $data);
		$this->load->view('user/orders', $data);
		$this->load->view('designs/footer', $data);
	}

	public function directory($limit='', $offset='') {
		$log_id = $this->session->userdata('afrs_id');
		$rec_limit = 9;
		$item = '';

		if($limit == '') {$limit = $rec_limit;}
		if($offset == '') {$offset = 0;}

		$search = $this->input->get('search');
		$status = $this->input->get('status');

		if($search == 'null'){$search = '';}
		if($status == 0 || $status == 'undefined'){$status = '';}

		$query = $this->Crud->filter_order($limit, $offset, $search, $status);
		$count = count($this->Crud->filter_order('', '', $search, $status));

		if(!empty($query)) {
			foreach($query as $q) {
				$id = $q->id;
				$user_id = $q->user_id;
				$no = $q->no;
				$cart = json_decode($q->cart);
				$agent_id = $q->agent_id;
				$status = $q->status;
				$amount = (float)$q->amount;
				$reg_date = date('M d, Y', strtotime($q->reg_date));

				// status
				$status_text = ''; $status_color = ''; $status_stage = 0; $status_bar = '';
				if($status == 'pending') {
					$status_text = 'Pending';
					$status_color = 'is-warning';
					$status_stage = 20;
					$status_bar = '#EDA514';
				}
				if($status == 'submitted') {
					$status_text = 'Submitted';
					$status_color = 'is-info';
					$status_stage = 40;
					$status_bar = '#209CEE';
				}

				// user
				$user_name = $this->Crud->read_field('id', $user_id, 'user', 'firstname').' '.$this->Crud->read_field('id', $user_id, 'user', 'lastname');
				$user_img_id = $this->Crud->read_field('id', $user_id, 'user', 'img_id');
				$user_img = $this->Crud->image($user_img_id, 'big');

				// agent
				$agent_name = $this->Crud->read_field('id', $agent_id, 'user', 'firstname').' '.$this->Crud->read_field('id', $agent_id, 'user', 'lastname');
				$agent_img_id = $this->Crud->read_field('id', $agent_id, 'user', 'img_id');
				$agent_img = $this->Crud->agent($agent_img_id, 'big');

				$item .= '
					<div class="column is-4">
                        <div class="flat-card order-card has-popover-top">
                            <div class="order-info">
                                <span><a href="javascript:;" onclick="return true">ORDER-'.$no.'</a></span>
                                <span class="tag '.$status_color.'">'.$status_text.'</span>
                            </div>
                            <!-- Progress Circle -->
                            <div class="circle-chart-wrapper">
                                <svg class="circle-chart" viewbox="0 0 33.83098862 33.83098862" width="140" height="140" xmlns="http://www.w3.org/2000/svg">
                                    <circle class="circle-chart-background" stroke="#efefef" stroke-width="2" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                                    <circle class="circle-chart-circle" stroke="'.$status_bar.'" stroke-width="2" stroke-dasharray="'.$status_stage.',100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                                </svg>
                                <!-- Icon -->
                                <div class="chart-icon">
                                    <img alt="" src="'.base_url($agent_img).'" style="width:30px;" />
                                </div>
                                <!-- Label -->
                                <div class="ring-title has-text-centered">
                                    <span>'.$status_stage.'% Complete</span>
                                </div>
                            </div>
                        </div>

                        <div class="webui-popover-content">
                            <!-- Popover Block -->
                            <div class="popover-flex-block">
                                <img class="staff-avatar" src="'.base_url($user_img).'" alt="">
                                <div class="content-block">
                                    <label>Order by</label>
                                    <span>'.$user_name.'</span>
                                </div>
                            </div>
                            <!-- Popover Block -->
                            <div class="popover-flex-block">
                                <div class="icon-block">
                                    <i data-feather="clock"></i>
                                </div>
                                <div class="content-block">
                                    <label>Ordered on</label>
                                    <span>'.$reg_date.'</span>
                                </div>
                            </div>
                            <!-- Popover Block -->
                            <div class="popover-flex-block">
                                <div class="icon-block">
                                    <i data-feather="dollar-sign"></i>
                                </div>
                                <div class="content-block">
                                    <label>Order Total</label>
                                    <span>&#8358;'.number_format($amount,2).'</span>
                                </div>
                            </div>
                            <!-- Popover Block -->
                            <div class="popover-flex-block">
                                <div class="icon-block">
                                    <i data-feather="truck"></i>
                                </div>
                                <div class="content-block">
                                    <label>Shipping</label>
                                    <span>'.$agent_name.'</span>
                                </div>
                            </div>
                        </div>
                    </div>
				';
			}
		}

		$resp['item'] = '<div class="columns is-account-grid is-multiline">'.$item.'</div>';

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
