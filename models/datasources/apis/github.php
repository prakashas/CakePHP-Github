<?php
/**
 * Github Driver for Apis Source
 * 
 * Makes usage of the Apis plugin by Proloser
 *
 * @package Github Datasource
 * @author Dean Sofer, Sam S
 * @version 0.0.3
 **/
class Github extends ApisSource {
	
	// TODO: Relocate to a dedicated schema file
	var $_schema = array(
		'repositories' => array(
			'type' => array(
				'type' => 'integer',
				'null' => true,
				'key' => 'primary',
				'length' => 11,
			),
			'language' => array(
				'type' => 'string',
				'null' => true,
				'key' => 'primary',
				'length' => 140
			),
			'has_downloads' => array(
				'type' => 'string',
				'null' => true,
				'key' => 'primary',
				'length' => 140
			),
			'url' => array(
				'type' => 'string',
				'null' => true,
				'key' => 'primary',
				'length' => 140
			),
			'homepage' => array(
				'type' => 'string',
				'null' => true,
				'key' => 'primary',
				'length' => 140
			),
			'pushed_at' => array(
				'type' => 'string',
				'null' => true,
				'key' => 'primary',
				'length' => 140
			),
			'created_at' => array(
				'type' => 'string',
				'null' => true,
				'key' => 'primary',
				'length' => 140
			),
			'fork' => array(
				'type' => 'string',
				'null' => true,
				'key' => 'primary',
				'length' => 140
			),
			'has_wiki' => array(
				'type' => 'string',
				'null' => true,
				'key' => 'primary',
				'length' => 140
			),
			'score' => array(
				'type' => 'string',
				'null' => true,
				'key' => 'primary',
				'length' => 140
			),
			'size' => array(
				'type' => 'string',
				'null' => true,
				'key' => 'primary',
				'length' => 140
			),
			'private' => array(
				'type' => 'string',
				'null' => true,
				'key' => 'primary',
				'length' => 140
			),
			'name' => array(
				'type' => 'string',
				'null' => true,
				'key' => 'primary',
				'length' => 140
			),
			'watchers' => array(
				'type' => 'string',
				'null' => true,
				'key' => 'primary',
				'length' => 140
			),
			'owner' => array(
				'type' => 'string',
				'null' => true,
				'key' => 'primary',
				'length' => 140
			),
			'open_issues' => array(
				'type' => 'string',
				'null' => true,
				'key' => 'primary',
				'length' => 140
			),
			'description' => array(
				'type' => 'string',
				'null' => true,
				'key' => 'primary',
				'length' => 140
			),
			'forks' => array(
				'type' => 'string',
				'null' => true,
				'key' => 'primary',
				'length' => 140
			),
			'has_issues' => array(
				'type' => 'string',
				'null' => true,
				'key' => 'primary',
				'length' => 140
			),
		)
	);
	
	/**
	 * Redirect the user to this address
	 *
	 * @param string $returnUri The postback location to call DS->getToken() from
	 * @return string $redirectUri
	 */
	function tokenUrl($returnUri) {
		 return "https://github.com/login/oauth/authorize?client_id={$this->config['login']}&redirect_uri={$returnUri}";
	}
	
	/**
	 * Posts back to github after the user returns from tokenUrl() to retrieve the token
	 *
	 * @param string $returnUri 
	 * @param string $code 
	 * @return void
	 */
	function getToken($returnUri = null, $code = null) {
		App::import('Core', 'HttpSocket');
		$socket = new HttpSocket();
		
		if (empty($returnUri) && isset($_GET['redirect_uri']))
			$returnUri = $_GET['redirect_uri'];
		if (empty($code) && isset($_GET['code']))
			$code = $_GET['code'];
		
		$response = $socket->post('https://github.com/login/oauth/access_token', array(
			'client_id' => $this->config['login'],
			'redirect_uri' => $returnUri,
			'client_secret' => $this->config['password'],
			'code' => $code,
		));
		
		return $response['access_token'];
	}
	
	/**
	 *  Authenticate with github using a username and password or token
	 *
	 * @param string $username 
	 * @param string $secret 
	 * @param string $method 
	 * @return void
	 */
	function authenticate($username = null, $secret = null, $method = null) {
		if (!$username)
			$username = $this->config['login'];
		if (!$secret && isset($this->config['password']))
			$secret = $this->config['password'];
		if (!$secret && isset($_GET))
			$secret = $this->config['password'];
		return $this->github->authenticate($username, $secret, $method);
	}
	
	function deAuthenticate() {
		return $this->github->deAuthenticate();
	}
}