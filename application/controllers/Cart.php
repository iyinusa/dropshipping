<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

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

		$data['title'] =  'Cart | '.app_name;
		$data['page_active'] = 'cart';

		$this->load->view('designs/header', $data);
		$this->load->view('user/cart', $data);
		$this->load->view('designs/footer', $data);
	}

	public function add() {
		$user_id = $this->session->userdata('afrs_id');
		if($user_id) {
			if($_POST) {
				$id = $this->input->post('id');
				$name = $this->input->post('name');
				$img = $this->input->post('img');
				$amount = $this->input->post('amount');
				$qty = $this->input->post('qty');
				$total = $amount * $qty;

				$ins_data['user_id'] = $user_id;
				$ins_data['product_id'] = $id;
				$ins_data['name'] = $name;
				$ins_data['img'] = $img;
				$ins_data['amount'] = $amount;
				$ins_data['qty'] = $qty;
				$ins_data['total'] = $total;
				$ins_data['new'] = 1;

				if($this->Crud->check3('user_id', $user_id, 'product_id', $id, 'new', 1, 'cart') <= 0) {
					$this->Crud->create('cart', $ins_data);
				}
			}
		}
		die;
	}

	public function update($id) {
		$user_id = $this->session->userdata('afrs_id');
		if($user_id) {
			if($id) {
				// check for owner
				$owner = $this->Crud->read_field('id', $id, 'cart', 'user_id');
				if($owner == $user_id) {
					if($_POST) {
						$qty = $this->input->post('qty');

						// get product amount
						$amt = $this->Crud->read_field('id', $id, 'cart', 'amount');
						$total = $amt * $qty;

						$this->Crud->update('id', $id, 'cart', array('qty'=>$qty, 'total'=>$total));
					}
				}
			}
		}
		die;
	}

	public function remove($id) {
		$user_id = $this->session->userdata('afrs_id');
		if($user_id) {
			if($id) {
				// check for owner
				$owner = $this->Crud->read_field('id', $id, 'cart', 'user_id');
				if($owner == $user_id) {
					$this->Crud->delete('id', $id, 'cart');
				}
			}
		}
		die;
	}

	public function load() {
		$msg = '';
		$count = 0;

		// default cart template
		$msg = '
			<div class="cart-body">
				<div class="empty-cart has-text-centered">
					<h3>Your cart is empty</h3>
					<img src="'.base_url().'assets/images/icons/new-cart.svg" alt="">
					<a href="'.base_url('shop').'" class="button big-button rounded">Start Shopping</a>
					<small>You can create your account later</small>
				</div>
			</div>
		';

		$user_id = $this->session->userdata('afrs_id');
		if($user_id) {
			$carts = $this->Crud->read2('user_id', $user_id, 'new', 1, 'cart');
			$count = count($carts);
			if(!empty($carts)) {
				$cart_items = ''; $cart_total = 0;
				foreach($carts as $cart) {
					$cart_id = $cart->id;
					$cart_name = $cart->name;
					$cart_img = $cart->img;
					$cart_amount = $cart->amount;
					$cart_qty = $cart->qty;
					$cart_sum = $cart->total;
					$cart_total += (float)$cart_sum;

					$cart_items .= '
						<li class="clearfix">
                            <img src="'.$cart_img.'" alt="" />
                            <span class="item-meta">
                                <span class="item-name single">'.$cart_name.'</span>
                                <span class="item-price">&#8358;'.number_format($cart_amount,2).'</span>
                            </span>
                            <span class="quantity">
								<input id="qty'.$cart_id.'" class="input is-rounded" type="number" min="1" value="'.$cart_qty.'" oninput="update_cart('.$cart_id.')">
                            </span>
        
                            <span class="remove-item" onclick="remove_cart('.$cart_id.');">
                                <i class="fa fa-times" class="has-simple-popover" data-content="Remove from Cart" data-placement="top"></i>
                            </span>
                        </li>
					';
				}

				$msg = '
					<div class="cart-action">
						<span class="cart-total">
							<small>&#8358;</small>'.number_format($cart_total,2).'
						</span>
						<a href="'.base_url('cart').'" class="button primary-button feather-button is-bold raised">
							<span>Open Cart</span>
						</a>
					</div>
					<div class="cart-body">
						<ul class="shopping-cart-items">
							'.$cart_items.'
						</ul>
					</div>
				';
			}
		}

		echo json_encode(array('msg'=>$msg, 'count'=>$count));
		die;
	}

	public function load_page_cart() {
		$msg = '';
		$count = 0;

		// default cart template
		$msg = '
			<div class="columns is-account-grid is-multiline">
				<div class="column is-12">
					<div class="flat-card is-auto empty-cart-card">
						<div class="empty-cart has-text-centered">
							<h3>Your cart is currently empty</h3>
							<img src="'.base_url().'assets/images/icons/new-cart.svg" alt="">
							<a href="'.base_url('shop').'" class="button big-button rounded">Continue shopping</a>
							<small>Discover our featured items</small>
						</div>
					</div>
				</div>
			</div>
		';

		$user_id = $this->session->userdata('afrs_id');
		if($user_id) {
			$carts = $this->Crud->read2('user_id', $user_id, 'new', 1, 'cart');
			$count = count($carts);
			if(!empty($carts)) {
				$cart_items = ''; $cart_total = 0;
				foreach($carts as $cart) {
					$cart_id = $cart->id;
					$cart_name = $cart->name;
					$cart_img = $cart->img;
					$cart_amount = $cart->amount;
					$cart_qty = $cart->qty;
					$cart_sum = $cart->total;
					$cart_total += (float)$cart_sum;

					$cart_items .= '
						<div class="flat-card is-auto cart-card">
							<ul class="cart-content">
								<li>
									<img src="'.$cart_img.'" alt="">
									<span class="product-info">
										<span class="single">'.$cart_name.'</span>
									</span>
									<span class="product-price">
										<span>Price</span>
										<span>&#8358;'.number_format($cart_amount,2).'</span>
									</span>

									<span class="product-quantity">
										<span>Qty</span>
										<span class="control">
											<input id="qtty'.$cart_id.'" class="input" type="number" min="1" value="'.$cart_qty.'" oninput="updates_cart('.$cart_id.')">
										</span>
									</span>

									<span class="action">
										<span class="action-link is-remove has-simple-popover" data-content="Remove from Cart" data-placement="top" onclick="remove_cart('.$cart_id.');">
											<a href="javascript:;"><i class="fa fa-times"></i></a>
										</span>
									</span>
								</li>
							</ul>
						</div>
					';
				}

				$msg = '
					<div class="cart-summary">
                        <span class="cart-total">
                            &#8358;'.number_format($cart_total,2).' <small>'.$count.' <span>items in cart</span></small>
                        </span>
                        <a href="'.base_url('checkout').'" class="button feather-button is-bold primary-button raised">
                            CHECKOUT
                        </a>
                    </div>
					<div class="columns is-account-grid is-multiline">
                        <div class="column is-12">
                            '.$cart_items.'
                        </div>
                    </div>
				';
			}
		}

		echo json_encode(array('content'=>$msg, 'total'=>$count));
		die;
	}
}
