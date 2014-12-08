<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller {
	public function __construct(){
		parent::__construct();
		if(Auth::isLoggedIn() ) redirect("game/roomlist");
	}
	//facebook
	public function facebook(){
		$this->load->model("model_user");
		$redirect = urldecode($this->input->get("r",true));
		if($redirect == "") $redirect = site_url();
		$config = array(
			'appId' => FB_APP_ID,
			'secret' => FB_SECRET,
			'allowSignedRequest' => false // optional, but should be set to false for non-canvas apps
		);
		require APPPATH.'third_party/facebook/facebook.php';
		$facebook = new Facebook($config);
	
		// Get User ID
		$params = array(
			'scope' => 'email',
			'redirect_uri' => site_url('login/facebook?r='.$redirect),
			'auth_type' => 'reauthenticate'
		);
		
		$user = $facebook->getUser();
		if ($user) { //kalo uda login..
			//store facebook information to database and logged in user..
			try{
				$user_profile = $facebook->api('/me','GET');
				if(isset($user_profile['id']) ) $insert_data['facebook_id'] = $user_profile['id'];
				if(isset($user_profile['id']) ) $insert_data['password'] = Auth::encryptPassword($user_profile['id']);
				if(isset($user_profile['link']) ) $insert_data['facebook_link'] = $user_profile['link'];
				if(isset($user_profile['email']) ) $insert_data['email'] = $user_profile['email'];
				if(isset($user_profile['name']) ) $insert_data['name'] = $user_profile['name'];
				$getUser = $this->model_user->getUser(array('email'=>$user_profile['email'],'single'=>true) );
				if (count($getUser) == 0){
					//save to database..
					$insert_data['created_date'] = date('Y-m-d H:i:s');
					$this->model_user->insert($insert_data);
				}else{
					$this->model_user->update($getUser['user_id'],$insert_data);
				}
				Auth::login($insert_data['email'],$user_profile['id']);
				redirect('game/roomlist');
			}catch(Exception $e) {
				$loginUrl = $facebook->getLoginUrl($params);
				redirect($loginUrl);
			}
		} else { //kalo belum login..
			$loginUrl = $facebook->getLoginUrl($params);
			redirect($loginUrl);
		}
	}
	
	//twitter
	public function twitter(){ // redirect to twitter login page
		/* Build TwitterOAuth object with client credentials. */
		require APPPATH.'third_party/twitter/twitteroauth.php';
		$connection = new TwitterOAuth();
		$connection->initialize(CONSUMER_KEY,CONSUMER_SECRET);
		 
		/* Get temporary credentials. */
		$request_token = $connection->getRequestToken(site_url('login/callback'));

		/* Save temporary credentials to session. */
		$token = $request_token['oauth_token'];
		$this->session->set_userdata('oauth_token', $token);
		$this->session->set_userdata('oauth_token_secret',$request_token['oauth_token_secret']);
		
		/* If last connection failed don't display authorization link. */
		switch ($connection->http_code) {
		  case 200:
			/* Build authorize URL and redirect user to Twitter. */
			$url = $connection->getAuthorizeURL($token,FALSE);
			
			redirect($url . "&force_login=true"); 
			break;
		  default:
			/* Show notification if something went wrong. */
			echo 'Could not connect to Twitter. Refresh the page or try again later.';
		}
	}
	public function callback(){
		require APPPATH.'third_party/twitter/twitteroauth.php';
		
		/* If the oauth_token is old redirect to the connect page. */
		if($this->input->get("denied")){
			$this->session->unset_userdata('oauth_token');
			$this->session->unset_userdata('oauth_token_secret');
			redirect("home");
		}
		if (isset($_REQUEST['oauth_token']) && $this->session->userdata('oauth_token') !== $_REQUEST['oauth_token']) {
			$this->session->set_userdata('oauth_status', 'oldtoken');
			$this->session->unset_userdata('oauth_token');
			$this->session->unset_userdata('oauth_token_secret');
			redirect("home");
		}

		/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
		// $this->load->library("twitteroauth");
		// $connection = $this->twitteroauth;
		$connection = new Twitteroauth();
		$connection->initialize(CONSUMER_KEY,CONSUMER_SECRET,$this->session->userdata('oauth_token'), $this->session->userdata('oauth_token_secret'));
		/* Request access tokens from twitter */
		$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

		/* Save the access tokens. Normally these would be saved in a database for future use. */
		$this->session->set_userdata('access_token',$access_token);

		/* Remove no longer needed request tokens */
		$this->session->unset_userdata('oauth_token');
		$this->session->unset_userdata('oauth_token_secret');

		/* If HTTP response is 200 continue otherwise send to connect page to retry */
		if (200 == $connection->http_code) {
			/* The user has been verified and the access tokens can be saved for future use */
			$this->session->set_userdata('status','verified');
			
			/* Save user access token to database */
			$access_token = $this->session->userdata('access_token');
			$content = $connection->get('account/verify_credentials');
			
			if(isset($content->error)) {
				$this->session->set_flashdata("error",$content->error);
				redirect("home");
			}
			//redirect ke login / register
			$email = 'tw_'.$content->id_str;
			$password = Auth::encryptPassword($email);
			//cek duplicate
			$this->load->model("model_user");
			$getUser = $this->model_user->getUser(array('email'=>$email,'single'=>true) );
			
			$screen_name = "";
			$name = $content->id_str;
			if(isset($content->screen_name) ) $screen_name = $content->screen_name;
			if(isset($content->name) ) $name = $content->name;
			$insert = array(
				'email' => $email,
				'password' => $password,
				'created_date' => date('Y-m-d H:i:s'),
				'twitter_id' => $content->id_str,
				'twitter_username' => $screen_name,
				'oauth_token' => $access_token['oauth_token'],
				'oauth_token_secret' => $access_token['oauth_token_secret'],
				'name' => $name
				);
			//save to database..
			if (count($getUser) == 0){
				$this->model_user->insert($insert);
			}else{
				$this->model_user->update($getUser['user_id'],$insert);
			}
			Auth::login($email,$email);
			
			redirect("game/roomlist");
		} else {
			/* Save HTTP status for error dialog on connnect page.*/
			$this->session->unset_userdata('oauth_token');
			$this->session->unset_userdata('oauth_token_secret');
			redirect(FOLDER_TWITTER."account/index");
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */