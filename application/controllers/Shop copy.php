<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends CI_Controller {

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


		$data['title'] =  'Shop | '.app_name;
		$data['page_active'] = 'shop';

		$this->load->view('designs/header', $data);
		$this->load->view('shop/shop', $data);
		$this->load->view('designs/footer', $data);
	}

	public function search() {
		// check login redirection
		$this->session->set_userdata('afrs_redirect', uri_string());
		if($this->session->userdata('afrs_id') == ''){
			redirect(base_url('auth'));	
		} else {
			$log_id = $this->session->userdata('afrs_id');
			$data['log_id'] = $log_id;
		}


		$data['title'] =  'Search Product | '.app_name;
		$data['page_active'] = 'search';

		$this->load->view('designs/header', $data);
		$this->load->view('shop/search', $data);
		$this->load->view('designs/footer', $data);
	}

	public function product($id='') {
		// check login redirection
		$this->session->set_userdata('afrs_redirect', uri_string());
		if($this->session->userdata('afrs_id') == ''){
			redirect(base_url('auth'));	
		} else {
			$log_id = $this->session->userdata('afrs_id');
			$data['log_id'] = $log_id;
		}

		if(empty($id) || $this->Crud->check('id', $id, 'product') <= 0) { redirect(base_url('shop')); }

		$data['id'] = $id;

		$product = $this->Crud->read_field('id', $id, 'product', 'response');
		$response = json_decode($product);
		$items = $response->item;

		// get images
		$data['pdt_img'] = $items->pic_url;
		$img = '<div><img data-action="zoom" alt="" src="'.$items->pic_url.'" /></div>';
		$imgs = $items->item_imgs;
		if(!empty($imgs)) {
			foreach($imgs as $im) {
				if($im->url != $items->pic_url) { $img .= '<div><img data-action="zoom" alt="" src="'.$im->url.'" /></div>'; }
			}
		}
		$data['pdt_imgs'] = $img;

		// get title
		$data['pdt_title'] = $items->title;

		// get url
		$pdt_url = $items->detail_url;
		$data['pdt_url'] = $pdt_url;

		// get store nickname
		$data['pdt_nick'] = $items->nick;

		// get short desc
		$data['pdt_desc_short'] = $items->desc_short;

		// get short desc
		$data['pdt_desc'] = $items->desc;

		// get price
		$price = $items->price;
		$original_price = $items->orginal_price;
		if(strpos($pdt_url, 'aliexpress') !== false) {
			$price = explode('$', $price);
			$price = $price[1];
			$price = $this->Crud->to_number($price);
			$price = $this->Crud->convert($price, 'dollar');
			$original_price = explode('$', $original_price);
			$original_price = $original_price[1];
			$original_price = $this->Crud->to_number($original_price);
			$original_price = $this->Crud->convert($original_price, 'dollar');
		}

		if(strpos($pdt_url, '1688') !== false) {
			$price = $this->Crud->to_number($price);
			$price = $this->Crud->convert($price, 'yen');
			$original_price = $this->Crud->to_number($original_price);
			$original_price = $this->Crud->convert($original_price, 'yen');
		}
		
		
		$data['pdt_price'] = $price;
		$data['pdt_original_price'] = $original_price;

		// get number in stock
		$data['pdt_num'] = $items->num;

		// get specifications
		$pdt_specs = '';
		$specs = $items->props;
		if(!empty($specs)) {
			foreach($specs as $sp) {
				$pdt_specs .= '
					<div class="column is-6 has-text-grey">
						<small><b>'.ucwords($sp->name).': </b>
						'.$sp->value.'</small>
					</div>
				';
			}
		}
		$data['pdt_specs'] = $pdt_specs;

		////// others
		// load recommended
		$recommended = '';
		$recomm = $this->Crud->read('product', 3, 'RANDOM');
		if(!empty($recomm)) {
			foreach($recomm as $re) {
				$r_resp = json_decode($re->response);
				$r_img = $r_resp->item->pic_url;
				$r_title = $r_resp->item->title;
				$r_desc = $r_resp->item->desc_short;
				
				if($re->id != $id) {
					$recommended .= '
						<div class="column is-3">
							<div class="featured-product">
								<div class="image">
									<img src="'.$r_img.'" alt="">
								</div>
								<div class="product-info has-text-centered">
									<a href="'.base_url('shop/product/'.$re->id).'"><h3 class="product-name single">'.$r_title.'</h3></a>
									<p class="product-description single">'.$r_desc.'</p>
								</div>
							</div>
						</div>
					';
				}
			}
		}
		$data['pdt_recommended'] = $recommended;

		$data['title'] =  'Product | '.app_name;
		$data['page_active'] = 'product';

		$this->load->view('designs/header', $data);
		$this->load->view('shop/product', $data);
		$this->load->view('designs/footer', $data);
	}

	public function find_product() {
		$status = false;
		$msg = '';
		$pdt_id = 0;

		if($_POST) {
			$link = $this->input->post('link');
			if(!$link) {
				$msg = $this->Crud->msg('danger', 'Copy and Paste Product Link');
			} else {
				// remove existing product in session
				$this->session->set_userdata('afrs_current_product', '');

				// first check database for product
				$is_product = $this->Crud->read_field('link', $link, 'product', 'response');
				if(empty($is_product)) {
					$msg = $this->Crud->msg('warning', 'Product can not be loaded');

					// search through dropshipping api

				} else {
					$pdt_id = $this->Crud->read_field('link', $link, 'product', 'id');
				}

				if(!empty($is_product)) {
					$status = true;
					$this->session->set_userdata('afrs_current_product', $is_product);

					// register in database
					$ins_data['link'] = $link;
					$ins_data['response'] = $is_product;
					if($this->Crud->check('link', $link, 'product') <= 0) {
						$pdt_id = $this->Crud->create('product', $ins_data);
					}
				}
			}
		}

		echo json_encode(array('status'=>$status, 'id'=>$pdt_id, 'msg'=>$msg));
	}

	public function product_directory($limit='', $offset='') {
		$log_id = $this->session->userdata('afrs_id');
		$rec_limit = 10;
		$item = '';

		if($limit == '') {$limit = $rec_limit;}
		if($offset == '') {$offset = 0;}

		$search = $this->input->get('search');

		if($search == 'null' || $search == 'undefined'){$search = '';}

		$query = $this->Crud->filter_product($limit, $offset, $search);
		$count = count($this->Crud->filter_product('', '', $search));

		if(!empty($query)) {
			foreach($query as $q) {
				$id = $q->id;
				$p_resp = $q->response;
				$p_resp = json_decode($p_resp);
				$its = $p_resp->item;
				$it_title = $its->title;
				$it_img = $its->pic_url;
				$it_desc = $its->desc_short;
				$pdt_url = $its->detail_url;

				// get price
				$price = $its->price;
				$original_price = $its->orginal_price;
				if(strpos($pdt_url, 'aliexpress') !== false) {
					$price = explode('$', $price);
					$price = $price[1];
					$price = $this->Crud->to_number($price);
					$price = $this->Crud->convert($price, 'dollar');
					$original_price = explode('$', $original_price);
					$original_price = $original_price[1];
					$original_price = $this->Crud->to_number($original_price);
					$original_price = $this->Crud->convert($original_price, 'dollar');
				}

				if(strpos($pdt_url, '1688') !== false) {
					$price = $this->Crud->to_number($price);
					$price = $this->Crud->convert($price, 'yen');
					$original_price = $this->Crud->to_number($original_price);
					$original_price = $this->Crud->convert($original_price, 'yen');
				}

				$item .= '
					<div class="column is-6">
						<div class="flat-card is-long">
							<div class="left-image is-md">
								<img src="'.$it_img.'" alt="">
							</div>
							<div class="product-info">
								<a href="'.base_url('shop/product/'.$id).'"><h3 class="product-name featured-md">'.$it_title.'</h3></a>
								<p class="product-description single">'.$it_desc.'</p>
								<p class="product-price" style="font-size:large; font-weight:bold;">
									&#8358;'.number_format($price,2).'
								</p>
							</div>

							<div class="actions">
								<div class="add"><i data-feather="shopping-cart" class="has-simple-popover" data-content="Add to Cart" data-placement="top"></i></div>
								<!--<div class="like"><i data-feather="heart" class="has-simple-popover" data-content="Add to Wishlist" data-placement="top"></i></div>-->
							</div>
						</div>
					</div>
				';
			}
		}

		$resp['item'] = '<div class="columns is-product-grid is-multiline">'.$item.'</div>';

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
