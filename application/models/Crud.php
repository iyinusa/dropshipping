<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crud extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    ////////////////// CLEAR CACHE ///////////////////
	public function clear_cache() {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }
	
	//////////////////// C - CREATE ///////////////////////
	public function create($table, $data) {
		$this->db->insert($table, $data);
		return $this->db->insert_id();	
	}
	
	//////////////////// R - READ /////////////////////////
	public function read($table, $limit='', $offset='') {
		$query = $this->db->order_by('id', 'DESC');
		if($limit && $offset) {
			$query = $this->db->limit($limit, $offset);
		} else if($limit) {
			$query = $this->db->limit($limit);
		}
		$query = $this->db->get($table);
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}
	
	public function read_order($table, $field, $type, $limit='', $offset='') {
		$query = $this->db->order_by($field, $type);
		if($limit && $offset) {
			$query = $this->db->limit($limit, $offset);
		} else if($limit) {
			$query = $this->db->limit($limit);
		}
		$query = $this->db->get($table);
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}
	
	public function read_single($field, $value, $table, $limit='', $offset='') {
		$query = $this->db->order_by('id', 'DESC');
		$query = $this->db->where($field, $value);
		if($limit && $offset) {
			$query = $this->db->limit($limit, $offset);
		} else if($limit) {
			$query = $this->db->limit($limit);
		}
		$query = $this->db->get($table);
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}
	
	public function read_single_order($field, $value, $table, $or_field, $or_value, $limit='', $offset='') {
		$query = $this->db->order_by($or_field, $or_value);
		$query = $this->db->where($field, $value);
		if($limit && $offset) {
			$query = $this->db->limit($limit, $offset);
		} else if($limit) {
			$query = $this->db->limit($limit);
		}
		$query = $this->db->get($table);
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}
	
	public function read_like($field, $value, $table, $limit='', $offset='') {
		$query = $this->db->like($field, $value);
		if($limit && $offset) {
			$query = $this->db->limit($limit, $offset);
		} else if($limit) {
			$query = $this->db->limit($limit);
		}
		$query = $this->db->get($table);
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}
	
	public function read_like2($field, $value, $field2, $value2, $table, $limit='', $offset='') {
		$query = $this->db->like($field, $value);
		$query = $this->db->or_like($field2, $value2);
		if($limit && $offset) {
			$query = $this->db->limit($limit, $offset);
		} else if($limit) {
			$query = $this->db->limit($limit);
		}
		$query = $this->db->get($table);
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}
	
	public function read_like3($field, $value, $field2, $value2, $field3, $value3, $table, $limit='', $offset='') {
		$query = $this->db->like($field, $value);
		$query = $this->db->or_like($field2, $value2);
		$query = $this->db->or_like($field3, $value3);
		if($limit && $offset) {
			$query = $this->db->limit($limit, $offset);
		} else if($limit) {
			$query = $this->db->limit($limit);
		}
		$query = $this->db->get($table);
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}
	
	public function read_field($field, $value, $table, $call) {
		$return_call = '';
		$getresult = $this->read_single($field, $value, $table);
		if(!empty($getresult)) {
			foreach($getresult as $result)  {
				$return_call = $result->$call;
			}
		}
		return $return_call;
	}

	public function read_field2($field, $value, $field2, $value2, $table, $call) {
		$return_call = '';
		$getresult = $this->read2($field, $value, $field2, $value2, $table);
		if(!empty($getresult)) {
			foreach($getresult as $result)  {
				$return_call = $result->$call;
			}
		}
		return $return_call;
	}
	
	public function read2($field, $value, $field2, $value2, $table, $limit='', $offset='') {
		$query = $this->db->order_by('id', 'DESC');
		$query = $this->db->where($field, $value);
		$query = $this->db->where($field2, $value2);
		if($limit && $offset) {
			$query = $this->db->limit($limit, $offset);
		} else if($limit) {
			$query = $this->db->limit($limit);
		}
		$query = $this->db->get($table);
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}
	
	public function read3($field, $value, $field2, $value2, $field3, $value3, $table, $limit='', $offset='') {
		$query = $this->db->order_by('id', 'DESC');
		$query = $this->db->where($field, $value);
		$query = $this->db->where($field2, $value2);
		$query = $this->db->where($field3, $value3);
		if($limit && $offset) {
			$query = $this->db->limit($limit, $offset);
		} else if($limit) {
			$query = $this->db->limit($limit);
		}
		$query = $this->db->get($table);
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}
	
	public function check($field, $value, $table){
		$query = $this->db->where($field, $value);
		$query = $this->db->get($table);
		return $query->num_rows();
	}
	
	public function check2($field, $value, $field2, $value2, $table){
		$query = $this->db->where($field, $value);
		$query = $this->db->where($field2, $value2);
		$query = $this->db->get($table);
		return $query->num_rows();
	}
	
	public function check3($field, $value, $field2, $value2, $field3, $value3, $table){
		$query = $this->db->where($field, $value);
		$query = $this->db->where($field2, $value2);
		$query = $this->db->where($field3, $value3);
		$query = $this->db->get($table);
		return $query->num_rows();
	}
	
	//////////////////// U - UPDATE ///////////////////////
	public function update($field, $value, $table, $data) {
		$this->db->where($field, $value);
		$this->db->update($table, $data);
		return $this->db->affected_rows();	
	}
	
	//////////////////// D - DELETE ///////////////////////
	public function delete($field, $value, $table) {
		$this->db->where($field, $value);
		$this->db->delete($table);
		return $this->db->affected_rows();	
	}
	//////////////////// END DATABASE CRUD ///////////////////////
	
	//////////////////// DATATABLE AJAX CRUD ///////////////////////
	public function datatable_query($table, $column_order, $column_search, $order, $where='') {
		// where clause
		if(!empty($where)) {
			$this->db->where(key($where), $where[key($where)]);
		}
		
		$this->db->from($table);
 
		// here combine like queries for search processing
		$i = 0;
		if($_POST['search']['value']) {
			foreach($column_search as $item) {
				if($i == 0) {
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}
				
				$i++;
			}
		}
		 
		// here order processing
		if(isset($_POST['order'])) { // order by click column
			$this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else { // order by default defined
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
 
	public function datatable_load($table, $column_order, $column_search, $order, $where='') {
		$this->datatable_query($table, $column_order, $column_search, $order, $where);
		
		if($_POST['length'] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		
		$query = $this->db->get();
		return $query->result();
	}
 
	public function datatable_filtered($table, $column_order, $column_search, $order, $where='') {
		$this->datatable_query($table, $column_order, $column_search, $order, $where);
		$query = $this->db->get();
		return $query->num_rows();
	}
 
	public function datatable_count($table, $where='') {
		$this->db->select("*");
		
		// where clause
		if(!empty($where)) {
			$this->db->where(key($where), $where[key($where)]);
		}
		
		$this->db->from($table);
		return $this->db->count_all_results();
	} 
	//////////////////// END DATATABLE AJAX CRUD ///////////////////
	
	//////////////////// NOTIFICATION CRUD ///////////////////////
	public function msg($type = '', $text = ''){
		if($type == 'success'){
			$icon = 'fa fa-check-circle';
			$icon_text = 'Successful!';
		} else if($type == 'info'){
			$icon = 'fa fa-info-circle';
			$icon_text = 'Head up!';
		} else if($type == 'warning'){
			$icon = 'fa fa-warning';
			$icon_text = 'Please check!';
		} else if($type == 'danger'){
			$icon = 'fa fa-times-circle';
			$icon_text = 'Oops!';
		}
		
		return '
			<div class="notification is-'.$type.'">
				<b><i class="'.$icon.'"></i> '.$icon_text.'</b> - '.$text.'
			</div>
		';	
	}
	//////////////////// END NOTIFICATION CRUD ///////////////////////
	
	//////////////////// EMAIL CRUD ///////////////////////
	public function send_email($to, $from, $subject, $body_msg, $name, $subhead) {
		//clear initial email variables
		$this->email->clear(); 
		$email_status = '';
		
		$this->email->to($to);
		$this->email->from($from, $name);
		$this->email->subject($subject);
						
		$mail_data = array('message'=>$body_msg, 'subhead'=>$subhead);
		$this->email->set_mailtype("html"); //use HTML format
		$mail_design = $this->load->view('designs/email_template', $mail_data, TRUE);
				
		$this->email->message($mail_design);
		if(!$this->email->send()) {
			$email_status = FALSE;
		} else {
			$email_status = TRUE;
		}
		
		return $email_status;
	}
	//////////////////// END EMAIL CRUD ///////////////////////
	
	//////////////////// APP NOTIFY CRUD ///////////////////////
	public function notify($user_id, $user, $email, $phone, $item_id, $item, $title, $details, $type, $hash) {
		// register notification
		$not_data = array(
			'user_id' => $user_id,
			'nhash' => $hash,
			'item_id' => $item_id,
			'item' => $item,
			'new' => 1,
			'title' => $title,
			'details' => $details,
			'type' => $type,
			'reg_date' => date(fdate)
		);
		$not_ins = $this->create('ka_notify', $not_data);
		if($not_ins){
			// send email
			if($type == 'email'){
				$email_result = '';
				$from = app_email;
				$subject = $title;
				$name = app_name;
				$sub_head = $title.' Notification';
				
				$body = '
					<div class="mname">Hi '.ucwords($user).',</div><br />You have new '.$title.' notification,<br /><br />
					'.$details.'<br /><br />
					Warm Regards.
				';
				
				$email_result = $this->send_email($email, $from, $subject, $body, $name, $sub_head);
			} else {
				// send sms	
			}
		}
	}
	//////////////////// END APP NOTIFY CRUD /////////////////////

	//////////////////// RavePAY CRUD ///////////////////////
	public function rave_key($server, $type) {
		$key = '';
		if($server == 'test') {
			if($type == 'public') {
				$key = 'FLWPUBK_TEST-d28ee7274d4a3a7bff3ad0a9a74089e2-X';
			} else if($type == 'secret') {
				$key = 'FLWSECK_TEST-055034f67c5a29532b2d9424631442a4-X';
			}
		} else if($server == 'live') {
			if($type == 'public') {
				$key = 'FLWPUBK-1b54e5c71e5bfe07f23478a497a08b39-X';
			} else if($type == 'secret') {
				$key = 'FLWSECK-fc07cf50deca173f3b327824c2fcd4e1-X';
			}
		}
		
		return $key;
	}
	
	public function rave_verify($data, $server='') {
		// create a new cURL resource
		$curl = curl_init();

		// parameters
		$api_link = 'https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify';
		if($server == 'test') {
			$api_link = 'http://flw-pms-dev.eu-west-1.elasticbeanstalk.com/flwv3-pug/getpaidx/api/verify';
		}
		$curl_data = json_encode($data);
		
		$chead = array();
		$chead[] = 'Content-Type: application/json';

		// set URL and other appropriate options
		curl_setopt($curl, CURLOPT_URL, $api_link);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $chead);
		curl_setopt($curl, CURLOPT_POST, 1);
    	curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

		// grab URL and pass it to the browser
		$result = curl_exec($curl);

		// close cURL resource, and free up system resources
		curl_close($curl);

		return $result;
	
	}

	public function rave_script($stage = 'live', $firstname, $lastname, $phone, $email, $price, $name, $desc, $method, $meta = '', $subaccounts = '', $passURL = '', $failURL = '') {
		$pubkey = $this->rave_key($stage, 'public');
		$secret = $this->rave_key($stage, 'secret');
		$trxref = (float)rand()/(float)getrandmax();;
		$pay_title = $name;
		$pay_desc = ucwords($desc);
		$pay_logo = base_url('assets/images/icon.png');
		$pay_country = 'NG';
		$pay_currency = 'NGN';
		
		// compute hash, must follow ravepay ASCII order
		$pay_hash = $pubkey.$price.$pay_country.$pay_currency.$pay_desc.$pay_logo.$pay_title.$email.$firstname.$lastname.$phone.$method.$trxref;
		$pay_hash .= $secret;
		$pay_hash = hash('sha256', $pay_hash);
		
		$script = "
			<script src='https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js'></script>
			<script>
				function payWithRave() {
					var x = getpaidSetup({ 
						PBFPubKey: '".$pubkey."',
						customer_email: '".$email."',
						customer_firstname: '".$firstname."',
						customer_lastname: '".$lastname."',
						customer_phone: '".$phone."',
						custom_logo: '".$pay_logo."',
						custom_title: '".$pay_title."',
						custom_description: '".$pay_desc."',
						amount: '".$price."',
						country: '".$pay_country."',
						currency: '".$pay_currency."',
						payment_method: '".$method."',
						txref: '".$trxref."',
						integrity_hash: '".$pay_hash."',
						subaccounts: [".$subaccounts."],
						meta: [".$meta."],
						onclose: function() {},
						callback: function(response) {
							flw_ref = response.tx.flwRef, chargeResponse = response.tx.chargeResponseCode, flw_msg = response.tx.chargeResponseMessage;

							if (chargeResponse == '00' || chargeResponse == '0') {
								window.location = '".$passURL."&flw_ref='+flw_ref+'&flw_msg='+flw_msg;
							} else {
								window.location = '".$failURL."&flw_ref='+flw_ref+'&flw_msg='+flw_msg;
							}

							x.close();
						}
					});
				}
			</script>
		";	
		
		return $script;
	}

	public function rave_save($type = '', $redirectURL = '', $trnx_msg = '', $resp = '') {
		$user_id = $this->session->userdata('afrs_id');
		$pay_status = false;
		$pay_id = 0;
		$item_id = 0;
		$pay_msg = '';

		if($type && $redirectURL && $resp) {
			$ver = json_decode($resp);
			$res_data = $ver->data;

			if(!empty($res_data->flwMeta->chargeResponse)){
				if($res_data->flwMeta->chargeResponse != '00' || $res_data->flwMeta->chargeResponse != '0') {
					$pay_msg = 'Unable to Complete Transaction';
				} else {
					$trnx_id = $res_data->id;
					$trnx_ref = $res_data->flw_ref;
					$trnx_status = $res_data->status;
					$trnx_code = $res_data->rave_ref;
					$trnx_naration = $res_data->narration;
					$trnx_amount = $res_data->amount;
					$trnx_fee = $res_data->appfee;

					// redirect url
					$redirectURL .= '&flw_ref='.$trnx_ref.'&flw_msg='.$trnx_msg;

					// card
					$card_brand = $res_data->card->brand;
					$exp_month = $res_data->card->expirymonth;
					$exp_year = $res_data->card->expiryyear;
					$card_lastdigit = $res_data->card->last4digits;

					// meta
					$meta_value = 0; $user_id = 0;
					$trnx_meta = $res_data->meta;
					if(!empty($trnx_meta)) {
						foreach($trnx_meta as $tm) {
							if($tm->metaname == 'userid') {
								$meta_value = $tm->metavalue;

								//$user_id = $this->read_field('id', $meta_value, $type, 'user_id');
								$user_id = $meta_value;
								$item_id = $meta_value;
							}
						}
					}

					if($meta_value) {
						// check if payment not exist
						if($this->check('trnx_ref', $trnx_ref, 'transaction') > 0) {
							$pay_msg = 'Transaction Already Completed';
						} else {
							$trnx_data['user_id'] = $user_id;
							$trnx_data['item_id'] = $meta_value;
							$trnx_data['item_type'] = $type;
							$trnx_data['pay_code'] = 'AF-'.time();
							$trnx_data['type'] = $type;
							$trnx_data['recipient'] = 'AfrimStore';
							$trnx_data['card_name'] = '';
							$trnx_data['card_brand'] = $card_brand;
							$trnx_data['card_no'] = '';
							$trnx_data['card_cvv'] = '';
							$trnx_data['exp_month'] = $exp_month;
							$trnx_data['exp_year'] = $exp_year;
							$trnx_data['card_lastdigit'] = $card_lastdigit;
							$trnx_data['amount'] = $trnx_amount;
							$trnx_data['fee'] = $trnx_fee;
							$trnx_data['medium'] = '';
							$trnx_data['trnx_id'] = $trnx_id;
							$trnx_data['trnx_code'] = $trnx_code;
							$trnx_data['trnx_ref'] = $trnx_ref;
							$trnx_data['trnx_status'] = $trnx_status;
							$trnx_data['trnx_msg'] = $trnx_msg;
							$trnx_data['re_query'] = $redirectURL;
							$trnx_data['reg_date'] = date(fdate);

							$pay_id = $this->create('transaction', $trnx_data);
							if($pay_id > 0) {
								$pay_status = true;
								$pay_msg = 'Transaction Completed';
							} else {
								$pay_msg = 'Transaction Not Recorded';
							}
						}
					}
				}
			}
		}

		return (object) array('status'=>$pay_status, 'id'=>$pay_id, 'item_id'=>$item_id, 'msg'=>$pay_msg);
	}
	//////////////////// END RavePAY API CRUD ///////////////////////

	//////////////////// AliExpress CRUD ////////////////////////////
	public function ali_key() {
		// return 'DyVdsNwOOJ3rvS0bdEMiIaXk7UsG9DzA8fwKlZh6';
		return 'lICPe00Ne75pav8Jq4ap52uroMCWyDIu4kGQotrr';
	}

	public function ali_post($endpint, $data) {
		// create a new cURL resource
		$curl = curl_init();

		// parameters
		$api_link = 'https://api.zapiex.com/v1/'.$endpint;
		
		$curl_data = json_encode($data);
		
		$chead = array();
		$chead[] = 'Content-Type: application/json';
		$chead[] = 'x-api-key: '.$this->ali_key();

		// set URL and other appropriate options
		curl_setopt($curl, CURLOPT_URL, $api_link);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $chead);
		curl_setopt($curl, CURLOPT_POST, 1);
    	curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

		// if(curl_exec($curl) === false) {
		// 	$result = curl_error($curl);
		// } else {
		// 	$result = curl_exec($curl);
		// }

		// grab URL and pass it to the browser
		$result = curl_exec($curl);

		// close cURL resource, and free up system resources
		curl_close($curl);

		return $result;
	
	}
	//////////////////// END AliExpress ////////////////////////////

	//////////////////// IMAGE CRUD ///////////////////////
	public function img_upload($log_id, $name, $path, $file='') {
		$img_id = 0;
		if(empty($name)) {$stamp = time().rand();} else {$stamp = $name;}
		$save_path = '';
		$save_path303 = '';
		$save_path150 = '';
		$msg = '';
		
		if (!is_dir($path))
			mkdir($path, 0755);

		$pathMain = './'.$path;
		if (!is_dir($pathMain))
			mkdir($pathMain, 0755);

		if($file == ''){$file = 'pics';}
		$result = $this->do_upload($file, $pathMain);

		if (!$result['status']){
			$msg = 'Upload Failed';
		} else {
			$save_path = $path . '/' . $result['upload_data']['file_name'];

			// check size
			if($result['image_width'] > 2000) {
				$msg = 'Size must not be more than 2MB';
			} else {
				//if size not up to 400px above
				if($result['image_width'] >= 192){
					if($result['image_width'] >= 400 || $result['image_height'] >= 400) {
						if($this->resize_image($pathMain . '/' . $result['upload_data']['file_name'], $stamp .'-303.gif','400','400', $result['image_width'], $result['image_height'])){
							$resize400 = $pathMain . '/' . $stamp.'-303.gif';
							$resize400_dest = $resize400;
							
							if($this->crop_image($resize400, $resize400_dest,'303','220')){
								$save_path303 = $path . '/' . $stamp .'-303.gif';
							}
						}
					}
						
					if($result['image_width'] >= 200 || $result['image_height'] >= 200){
						if($this->resize_image($pathMain . '/' . $result['upload_data']['file_name'], $stamp .'-150.gif','200','200', $result['image_width'], $result['image_height'])){
							$resize100 = $pathMain . '/' . $stamp.'-150.gif';
							$resize100_dest = $resize100;	
							
							if($this->crop_image($resize100, $resize100_dest,'150','150')){
								$save_path150 = $path . '/' . $stamp .'-150.gif';
							}
						}
					}
					
					//save picture in system
					$pics_data = array(
						'user_id' => $log_id,
						'type' => 'image',
						'path' => $save_path,
						'pics_small' => $save_path303,
						'pics_square' => $save_path150,
						'reg_date' => date(fdate)
					);
					$pics_ins = $this->create('file', $pics_data);
					// update in user table
					if($pics_ins) {
						$img_id = $pics_ins;
						$save_path = $save_path;
					}
				} else {
					$msg = 'Dimension must not be less than 2 X 2 inches (or 192px X 192px).';
				}
			}
		}

		return (object)array('id'=>$img_id, 'msg'=>$msg, 'path'=>$save_path);
	}

	public function doc_upload($log_id, $name, $path, $file='', $formats='') {
		if($name == '') {$stamp = time().rand();} else {$stamp = $name;}
		$save_path = '';
		$msg = '';

		$file_id = 0;
		$file_size = 0;
		$file_ext = '';
		
		if (!is_dir($path))
			mkdir($path, 0755);

		$pathMain = './'.$path;
		if (!is_dir($pathMain))
			mkdir($pathMain, 0755);

		if($file == ''){$file = 'file';}
		if($formats == '') {
			$allow_ext = 'doc|docx|ppt|pptx|xls|xlsx|jpg|jpeg|pdf|png|rar|txt|zip';
		} else {
			$allow_ext = $formats;
		}
		$result = $this->do_upload($file, $pathMain, $stamp, $allow_ext);

		if (!$result['status']){
			$msg = 'Upload Failed';
		} else {
			$save_path = $path . '/' . $result['upload_data']['file_name'];
			$file_size = $result['size'];
			$file_ext = $result['ext'];

			$file_data = array(
				'user_id' => $log_id,
				'type' => 'file',
				'path' => $save_path,
				'ext' => $file_ext,
				'reg_date' => date(fdate)
			);
			$file_ins = $this->create('file', $file_data);
			// update in user table
			if($file_ins) {
				$file_id = $file_ins;
			}
		}

		return (object)array('id'=>$file_id, 'msg'=>$msg, 'path'=>$save_path, 'size'=>$file_size, 'ext'=>$file_ext);
	}
	
	public function do_upload($htmlFieldName, $path, $name='', $ext='gif|jpg|jpeg|png|tif|bmp') {
		if($name == ''){$name = time();}
		$config['file_name'] = $name;
        $config['upload_path'] = $path;
        $config['allowed_types'] = $ext;
        $config['max_size'] = '10000';
        $config['max_width'] = '6000';
        $config['max_height'] = '6000';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        unset($config);
        
		if (!$this->upload->do_upload($htmlFieldName)){
            return array('error' => $this->upload->display_errors(), 'status' => 0);
        } else {
            $up_data = $this->upload->data();
			return array('status' => 1, 'upload_data' => $this->upload->data(), 'image_width' => $up_data['image_width'], 'image_height' => $up_data['image_height'], 'size' => $up_data['file_size'], 'ext' => $up_data['file_ext']);
        }
    }
	
	public function resize_image($sourcePath, $desPath, $width = '500', $height = '500', $real_width, $real_height) {
        $this->image_lib->clear();
		$config['image_library'] = 'gd2';
        $config['source_image'] = $sourcePath;
        $config['new_image'] = $desPath;
        $config['quality'] = '100%';
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['thumb_marker'] = '';
		$config['width'] = $width;
        $config['height'] = $height;
		
		$dim = (intval($real_width) / intval($real_height)) - ($config['width'] / $config['height']);
		$config['master_dim'] = ($dim > 0)? "height" : "width";
		
		$this->image_lib->initialize($config);
 
        if ($this->image_lib->resize())
            return true;
        return false;
    }
	
	public function crop_image($sourcePath, $desPath, $width = '320', $height = '320') {
        $this->image_lib->clear();
        $config['image_library'] = 'gd2';
        $config['source_image'] = $sourcePath;
        $config['new_image'] = $desPath;
        $config['quality'] = '100%';
        $config['maintain_ratio'] = FALSE;
        $config['width'] = $width;
        $config['height'] = $height;
		$config['x_axis'] = '20';
		$config['y_axis'] = '20';
        
		$this->image_lib->initialize($config);
 
        if ($this->image_lib->crop())
            return true;
        return false;
    }
	//////////////////// END IMAGE LIBRARY ///////////////////////
	
	//////////////////// DATETIME ///////////////////////
	public function date_diff($now, $end, $type='days') {
		$now = new DateTime($now);
		$end = new DateTime($end);
		$date_left = $end->getTimestamp() - $now->getTimestamp();
		
		if($type == 'seconds') {
			if($date_left <= 0){$date_left = 0;}
		} else if($type == 'minutes') {
			$date_left = $date_left / 60;
			if($date_left <= 0){$date_left = 0;}
		} else if($type == 'hours') {
			$date_left = $date_left / (60*60);
			if($date_left <= 0){$date_left = 0;}
		} else if($type == 'days') {
			$date_left = $date_left / (60*60*24);
			if($date_left <= 0){$date_left = 0;}
		} else {
			$date_left = $date_left / (60*60*24*365);
			if($date_left <= 0){$date_left = 0;}
		}	
		
		return $date_left;
	}
	//////////////////// END DATETIME ///////////////////////

	//////////////////// SETTING VALUE ///////////////////////
	public function setting($field, $value, $type) {
		$value = $this->read_field2($field, $value, 'type', $type, 'setting', 'value');
		return $value;
	}
	////////////////////END ///////////////////////

	//////////////////// SETTING VALUE ///////////////////////
	public function amount($name, $value) {
		$amount = $this->read_field('name', $name, 'currency', 'amount');
		return ($value * $amount);
	}
	////////////////////END ///////////////////////

	//////////////////// IMAGE DATA //////////////////
	public function image($id, $size='small') {
		if($id) {
			if($size == 'small') {
				$path = $this->read_field('id', $id, 'file', 'pics_small');
			} else if($size == 'big') {
				$path = $this->read_field('id', $id, 'file', 'path');
			} else {
				$path = $this->read_field('id', $id, 'file', 'pics_square');
			}
		} 

		if(empty($path)) {
			$path = 'assets/images/avatar.png';
		}

		return $path;
	}

	public function agent($id, $size='small') {
		if($id) {
			if($size == 'small') {
				$path = $this->read_field('id', $id, 'file', 'pics_small');
			} else if($size == 'big') {
				$path = $this->read_field('id', $id, 'file', 'path');
			} else {
				$path = $this->read_field('id', $id, 'file', 'pics_square');
			}
		} 

		if(empty($path)) {
			$path = 'assets/images/icon.png';
		}

		return $path;
	}
	//////////////////// END //////////////////

	public function doc_icon($ext, $size='small') {
		$icon = '';

		if($ext == '.doc' || $ext == '.docx') {
			if($size == 'small'){$icon = 'doc-32.png';} else {$icon = 'doc-128.png';}
		}

		if($ext == '.ppt' || $ext == '.pptx') {
			if($size == 'small'){$icon = 'ppt-32.png';} else {$icon = 'ppt-128.png';}
		}

		if($ext == '.xls' || $ext == '.xlsx') {
			if($size == 'small'){$icon = 'xls-32.png';} else {$icon = 'xls-128.png';}
		}

		if($ext == '.jpg' || $ext == '.jpeg') {
			if($size == 'small'){$icon = 'jpg-32.png';} else {$icon = 'jpg-128.png';}
		}

		if($ext == '.pdf') {
			if($size == 'small'){$icon = 'pdf-32.png';} else {$icon = 'pdf-128.png';}
		}

		if($ext == '.png') {
			if($size == 'small'){$icon = 'png-32.png';} else {$icon = 'png-128.png';}
		}

		if($ext == '.rar') {
			if($size == 'small'){$icon = 'rar-32.png';} else {$icon = 'rar-128.png';}
		}

		if($ext == '.zip') {
			if($size == 'small'){$icon = 'zip-32.png';} else {$icon = 'zip-128.png';}
		}

		if($icon == '') {
			if($size == 'small'){$icon = 'txt-32.png';} else {$icon = 'txt-128.png';}
		}

		return $icon;
	}

	public function to_number($text) {
		$number = preg_replace('/\s+/', '', $text); // remove all in between white spaces
		$number = str_replace(',', '', $number); // remove money format
		$number = floatval($number);
		return $number;
	}

	public function convert($amount, $type) {
		if($type == 'yen') {
			$amount *= 3.34;
		}

		if($type == 'dollar') {
			$amount *= 362.5;
		}

		return $amount;
	}

	public function order_no() {
		$no = rand();
		$resp = $this->check_order_no($no);
		if($resp <= 0) { return $no; }
	}

	public function check_order_no($no) {
		$id = $this->check('no', $no, 'order');
		if($id > 0) { 
			$this->order_no(); 
		} else {
			return $id;
		}
	}

	public function rating($value) {
		$stars = '';

		if($value >= 5) {
			$stars = '
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
			';
		} else if($value >= 4 && $value < 5) {
			$stars = '
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
			';
			if($value >= 4.5) { $stars .= '<i class="fa fa-star-half"></i>'; }
		} else if($value >= 3 && $value < 4) {
			$stars = '
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
			';
			if($value >= 3.5) { $stars .= '<i class="fa fa-star-half"></i>'; }
		} else if($value >= 2 && $value < 3) {
			$stars = '
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
			';
			if($value >= 2.5) { $stars .= '<i class="fa fa-star-half"></i>'; }
		} else if($value >= 1 && $value < 2) {
			$stars = '
				<i class="fa fa-star"></i>
			';
			if($value >= 1.5) { $stars .= '<i class="fa fa-star-half"></i>'; }
		} else if($value >= 0 && $value < 1) {
			$stars = '
				<i class="fa fa-star-half"></i>
			';
		}

		return $stars;
	}

	public function filter_order($limit='', $offset='', $search='', $status='') {
		$log_id = $this->session->userdata('afrs_id');
		$log_role = $this->read_field('id', $log_id, 'user', 'role');

		// build query
		$query = $this->db->order_by('id', 'DESC');
		if($log_role != 'administrator') { $query = $this->db->where('user_id', $log_id); }
		if(!empty($status)) {$query = $this->db->where('status', $status);}
		if(!empty($search)) {$query = $this->db->like('no', $search);}
		
		if(!empty($limit) && !empty($offset)) {
			$query = $this->db->limit($limit, $offset);
		} else if(!empty($limit)) {
			$query = $this->db->limit($limit);
		}
		$query = $this->db->get('order');
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}

	public function filter_product($limit='', $offset='', $search='') {
		// build query
		$query = $this->db->order_by('id', 'DESC');
		if(!empty($search)) {$query = $this->db->like('response', $search);}
		
		if(!empty($limit) && !empty($offset)) {
			$query = $this->db->limit($limit, $offset);
		} else if(!empty($limit)) {
			$query = $this->db->limit($limit);
		}
		$query = $this->db->get('product');
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}

	public function filter_wallet($limit='', $offset='', $search='', $status='') {
		$log_id = $this->session->userdata('afrs_id');
		$log_role = $this->read_field('id', $log_id, 'user', 'role');

		// build query
		$query = $this->db->order_by('id', 'DESC');
		$query = $this->db->where('user_id', $log_id);
		if(!empty($status)) {$query = $this->db->where('type', $status);}
		if(!empty($search)) {$query = $this->db->like('purpose', $search); $query = $this->db->or_like('amount', $search);}
		
		if(!empty($limit) && !empty($offset)) {
			$query = $this->db->limit($limit, $offset);
		} else if(!empty($limit)) {
			$query = $this->db->limit($limit);
		}
		$query = $this->db->get('wallet');
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}

	public function filter_transaction($limit='', $offset='', $search='') {
		$log_id = $this->session->userdata('afrs_id');
		$log_role = $this->read_field('id', $log_id, 'user', 'role');

		// build query
		$query = $this->db->order_by('id', 'DESC');
		if($log_role != 'administrator') { $query = $this->db->where('user_id', $log_id); }
		if(!empty($search)) {
			$query = $this->db->like('pay_code', $search); 
			$query = $this->db->or_like('item_type', $search);
			$query = $this->db->or_like('amount', $search);
			$query = $this->db->or_like('trnx_msg', $search);
		}
		
		if(!empty($limit) && !empty($offset)) {
			$query = $this->db->limit($limit, $offset);
		} else if(!empty($limit)) {
			$query = $this->db->limit($limit);
		}
		$query = $this->db->get('transaction');
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}

	public function filter_customer($limit='', $offset='', $search='') {
		// build query
		$query = $this->db->order_by('id', 'DESC');
		$query = $this->db->where('email!=', 'iyinusa@yahoo.co.uk');
		$query = $this->db->where('is_agent', 0);
		if(!empty($search)) {
			$query = $this->db->like('email', $search); 
			$query = $this->db->or_like('firstname', $search);
			$query = $this->db->or_like('lastname', $search);
			$query = $this->db->or_like('role', $search);
		}
		
		if(!empty($limit) && !empty($offset)) {
			$query = $this->db->limit($limit, $offset);
		} else if(!empty($limit)) {
			$query = $this->db->limit($limit);
		}
		$query = $this->db->get('user');
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}

	public function filter_agent($limit='', $offset='', $search='') {
		// build query
		$query = $this->db->order_by('id', 'DESC');
		$query = $this->db->where('email!=', 'iyinusa@yahoo.co.uk');
		$query = $this->db->where('is_agent', 1);
		if(!empty($search)) {
			$query = $this->db->like('email', $search); 
			$query = $this->db->or_like('firstname', $search);
			$query = $this->db->or_like('lastname', $search);
			$query = $this->db->or_like('role', $search);
		}
		
		if(!empty($limit) && !empty($offset)) {
			$query = $this->db->limit($limit, $offset);
		} else if(!empty($limit)) {
			$query = $this->db->limit($limit);
		}
		$query = $this->db->get('user');
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}

	public function filter_shipping($limit='', $offset='', $search='') {
		// build query
		$query = $this->db->order_by('type', 'ASC');
		if(!empty($search)) {
			$query = $this->db->like('type', $search); 
			$query = $this->db->or_like('min', $search);
			$query = $this->db->or_like('max', $search);
			$query = $this->db->or_like('price', $search);
			$query = $this->db->or_like('duration', $search);
		}
		
		if(!empty($limit) && !empty($offset)) {
			$query = $this->db->limit($limit, $offset);
		} else if(!empty($limit)) {
			$query = $this->db->limit($limit);
		}
		$query = $this->db->get('ship_price');
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}

	public function filter_ship_price($limit='', $offset='', $search='') {
		// build query
		$query = $this->db->order_by('state_id', 'ASC');
		$query = $this->db->where('agent_id', $this->session->userdata('afrs_id'));
		if(!empty($search)) {
			$query = $this->db->like('state_id', $search); 
			$query = $this->db->or_like('amount', $search);
		}
		
		if(!empty($limit) && !empty($offset)) {
			$query = $this->db->limit($limit, $offset);
		} else if(!empty($limit)) {
			$query = $this->db->limit($limit);
		}
		$query = $this->db->get('shipping');
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}

	public function sample() {
		$response = '
			{"id":"4000497151584","categoryId":"5090301","companyId":"112797012","sellerId":"121439130","detailUrl":"https://www.aliexpress.com/item/4000497151584.html","title":"Nokia 6.1 Global Version 4G Android SmartPhone 3GB 32GB Snapdragon 630 Octa core 5.5\" 16MP 8MP Mobile Phone","statusId":0,"status":"active","countPerLot":1,"wishListCount":243,"unit":"piece","multiUnit":"pieces","seller":{"storeId":316073,"storeUrl":"https://m.aliexpress.com/store/storeHome.htm?sellerAdminSeq=121439130","storeName":"ebestbuy Store","sellerLevel":"32-s","positiveFeedbackRate":"97.0"},"reviews":{"fiveStarCount":1,"fourStarCount":0,"threeStarCount":0,"twoStarCount":0,"oneStarCount":1,"totalCount":2,"positiveCount":1,"negativeCount":1,"neutralCount":0,"ratings":"5.0"},"trade":{"sold":29},"promotion":{"discount":"25","timeLeft":{"days":41,"hours":19,"minutes":4,"seconds":6}},"productImages":["https://ae01.alicdn.com/kf/H60079e3ef2904761bb9a4cff19f8fa4bG.jpg_960x960.jpg_.webp","https://ae01.alicdn.com/kf/Hc7e13d56efda41779b9ffd8506dbd423Q.jpg_960x960.jpg_.webp","https://ae01.alicdn.com/kf/Hd5181d97ecf142a195eba994b3a93f11j.jpg_960x960.jpg_.webp","https://ae01.alicdn.com/kf/H6e32b9e3300340a5bd00e10a9d360aa6Y.jpg_960x960.jpg_.webp","https://ae01.alicdn.com/kf/H76c20b2bec9149eab77d7896759765bdY.jpg_960x960.jpg_.webp","https://ae01.alicdn.com/kf/Heec23942b04d4c74a223bdd4bfbb51ffU.jpg_960x960.jpg_.webp"],"attributes":[{"name":"Brand Name","id":2,"value":"Nokia","valueId":"361797"},{"name":"Battery Type","id":200001051,"value":"Not Detachable","valueId":"200005444"},{"name":"ROM","id":200001047,"value":"32G","valueId":"100019035"},{"name":"Item Condition","id":200000649,"value":"New","valueId":"360543"}],"htmlDescription":"","priceSummary":{"originalAmount":{"min":{"currency":"USD","value":"145.99"},"max":{"currency":"USD","value":"145.99"}},"unitOriginalAmount":{"min":{"currency":"USD","value":"145.99"},"max":{"currency":"USD","value":"145.99"}},"discountedAmount":{"min":{"currency":"USD","value":"109.49"},"max":{"currency":"USD","value":"109.49"}},"unitDiscountedAmount":{"min":{"currency":"USD","value":"110"},"max":{"currency":"USD","value":"110"}},"bulkAmount":{"min":{"currency":"USD","value":"110"},"max":{"currency":"USD","value":"110"}},"unitBulkAmount":{"min":{"currency":"USD","value":"110"},"max":{"currency":"USD","value":"110"}}},"prices":[{"originalPrice":{"currency":"USD","value":"145.99"},"discountedPrice":{"currency":"USD","value":"109.49"},"bulkPrice":{"currency":"USD","value":"109.49"},"skuImage":"https://ae01.alicdn.com/kf/H6fae6f2e241e4b0cbe562a6bb880e707s.jpg_640x640.jpg","skuThumbnail":"https://ae01.alicdn.com/kf/H6fae6f2e241e4b0cbe562a6bb880e707s.jpg_120x120.jpg","stock":0,"properties":[{"propertyId":200000828,"propertyName":"Bundle","valueId":200003982,"valueName":"3GB 32GB","valueDisplayName":"3GB 32GB","sku":"200000828:200003982#3GB 32GB"},{"propertyId":14,"propertyName":"Color","valueId":29,"valueName":"Black","valueDisplayName":"Black","sku":"14:29#Black"}]},{"originalPrice":{"currency":"USD","value":"145.99"},"discountedPrice":{"currency":"USD","value":"109.49"},"bulkPrice":{"currency":"USD","value":"109.49"},"skuImage":"https://ae01.alicdn.com/kf/Hd5181d97ecf142a195eba994b3a93f11j.jpg_640x640.jpg","skuThumbnail":"https://ae01.alicdn.com/kf/Hd5181d97ecf142a195eba994b3a93f11j.jpg_120x120.jpg","stock":144,"properties":[{"propertyId":200000828,"propertyName":"Bundle","valueId":200003982,"valueName":"3GB 32GB","valueDisplayName":"3GB 32GB","sku":"200000828:200003982#3GB 32GB"},{"propertyId":14,"propertyName":"Color","valueId":193,"valueName":"White","valueDisplayName":"White","sku":"14:193#White"}]},{"originalPrice":{"currency":"USD","value":"145.99"},"discountedPrice":{"currency":"USD","value":"109.49"},"bulkPrice":{"currency":"USD","value":"109.49"},"skuImage":"https://ae01.alicdn.com/kf/H60079e3ef2904761bb9a4cff19f8fa4bG.jpg_640x640.jpg","skuThumbnail":"https://ae01.alicdn.com/kf/H60079e3ef2904761bb9a4cff19f8fa4bG.jpg_120x120.jpg","stock":1,"properties":[{"propertyId":200000828,"propertyName":"Bundle","valueId":200003982,"valueName":"3GB 32GB","valueDisplayName":"3GB 32GB","sku":"200000828:200003982#3GB 32GB"},{"propertyId":14,"propertyName":"Color","valueId":175,"valueName":"Blue","valueDisplayName":"Blue","sku":"14:175#Blue"}]}],"shipping":[{"company":"AliExpress Standard Shipping","serviceName":"CAINIAO_STANDARD","tracking":true,"amount":{"currency":"USD","value":"3.74"},"discount":"74","commitDays":60,"shipFrom":"CN","deliveryTime":{"from":20,"to":35}}]} 
		';

		return $response;
	}

	//////////////////// MODULE ///////////////////////
	public function module($role, $module, $type) {
		$result = 0;
		
		$mod_id = $this->read_field('link', $module, 'access_module', 'id');
		$crud = $this->read_field('role_id', $role, 'access', 'crud');
		if($mod_id) {
			if(!empty($crud)) {
				$crud = json_decode($crud);
				foreach($crud as $cr) {
					$cr = explode('.', $cr);
					if($mod_id == $cr[0]) {
						if($type == 'create'){$result = $cr[1];}
						if($type == 'read'){$result = $cr[2];}
						if($type == 'update'){$result = $cr[3];}
						if($type == 'delete'){$result = $cr[4];}
						break;
					}
				}
			}
		}
		
		return $result;
	}
	public function mod_read($role, $module) {
		$rs = $this->module($role, $module, 'read');
		return $rs;
	}
	//////////////////// END MODULE ///////////////////////
	
}
