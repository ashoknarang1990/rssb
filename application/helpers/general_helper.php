<?php
function error_page($cod=404) {
	
}

function base_url() {
	$ci = &get_instance();
	//pr($ci->config);die;
	return $ci->config->config['base_url'];
}

function redirect($path='') {
	$path = base_url().$path;
	header("location:".$path);
	exit;
}

function is_user_login($redirect=true) {
	global $_COOKIE,$_SESSION;
	//pr($_SESSION);die;
	
	$dec64 = (isset($_COOKIE['user_login_data']) && trim($_COOKIE['user_login_data'])!='') ? base64decode($_COOKIE['user_login_data']) : '';
	$dec_data = array();
	if(trim($dec64)!='') {
		$dec_data = json_decode($dec64,true);
	}
	
	
	$user_id = (isset($dec_data['id']) && $dec_data['id']>0) ? $dec_data['id'] : 0;
		
	if($user_id > 0) {
		return true;
	}
	else {
		if($redirect) {
			redirect();
		}
		else {
			return false;
		}
	}
}

function get_logged_in_data($key) {
	global $_COOKIE,$_SESSION;
	//pr($_SESSION);die;
	
	$dec64 = (isset($_COOKIE['user_login_data']) && trim($_COOKIE['user_login_data'])!='') ? base64decode($_COOKIE['user_login_data']) : '';
	$dec_data = array();
	if(trim($dec64)!='') {
		$dec_data = json_decode($dec64,true);
	}
	
	
	$user_id = (isset($dec_data['id']) && $dec_data['id']>0) ? $dec_data['id'] : 0;
		
	if($user_id > 0 && isset($dec_data[$key])) {
		return $dec_data[$key];
	}
	else {
		return false;
	}
}

function set_display_message($mess,$type) {
	$ci = &get_instance();
	$ci->load->library('session');
	$ci->session->set_userdata('DISPLAY_MESSAGE_TEXT', $mess);
	$ci->session->set_userdata('DISPLAY_MESSAGE_TYPE', $type);
}

function display_session_message() {
	$ci = &get_instance();
	$ci->load->library('session');
	$mess = $ci->session->userdata('DISPLAY_MESSAGE_TEXT');
	$type = $ci->session->userdata('DISPLAY_MESSAGE_TYPE');
	if(trim($mess) != '' ) {
		$type = trim($type)!='' ? $type : 'info';
		$mess = '<div class="alert alert-'.strtolower($type).'"><strong>'.display_capital($mess).'</strong></div>';
		echo $mess;
		$ci->session->unset_userdata('DISPLAY_MESSAGE_TEXT');
		$ci->session->unset_userdata('DISPLAY_MESSAGE_TYPE');
	}
	else {
		return '';
	}
}

function timeAgo($time){
	$time = (!is_numeric($time)) ? strtotime($time) : $time;
   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
   $lengths = array("60","60","24","7","4.35","12","10");

   $now = time();

       $difference     = $now - $time;
       $tense         = "ago";

   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
       $difference /= $lengths[$j];
   }

   $difference = round($difference);

   if($difference != 1) {
       $periods[$j].= "s";
   }

   return "$difference $periods[$j] ago ";
}

function display_price($price) {
    if(checkFloat($price)){
    return "$".number_format($price, 2, '.', '');
    }else{
   	return "$".number_format($price);
    }
}

function display_percent($price) {
    if(checkFloat($price)){
	return number_format($price, 2, '.', '').'%';
    }else{
    return number_format($price).'%';
    }
}

function calculate_percent($prevpr,$curpr) {
	$val = $prevpr-$curpr;
	if($val<=0){
		$amountper = 0;
	}else{
		$amountper = (($prevpr-$curpr)/($prevpr))*100;
	}
	
	if($amountper==100){
		$amountper = 0;
	}
    if(checkFloat($amountper)){
    return number_format($amountper,2, '.', '');
    }else{
    return number_format($amountper);
    }

}

function checkFloat($s_value) {
    $regex = '/^\s*[+\-]?(?:\d+(?:\.\d*)?|\.\d+)\s*$/';
    return preg_match($regex, $s_value);
}


function display_number($num) {
	return number_format($num);
}

function getDateTime($datetime='',$timezone='',$format='Y-m-d H:i:s') {
	$format = trim($format)=='' ? 'Y-m-d H:i:s' : $format;
	$datetime = (trim($datetime)=='') ? date($format) : $datetime;
	return date($format,strtotime($datetime));
}

