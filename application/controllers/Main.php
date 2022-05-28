<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct() {
		parent::__construct();
    }
	
	public function index() {
		$recents = '';
		$recent_products = $this->Crud->read('product', 12);
		if(!empty($recent_products)) {
			foreach($recent_products as $q) {
				$id = $q->id;
				$name = $q->name;
				$name = ellipsize($name, 40, 1);

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

				$recents .= '
					<div class="column is-3">
						<div class="flat-card">
							<div class="image is-md">
								<img src="'.$image.'" alt="">
							</div>
							<div class="product-info has-text-centered">
								<a href="'.base_url('shop/product/'.$id).'"><h3 class="product-name" style="text-transform: none;">'.$name.'</h3></a>
								<p class="product-description">'.$rating.'</p>
								<p class="product-price">
									<span>&#8358;'.number_format($price,2).'</span>
									<span class="has-text-grey is-small" style="text-decoration:line-through; font-size:10px;">&#8358;'.number_format($original_price,2).'</span>
								</p>
							</div>
						</div>
					</div>
				';
			}
		}
		$data['recents'] = $recents;

		$data['title'] =  'Welcome to '.app_name;
		$data['page_active'] = 'main';

		$this->load->view('designs/header', $data);
		$this->load->view('main', $data);
		$this->load->view('designs/footer', $data);
	}

}
