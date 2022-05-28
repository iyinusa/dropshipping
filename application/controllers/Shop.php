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

	public function search($item='') {
		$search_items = '';

		// check for existing search
		$search = $this->session->userdata('afrs_current_search');
		if(!empty($search)) {
			foreach($search as $sh) {
				$pdt_id = $sh->id;
				$pdt_img = $sh->imageUrl;
				$pdt_title = $sh->title;
				$pdt_url = $sh->detailUrl;
				if(!empty($sh->ratings)) { $pdt_rating = $sh->ratings; } else { $pdt_rating = 0; }
				$pdt_rating = $this->Crud->rating($pdt_rating).' <small class="is-hidden-mobile">'.$pdt_rating.'/5 Ratings</small>';
				if(!empty($sh->orders)) { $pdt_orders = $sh->orders; } else { $pdt_orders = 0; }
				$pdt_price = $sh->priceOptions[0]->amount->value;
				$pdt_price = $this->Crud->amount('dollar', $pdt_price);
				$pdt_price = number_format($pdt_price, 2);

				$search_items .= '
					<li class="flat-card is-auto is-list-item">
						<span class="image">
							<img src="'.$pdt_img.'" alt="">
						</span>
						<span class="product-info">
							<!-- Rating -->
							<span class="rating">
								'.$pdt_rating.'
								<small>'.number_format($pdt_orders).' Orders</small>
							</span>
							<!-- Meta -->
							<a href="'.base_url('shop/product/'.$pdt_id).'"><span class="product-name">'.$pdt_title.'</span></a>
							<span class="product-description"> <br /> </span>
							<span class="product-price">
								&#8358;'.$pdt_price.'
							</span>
						</span>

						<span class="product-abstract is-hidden-mobile">
							<span class="view-more">
								<a href="'.base_url('shop/details/'.$pdt_id).'">View more <i data-feather="chevron-right"></i></a>
							</span>
						</span>
					</li>
				';
			}
		}

		$data['search_items'] = $search_items;

		$data['title'] =  'Search Product | '.app_name;
		$data['page_active'] = 'search';

		$this->load->view('designs/header', $data);
		$this->load->view('shop/search', $data);
		$this->load->view('designs/footer', $data);
	}

	public function details($id='') {
		if(!$id) { redirect(base_url('shop/search')); }

		// check if item is in database
		$pdt_id = $this->Crud->read_field('no', $id, 'product', 'id');
		if($pdt_id > 0) { redirect(base_url('shop/product/'.$pdt_id)); }

		// otherwise, get item details from API
		$search_data['productId'] = $id;
		$search_data['country'] = 'NG';
		$search_data['sendGoodsCountry'] = 'CN';
		$search_data['components'] = array("variations", "shipping", "html_description");
		$response = $this->Crud->ali_post('products', $search_data);
		$res = json_decode($response);
		if(empty($res)) {
			redirect(base_url('shop/search'));
		} else {
			$name = ''; $url = ''; $cat_no = ''; $detail = ''; $type = 'piece'; $seller = ''; $reviews = ''; $prices = ''; $images = ''; $attributes = ''; $shipping = '';
			
			if(!empty($res->title)) { $name = $res->title; }
			if(!empty($res->detailUrl)) { $url = $res->detailUrl; }
			if(!empty($res->categoryId)) { $cat_no = $res->categoryId; }
			if(!empty($res->htmlDescription)) { $detail = $res->htmlDescription; }
			if(!empty($res->unit)) { $type = $res->unit; }
			if(!empty($res->seller)) { $seller = json_encode($res->seller); }
			if(!empty($res->reviews)) { $reviews = json_encode($res->reviews); }
			if(!empty($res->prices)) { $prices = json_encode($res->prices); }
			if(!empty($res->productImages)) { $images = json_encode($res->productImages); }
			if(!empty($res->attributes)) { $attributes = json_encode($res->attributes); }
			if(!empty($res->shipping)) { $shipping = json_encode($res->shipping); }

			// register in native DB
			$cat_id = 0;
			$ins_data['cat_id'] = $cat_id;
			$ins_data['cat_no'] = $cat_no;
			$ins_data['no'] = $id;
			$ins_data['url'] = $url;
			$ins_data['name'] = $name;
			$ins_data['details'] = $detail;
			$ins_data['type'] = $type;
			$ins_data['seller'] = $seller;
			$ins_data['reviews'] = $reviews;
			$ins_data['prices'] = $prices;
			$ins_data['images'] = $images;
			$ins_data['attributes'] = $attributes;
			$ins_data['shipping'] = $shipping;
		
			if($this->Crud->check('no', $id, 'product') <= 0) {
				$ins_id = $this->Crud->create('product', $ins_data);

				if($ins_id > 0) {
					redirect(base_url('shop/product/'.$ins_id));
				} else {
					redirect(base_url('shop/search'));
				}
			}
		}


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

		// get images
		$images = $this->Crud->read_field('id', $id, 'product', 'images');
		$images = json_decode($images);
		$data['pdt_img'] = $images[0];
		$img = '<div><img data-action="zoom" alt="" src="'.$images[0].'" /></div>';
		if(!empty($images)) {
			foreach($images as $imgs=>$im) {
				if($imgs == 0) { continue; }
				$img .= '<div><img data-action="zoom" alt="" src="'.$im.'" /></div>';
			}
		}
		$data['pdt_imgs'] = $img;

		// get title
		$pdt_title = $this->Crud->read_field('id', $id, 'product', 'name');
		$data['pdt_title'] = $pdt_title;

		// get url
		$data['pdt_url'] = $this->Crud->read_field('id', $id, 'product', 'url');

		// get store seller
		$seller = $this->Crud->read_field('id', $id, 'product', 'seller');
		$seller = json_decode($seller);
		$data['pdt_nick'] = '<a href="'.$seller->storeUrl.'" target="_blank">'.$seller->storeName.'</a>';

		// get short desc
		$data['pdt_desc_short'] = '';

		// get short desc
		$data['pdt_desc'] = $this->Crud->read_field('id', $id, 'product', 'details');

		// get pricing
		$original_price = 0; $price = 0; $qty = 0;
		$prices = $this->Crud->read_field('id', $id, 'product', 'prices');
		$prices = json_decode($prices);
		$p_count = count($prices);
		if(!empty($prices)) {
			// check stock, and pick the available one
			$j = 0;
			for($i = 0; $i < $p_count; $i++) {
				if($prices[$i]->stock > 0) { 
					if($prices[$i]->stock > $prices[$j]->stock) { $j = $i; }
					if($j == 0) { $j = $i; }
				}
			}

			$original_price = $prices[$j]->originalPrice->value;
			$original_price = $this->Crud->amount('dollar', $original_price);

			$price = $prices[$j]->discountedPrice->value;
			$price = $this->Crud->amount('dollar', $price);

			$qty = $prices[$j]->stock;
		}
		$data['pdt_price'] = $price;
		$data['pdt_original_price'] = $original_price;
		$data['pdt_num'] = $qty;
		$data['pdt_type'] = $this->Crud->read_field('id', $id, 'product', 'type');

		// get specifications
		$pdt_specs = '';
		$specs = $this->Crud->read_field('id', $id, 'product', 'attributes');
		$specs = json_decode($specs);
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

		// get rating
		$rate_value = 0; $rate_total = 0; $rating = ''; $ratings = '';
		$reviews = $this->Crud->read_field('id', $id, 'product', 'reviews');
		$reviews = json_decode($reviews);
		if(!empty($reviews)) {
			$five = $reviews->fiveStarCount;
			$four = $reviews->fourStarCount;
			$three = $reviews->threeStarCount;
			$two = $reviews->twoStarCount;
			$one = $reviews->oneStarCount;

			$rate_total = $reviews->totalCount;
			$rate_value = $reviews->ratings;
			$rating = $this->Crud->rating($rate_value);

			if($rate_total > 0) {
				$five_per = number_format(($five / $rate_total) * 100);
				$four_per = number_format(($four / $rate_total) * 100);
				$three_per = number_format(($three / $rate_total) * 100);
				$two_per = number_format(($two / $rate_total) * 100);
				$one_per = number_format(($one / $rate_total) * 100);
			} else {
				$five_per = 0;
				$four_per = 0;
				$three_per = 0;
				$two_per = 0;
				$one_per = 0;
			}

			$ratings = '
				<table class="table is-striped is-fullwidth">
					<tbody>
						<tr>
							<td align="left">5 Stars</td>
							<td align="center"><progress class="progress is-danger is-small" value="'.$five_per.'" max="100"> </progress></td>
							<td align="left">'.$five_per.'%</td>
						</tr>
						<tr>
							<td align="left">4 Stars</td>
							<td align="center"><progress class="progress is-danger is-small" value="'.$four_per.'" max="100"> </progress></td>
							<td align="left">'.$four_per.'%</td>
						</tr>
						<tr>
							<td align="left">3 Stars</td>
							<td align="center"><progress class="progress is-danger is-small" value="'.$three_per.'" max="100"> </progress></td>
							<td align="left">'.$three_per.'%</td>
						</tr>
						<tr>
							<td align="left">2 Stars</td>
							<td align="center"><progress class="progress is-danger is-small" value="'.$two_per.'" max="100"> </progress></td>
							<td align="left">'.$two_per.'%</td>
						</tr>
						<tr>
							<td align="left">1 Star</td>
							<td align="center"><progress class="progress is-danger is-small" value="'.$one_per.'" max="100"> </progress></td>
							<td align="left">'.$one_per.'%</td>
						</tr>
					</tbody>
				</table>
			';
		}
		$data['rate_value'] = $rate_value;
		$data['rate_total'] = $rate_total;
		$data['rating'] = $rating;
		$data['ratings'] = $ratings;

		////// others
		// load recommended
		$recommended = '';
		$recomm = $this->Crud->read('product', 3, 'RANDOM');
		if(!empty($recomm)) {
			foreach($recomm as $re) {
				$r_title = $re->name;
				$r_title = ellipsize($r_title, 40, 1);
				if(!empty($re->images)) {
					$images = json_decode($re->images);
					$r_img = $images[0];
				} else { $r_img = base_url('assets/images/icon.png'); }
				
				if($re->id != $id) {
					$recommended .= '
						<div class="column is-3">
							<div class="featured-product">
								<div class="image">
									<img src="'.$r_img.'" alt="">
								</div>
								<div class="product-info has-text-centered">
									<a href="'.base_url('shop/product/'.$re->id).'"><h3 class="product-name" style="text-transform:none;">'.$r_title.'</h3></a>
									<p class="product-description single"> </p>
								</div>
							</div>
						</div>
					';
				}
			}
		}
		$data['pdt_recommended'] = $recommended;

		if($pdt_title) { $title = $pdt_title; } else { $title = 'Product'; }
		$data['title'] =  $title.' | '.app_name;
		$data['page_active'] = 'product';

		$this->load->view('designs/header', $data);
		$this->load->view('shop/product', $data);
		$this->load->view('designs/footer', $data);
	}

	public function find_product() {
		$status = false;
		$msg = '';

		if($_POST) {
			$text = $this->input->post('text');
			if(!$text) {
				$msg = $this->Crud->msg('danger', 'Copy and Paste or Type Product Name');
			} else {
				// remove existing product in session
				$this->session->set_userdata('afrs_current_search', '');
				$is_product = '';

				// first check database for product
				
				// now check API
				if(empty($is_product)) {
					$search_data['text'] = strtolower($text);
                	$search_data['shipToCountry'] = 'NG';
                	$search_data['shipFromCountry'] = 'CN';
					$response = $this->Crud->ali_post('search', $search_data);
				
					$response = json_decode($response);
					if(!empty($response)) {
						if(!empty($response->items)) {
							$is_product = $response->items;
						}
					}
				}

				// now check of product is found
				if(!empty($is_product)) {
					$msg = $this->Crud->msg('success', 'Product(s) Found! - Listing...');
					$status = true;
					$this->session->set_userdata('afrs_current_search', $is_product);
				} else {
					$msg = $this->Crud->msg('danger', 'Product Not Found!');
				}
			}
		}

		echo json_encode(array('status'=>$status, 'msg'=>$msg));
		die;
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
				$name = $q->name;
				$name = ellipsize($name, 60, 1);

				// get image
				$images = json_decode($q->images);
				$image = $images[0];

				// get price
				$original_price = 0; $price = 0;
				$prices = $q->prices;
				$prices = json_decode($prices);
				$p_count = count($prices);
				if(!empty($prices)) {
					// check stock, and pick the available one
					$j = 0;
					for($i = 0; $i < $p_count; $i++) {
						if($prices[$i]->stock > 0) { 
							if($prices[$i]->stock > $prices[$j]->stock) { $j = $i; }
							if($j == 0) { $j = $i; }
						}
					}

					$original_price = $prices[$j]->originalPrice->value;
					$original_price = $this->Crud->amount('dollar', $original_price);

					$price = $prices[$j]->discountedPrice->value;
					$price = $this->Crud->amount('dollar', $price);
				}

				// get rating
				$rate_value = 0;
				$reviews = json_decode($q->reviews);
				if(!empty($reviews)) {
					$rate_value = $reviews->ratings;
				}
				$rating = $this->Crud->rating($rate_value).' <small class="has-text-danger">'.number_format($rate_value,1).' / 5.0</small>';

				$item .= '
					<div class="column is-6">
						<div class="flat-card is-long" style="min-height:250px !important;">
							<div class="left-image is-md" style="padding-left:10px;">
								<img src="'.$image.'" alt="">
							</div>
							<div class="product-info">
								<a href="'.base_url('shop/product/'.$id).'"><h3 class="product-name featured-md" style="text-transform: none;">'.$name.'</h3></a>
								<p class="product-description">'.$rating.'</p>
								<div class="is-hidden-mobile"><br/><br/></div>
								<p class="product-price" style="padding-bottom: 10px;">
									<span>&#8358;'.number_format($price,2).'</span>
									<span class="has-text-grey is-small" style="text-decoration:line-through; font-size:10px;">&#8358;'.number_format($original_price,2).'</span>
								</p>
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
