<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct() {
		parent::__construct();
    }
	
	public function index() {
		$this->login();
	}

	public function login() {
		// check login redirection
		$redir = $this->session->userdata('afrs_redirect');
		if($this->session->userdata('afrs_id')){
			if($redir=='') {$redir = 'profile';}
			redirect(base_url($redir));	
		}
		
		$data['title'] =  'Login | '.app_name;
		$data['page_active'] = 'login';
		$this->load->view('designs/header', $data);
		$this->load->view('auth/auth', $data);
		$this->load->view('designs/footer', $data);
	}

	public function logout() {
		$data['form_link'] = base_url('auth/login');

		// check login redirection
		if($this->session->userdata('afrs_id')){
			$user_id = $this->session->userdata('afrs_id');
			$up_data['last_log'] = date(fdate);
			$this->Crud->update('id', $user_id, 'user', $up_data);
		}

		$this->session->set_userdata('afrs_id', '');
		$this->session->set_userdata('afrs_logged', false);
		$this->session->sess_destroy();

		$data['title'] =  'Logout | '.app_name;
		$data['page_active'] = 'logout';
		$this->load->view('designs/header', $data);
		$this->load->view('auth/auth', $data);
		$this->load->view('designs/footer', $data);
	}

	public function ajax($type) {
		$status = false;
		$msg = ''; 

		if($_POST) {
			// login
			if($type == 'login') {
				$email = $this->input->post('email');
				$password = $this->input->post('password');

				if(!$email || !$password) {
					$msg = $this->Crud->msg('danger', 'Email and Password required');
				} else {
					if($this->Crud->check2('email', $email, 'password', md5($password), 'user') <= 0) {
						$msg = $this->Crud->msg('danger', 'Invalid Authentication');
					} else {
						$status = true;
						$user_id = $this->Crud->read_field('email', $email, 'user', 'id');

						$this->session->set_userdata('afrs_id', $user_id);
						$msg = $this->Crud->msg('success', 'Login Successful!');
						$this->Crud->update('id', $user_id, 'user', array('last_log'=>date(fdate)));
					}
				}
			}

			// register
			if($type == 'register') {
				$firstname = $this->input->post('firstname');
				$lastname = $this->input->post('lastname');
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				$confirm = $this->input->post('confirm');
				$agent = $this->input->post('agent');

				if(!$firstname || !$lastname || !$email || !$password || !$confirm) {
					$msg = $this->Crud->msg('danger', 'All fields are required');
				} else {
					if($password != $confirm) {
						$msg = $this->Crud->msg('danger', 'Password not matched');
					} else {
						// check if email exist
						if($this->Crud->check('email', $email, 'user') > 0) {
							$msg = $this->Crud->msg('danger', 'Email address already exist');
						} else {
							$r_data['firstname'] = $firstname;
							$r_data['lastname'] = $lastname;
							$r_data['email'] = $email;
							$r_data['password'] = md5($password);
							if($agent == 1) { $r_data['request_agent'] = 1; }
							$r_data['role'] = 'customer';
							$r_data['reg_date'] = date(fdate);
							$r_id = $this->Crud->create('user', $r_data);
							if($r_id > 0) {
								$status = true;
								$msg = $this->Crud->msg('success', 'Account Registered');

								// send email
								if($email) {
									$to = strtolower($email);
									$subject = app_name.' Account';
									$subhead = 'Account Setup';
									$body_msg = '
										<b>Dear '.$firstname.',</b><br /><br />
										Thank you for regestering with '.app_name.'.<br /><br />
										You can now login and start shopping and managing your orders.<br /><br/>
										Thank you.
									';
									$this->Crud->send_email($to, app_email, $subject, $body_msg, app_name, $subhead);

									// send admin mail if agent request
									if($agent == 1) {
										$body_msg = '
											<b>Dear Admin/Support,</b><br /><br />
											'.$firstname.' '.$lastname.' just registered on '.app_name.', also requesting a Shipping Agent approval.<br /><br />
											Thank you.
										';
									} else {
										$body_msg = '
											<b>Dear Admin/Support,</b><br /><br />
											'.$firstname.' '.$lastname.' just registered on '.app_name.'.<br /><br />
											Thank you.
										';
									}

									$this->Crud->send_email(app_email, app_email, $subject, $body_msg, app_name, $subhead);
								}
							} else {
								$msg = $this->Crud->msg('danger', 'Please try later');
							}
						}
					}
				}
			}
		}
		
		$redirect = '';
		if($type == 'login') {
			$redir = $this->session->userdata('afrs_redirect');
			if($redir=='') {$redir = 'profile';}
			$redirect = $redir;
		} 

		echo json_encode(array('status'=>$status, 'msg'=>$msg, 'type'=>$type, 'redirect'=>$redirect));

		die;

	}
}