function hasIsset($var,$needle='',$default='') {
	if($needle=='') {
		return (isset($var)) ? $var : $default;
	}
	if(is_object($var)) {
		return (isset($var->$needle) ? $var->$needle : $default);
	}
	elseif(is_array($var)) {
		return (isset($var[$needle]) ? $var[$needle] : $default);
	}
	elseif(is_string($var) && trim($var)!='') {
		return (strpos($var,$needle)!==false) ? true : false;
	}
	else {
		return $default;
	}
}

function object_to_array($object) {
  $data = json_decode(json_encode($object), true);
  return $data;
}


function base64encode($input) {
	$default = "ABCDEFQRSTUVWXYZabcdefghiuvwxyz012789+/=";
	$custom  = "ZYXWVUTSRQFEDCBAzyxwvuihgfedcba987210+/$";
	return strtr(base64_encode($input), $default, $custom);
}

function base64decode($input) {
	$default = "ABCDEFQRSTUVWXYZabcdefghiuvwxyz012789+/=";
	$custom  = "ZYXWVUTSRQFEDCBAzyxwvuihgfedcba987210+/$";
	return base64_decode(strtr($input, $custom, $default));
}


function pr($val){
	 echo '<pre>';print_r($val);
}

function generate_password($length = 7){
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, strlen($characters) - 1)];
	}
	return $randomString;
}

function get_encrypted_password($pass) {
	$key = md5("aagaz_trade_mart_key");
	return base64encode($pass.$key);
}

function generateRandomString($length = 10, $mode="sln") {
	$characters = "";
	if(strpos($mode,"s")!==false){$characters.="abcdefghijklmnopqrstuvwxyz";}
	if(strpos($mode,"l")!==false){$characters.="ABCDEFGHIJKLMNOPQRSTUVWXYZ";}
	if(strpos($mode,"n")!==false){$characters.="0123456789";}
	
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
	$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

function validateEmail($email) {
  	return filter_var($email, FILTER_VALIDATE_EMAIL);
}


function display_upper($str) {
	if(trim($str)!='') {
		return trim(strtoupper($str));
	}
	return false;
}

function display_lower($str) {
	if(trim($str)!='') {
		return trim(strtolower($str));
	}
	return false;
}

function display_capital($str) {
	if(trim($str)!='') {
		return trim(ucwords(display_lower(display_upper($str))));
	}
	return false;
}

function website($url = '',$custom_url = '') {
	if(trim($url)!='') {
		return (display_lower(substr($url,0,7)) == 'http://' || display_lower(substr($url,0,8)) == 'https://')
        ? $url 
        : 'http://'.$url;
	}
	elseif(trim($custom_url) != ''){
		return $custom_url;
	}
	return '#';
}

function convert_json_to_array($str,$obj=false){
	$ret = ($obj==true)?false:true;
	return json_decode($str,$ret);
}

function generate_pdf($file='',$name='',$path='',$save=false){
	$ci = &get_instance();
	$ci->load->library('mpdf');
	$mpdf=new mPDF('c'); 
	$mpdf->SetDisplayMode('fullpage');
	$mpdf->list_indent_first_level = 0;  
	// 1 or 0 - whether to indent the first level of a list
	$html = get_image_data($file);
	$mpdf->WriteHTML($html);
	if($save==true) {
		$mpdf->Output($path.$name,'F');
	}
	else {
		$mpdf->Output();
	}
}

function get_image_data($path) {
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $path);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	//curl_setopt($curl, CURLOPT_HEADER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	$data = curl_exec($curl);
	curl_close($curl);
	//$data = file_get_contents($path);
	return $data;
}

function send_mail($data,$smtp=array()) {
	
	$ci =& get_instance();
	
	$smtp['name'] = 'Aagaaz Trade Mart';
	$smtp['security'] = 'ssl';
	$smtp['host'] = 'smtp.gmail.com';
	$smtp['port'] = '465';
	$smtp['user'] = 'mailer.wps@gmail.com';
	$smtp['pass'] = 'WPS#2017web';
	
	$config = Array(
	'protocol' => 'smtp',
	'smtp_host' => $smtp['security'].'://'.$smtp['host'],
	'smtp_port' => $smtp['port'],
	'smtp_user' => $smtp['user'],
	'smtp_pass' => $smtp['pass'],
	'mailtype'  => 'html', 
	'charset'   => 'iso-8859-1'
	);
	$ci->load->library('email', $config);
	$ci->email->set_newline("\r\n");
	
	$ci->email->from($smtp['user'], $smtp['name']);
	$list = array($data['to']);
	$ci->email->to($list);
	$ci->email->reply_to($smtp['user'], $smtp['name']);
	$ci->email->subject($data['subject']);
	$ci->email->message($data['message']);
	
	
	// Set to, from, message, etc.

	$result = $ci->email->send();
	return $result;
}
?>