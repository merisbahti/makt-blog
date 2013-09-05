<?php
class login_handler {
	/*
	* Checks DB if valid user & pass.
	* Sets OR returns session id. Probably sets. Kthxbai.
	* returns false if any exception.
	*/
	public static function login($username, $pass) {
    try {
      $user_bean = R::findOne('user', 'username = ? ', array($username));
      if (!is_null($user_bean) && hash('sha512', $pass) == $user_bean->pass) {
       echo session_id();
       if (is_null(R::findOne('session', 'session_id = ?', array(session_id())))) {
				// Logging out old user from system.
        $same_user_session = R::findOne('session', 'username = ?', array($username));
        if (!is_null($same_user_session)) {
         R::trash($same_user_session);
       }
       $session = R::dispense('session');
       $session->username  		= $username;
       $session->session_id 	= session_id();
       R::store($session);
     }
     return true;
   } else {
    return false;
  }
} catch (exception $e) {
  return false;
}
}
	/*
	* Unconditional log-out, destroy session and remove from database.
	*/
	public static function logout() {
		$id = session_id();
		$session = R::findOne('session', 'session_id = ? ',array($id));
		session_destroy();
		if (!is_null($session))
      R::trash($session);
  }
	/*
	* Checks DB if this is a valid session.
	* Returns boolean.
	*/
	public static function verify() {
		$session_bean = R::findOne('session', 'session_id = ?', array(session_id()));
		if (!is_null($session_bean)) return true; 
		return false;
	}

}
?>