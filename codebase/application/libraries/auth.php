<?php
class Auth{

	public static function getLoggedInUserInfo(){
		$ci = & get_instance();
		$ci->load->model("model_user");
		$user = $ci->model_user;
		$data = $user->getUser(array('user_id'=>$ci->session->userdata('user_id'),'single'=>true));
		return $data; 
	}
	public static function encryptPassword($plainText, $salt = null) {
		if ($salt === null) {
			$salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
		} else {
			$salt = substr($salt, 0, SALT_LENGTH); 
		}		
		return $salt . sha1($salt . $plainText);
	}
	public static function isLoggedIn() { //cek user sudah login atau belum
		$ci = & get_instance();
		$session = $ci->session->userdata('user_id');
		if($session != ''){
			return true;
		}
		return false;
	}
	public static function getpass($password,$password_db){
		return Auth::encryptPassword($password,substr($password_db, 0, SALT_LENGTH));
	}
	public static function logout(){ //logout
		$ci = & get_instance();
		$ci->session->set_userdata('user_id','');
		$ci->session->sess_destroy();
	}
	public static function login($email,$password){ //login
		$ci = & get_instance();
		$ci->load->model("model_user");
		$user = $ci->model_user;
		$data = $user->getUser(array('email'=>$email,'single'=>true));
		if($data['user_id'] == NULL){
			return false;
		}else{
			$get_pass = Auth::getpass($password,$data['password']);
			if($get_pass == $data['password']){
				$ci->session->set_userdata('user_id', $data['user_id']);
				$ci->session->set_userdata('is_admin', $data['is_admin']);
				$user->update($data['user_id'],array('last_login'=>date("Y-m-d H:i:s")));
				return true;
			}
			return false;
		}
	}
}