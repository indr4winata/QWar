<?php
Class Profilepicture extends CI_Controller{
	
	function __construct(){
		parent::__construct();
	}
	function get($user_id=""){
		$user_id = trim(strip_tags($user_id));
		if($user_id == "" || !is_numeric($user_id) ){
			if(Auth::isLoggedIn()){ $user_id = $this->session->userdata("user_id");
			}else{ exit;
			}
		}
		$this->load->model("model_user");
		$userDetail = $this->model_user->getUser(array('user_id'=>$user_id,'single'=>true));
		$profpic = "";
		//get profpic from social media
		if($userDetail['facebook_id'] != NULL && $userDetail['facebook_id'] != "NULL" && $userDetail['facebook_id'] != ""){
			// $size = $this->_getSIze($type,"facebook");
			$profpic = "http://graph.facebook.com/".$userDetail['facebook_id']."/picture";
		}else if($userDetail['twitter_id'] != NULL && $userDetail['twitter_id'] != "NULL" && $userDetail['twitter_id'] != ""){
			$access_token['oauth_token'] = $userDetail['oauth_token'];
			$access_token['oauth_token_secret'] = $userDetail['oauth_token_secret'];
			/* If access tokens are not available redirect to connect page. */
			/* Create a TwitterOauth object with consumer/user tokens. */
			require APPPATH.'third_party/twitter/twitteroauth.php';
			$connection = new Twitteroauth();
			$connection->initialize(CONSUMER_KEY,CONSUMER_SECRET,$access_token['oauth_token'], $access_token['oauth_token_secret']);
			$params['user_id'] = $userDetail['twitter_id'];
			$content = $connection->get("users/show", $params);
		
			if(isset($content->profile_image_url) ){
				$profpic = $content->profile_image_url;
			}
			// $size = $this->_getSIze($type,"twitter");
			// $profpic = str_replace("_normal",$size,$profpic);
		
		}else{
			exit;
		}
		
		$content_img = file_get_contents($profpic);
		$getimagesize = getimagesize($profpic);
		
		header('Content-Type: '.$getimagesize['mime']);
		echo $content_img;
	}
	
}