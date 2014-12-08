<?php
function embedSuffixInPaging($embedString, $pagination) { //to manipulate pagination link to embed the suffix needed
	$regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
	$unique = array();
	if(preg_match_all("/$regexp/siU", $pagination, $matches)) {
		foreach($matches[2] as $link) {
			if(!isset($unique[$link])) {
				$pagination    = str_replace($link . '"', $link . $embedString . '"', $pagination);
				$unique[$link] = '';
			}
		}
	}
	unset($unique);
	return $pagination;
}
function rand_string($l){ 
	$s= "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"; 
	srand((double)microtime()*1000000); 
	for($i=0; $i<$l; $i++) { 
		$rand.= $s[rand()%strlen($s)]; 
	} 
	return $rand; 
}
	
function fetchUrl($url,$post=array()){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt ($curl, CURLOPT_POST, TRUE);
    curl_setopt ($curl, CURLOPT_POSTFIELDS, $post); 

    curl_setopt($curl, CURLOPT_USERAGENT, 'api');
    curl_setopt($curl, CURLOPT_TIMEOUT, 1);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl,  CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
    curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 10); 

    curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);

    curl_exec($curl); 
	curl_close($curl);  	
}

function get_userInfo($user_id){
	$ci = & get_instance();
	$ci->load->model("model_user");
	$getUser = $ci->model_user->getUser(array('user_id'=>$user_id,'single'=>true));
	return $getUser;
}

function convert_exptolevel($exp=0){
	$ci = & get_instance();
	$ci->load->model("model_experience");
	$getLevel = $ci->model_experience->getLevel(array('experience_min'=>$exp,'order_by'=>'level desc','single'=>true));
	if(count($getLevel) > 0){
		return $getLevel['level'];
	}else{
		return 1;
	}
}
function percentage_user_exp($exp=0){
	$ci = & get_instance();
	$ci->load->model("model_experience");
	$getLevel = $ci->model_experience->getLevel(array('experience_now'=>$exp,'order_by'=>'level asc','single'=>true));
	if(count($getLevel) > 0){
		$next_exp = $getLevel['experience_min'];
		if($next_exp == 0){
			$return = 0;
		}else{
			$return = $exp / $next_exp * 100;
		}
		return $return;
	}else{
		return 100;
	}
}
function numberToPlace($number) {
    if(!is_numeric($number)) return false;
    $number = intval($number);
    $lastNumber = substr($number, -1);
    $lastTwo = substr($number, -2);
    $append = ($lastNumber == '1' && $lastTwo != 11) ? 'st' : (($lastNumber == '2' && $lastTwo != 12) ? 'nd' : (($lastNumber == '3' && $lastTwo != 13) ? 'rd' : 'th'));
    return $number . $append;
}