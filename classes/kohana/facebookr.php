<?php

class Kohana_Facebookr {
	
	protected static $_instance;
	protected $_facebook;
	protected $_session;
	protected $_me;

	protected function __construct()
	{
		require Kohana::find_file('vendor', 'facebook/src/facebook');

		$this->_facebook = new Facebook(
			array(
				'appId' => Kohana::config('facebook')->app_id,
				'secret' => Kohana::config('facebook')->secret,
				'cookie' => true,
			)
		);

		$this->_session = $this->_facebook->getSession();

		try
		{
			$this->_me = $this->_facebook->api('/me');
		}
		catch
		{
			//user not logged in
		}
	}

	public static function instance()
	{
		if ( ! isset(self::$_instance))
		{
			Kohana_Facebookr::$_instance = new Kohana_Facebookr;
		}

		return Kohana_Facebookr::$_instance;
	}

	public function app_id()
	{
		return $this->_facebook->getAppId();
	}

	public function logged_in()
	{
		return $this->_me != NULL;
	}

	public function user_id()
	{
		return $this->_facebook->getUser();
	}

	public function session()
	{
		return $this->_session;
	}
	
	public function login_url($params)
	{
		return $this->_facebook->getLoginUrl($params);
	}

	public function account()
	{
		return $this->_me;
	}

	public function facebook()
	{
		return $this->_facebook;
	}
}
