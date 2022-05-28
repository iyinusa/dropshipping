<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	function __construct() {
		parent::__construct();
    }
	
	public function index() {
		$this->view();
	}

	public function view($id = '') {
		// check login redirection
		$this->session->set_userdata('afrs_redirect', uri_string());
		if($this->session->userdata('afrs_id') == ''){
			redirect(base_url('auth'));	
		} else {
			$log_id = $this->session->userdata('afrs_id');
			$data['log_id'] = $log_id;

			if($id) {
				$user_id = $id;
				$form_link = base_url('profile/view/'.$id);
			} else {
				$id = $log_id;
				$user_id = $log_id;
				$form_link = base_url('profile/view');
			}
			$data['id'] = $id;
			$data['form_link'] = $form_link;
		}

		// check for update
		if($_POST) {
			////// update user data
			$firstname = $this->input->post('firstname');
			if($firstname) { $user_data['firstname'] = $firstname; }
			$lastname = $this->input->post('lastname');
			if($lastname) { $user_data['lastname'] = $lastname; }
			$phone = $this->input->post('phone');
			if($phone) { $user_data['phone'] = $phone; }
			$email = $this->input->post('email');
			if($email) { $user_data['email'] = $email; }
			
			$shipping_address = array();
			$number = $this->input->post('number');
			$street = $this->input->post('street');
			$city = $this->input->post('city');
			$postal = $this->input->post('postal');
			$country_id = $this->input->post('country_id');
			$state_id = $this->input->post('state_id');
			$shipping_address['number'] = $number;
			$shipping_address['street'] = $street;
			$shipping_address['city'] = $city;
			$shipping_address['postal'] = $postal;
			$shipping_address['country_id'] = $country_id;
			$shipping_address['state_id'] = $state_id;
			$user_data['shipping_address'] = json_encode($shipping_address);

			$img_id = $this->input->post('img_id');
			if($_FILES['pics']['name']){
				$path = 'assets/images/users/'.$user_id;
				$slug = '';
				$upload_image = $this->Crud->img_upload(0, $slug, $path);
				if($upload_image->id > 0) {
					$img_id = $upload_image->id;
				}
			}
			if($img_id) { $user_data['img_id'] = $img_id; }
			if(!empty($user_data)) { $upd1 = $this->Crud->update('id', $user_id, 'user', $user_data); }

			if($upd1 > 0) {
				echo $this->Crud->msg('success', 'Profile Updated');
				echo '<script>location.reload(false);</script>';
			} else {
				echo $this->Crud->msg('warning', 'No Changes');
			}

			die;
		}

		// get data
		if($user_id) {
			// basic
			$data['email'] = $this->Crud->read_field('id', $user_id, 'user', 'email');
			$data['phone'] = $this->Crud->read_field('id', $user_id, 'user', 'phone');
			$data['firstname'] = $this->Crud->read_field('id', $user_id, 'user', 'firstname');
			$data['lastname'] = $this->Crud->read_field('id', $user_id, 'user', 'lastname');
			$data['role'] = $this->Crud->read_field('id', $user_id, 'user', 'role');
			$b_address = json_decode($this->Crud->read_field('id', $user_id, 'user', 'billing_address'));
			$data['b_address'] = $b_address;

			$data['load_list_country'] = $this->load_select_country();
			$s_address = json_decode($this->Crud->read_field('id', $user_id, 'user', 'shipping_address'));
			$data['s_address'] = $s_address;
			if(!empty($s_address)) {
				$country_id = $s_address->country_id;
				$state_id = $s_address->state_id;
				$data['country'] = $this->Crud->read_field('id', $country_id, 'country', 'name');
				$data['state'] = $this->Crud->read_field('id', $state_id, 'state', 'name');

				$data['load_list_country'] = $this->load_select_country($country_id);
				$data['load_list_state'] = $this->load_select_state($state_id);
			}

			$img_id = $this->Crud->read_field('id', $user_id, 'user', 'img_id');
			$img = $this->Crud->image($img_id, 'big');
			$data['img_id'] = $img_id;
			$data['img'] = $img;
			$data['wallet'] = $this->Crud->read_field('id', $user_id, 'user', 'wallet');
			$data['reg_date'] = $this->Crud->read_field('id', $user_id, 'user', 'reg_date');

			$fullname = $this->Crud->read_field('id', $user_id, 'user', 'firstname').' '.$this->Crud->read_field('id', $user_id, 'user', 'lastname');
		}

		$data['title'] =  $fullname.' | '.app_name;
		$data['page_active'] = 'profile';

		$this->load->view('designs/header', $data);
		$this->load->view('user/profile', $data);
		$this->load->view('designs/footer', $data);
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
