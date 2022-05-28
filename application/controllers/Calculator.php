<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Calculator extends CI_Controller {

	function __construct() {
		parent::__construct();
    }
	
	public function index() {
		

		$data['title'] =  'Shipping Calculator | '.app_name;
		$data['page_active'] = 'calculator';
		
		$this->load->view('designs/header', $data);
		$this->load->view('calculator', $data);
		$this->load->view('designs/footer', $data);
	}

	public function compute() {
		$amount = 0;
		$duration = 0;
		$converse = '';

		if($_POST) {
			$currency = $this->input->post('currency');
			$cost = $this->input->post('cost');
			$quantity = $this->input->post('quantity');
			$weight = $this->input->post('weight');

			if($currency && $cost && $quantity && $weight) {
				$amount = $cost * $quantity * $weight;

				$curr_amt = (float)$this->Crud->read_field('name', $currency, 'currency', 'amount');

				$amount *= $curr_amt;

				$converse = '1 '.ucwords($currency).' = &#8358;'.$curr_amt;
			}
		} 

		echo json_encode(array('amount'=>number_format($amount, 2), 'converse'=>$converse, 'duration'=>$duration));
		die;
	}
}
