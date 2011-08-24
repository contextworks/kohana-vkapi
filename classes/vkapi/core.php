<?php
/**
 * Implements the wrapper over Vkontakte API
 * @author Paul Chubatyy <xobb@citylance.biz>
 * @package Vkontakte/API
 */
class Vkapi_Core {


	const API_UNKNOWN_METHOD = 'unknown_method';

	/**
	 * Singleton instances
	 * @var array
	 */
	protected static $instances = array();

	/**
	 * Singleton implementation
	 * @static
	 * @param string $token
	 * @return Vkapi
	 */
	public static function instance($token = 'default')
	{
		if (!array_key_exists($token, self::$instances)) {
			self::$instances[$token] = new Vkapi($token);
		}
		return self::$instances[$token];
	}

	/**
	 * Instance configuration
	 * @var \Kohana_Config_Group|object
	 */
	protected $config;

	/**
	 * @param string|null $token
	 */
	public function __construct($token = null)
	{
		$this->config = Kohana::$config->load('vkapi');
		if ($token) {
			$this->config->token = $token;
		}
	}

	/**
	 * @throws Request_Exception|Vkapi_Exception
	 * @param  $method
	 * @param  $params
	 * @return array
	 */
	public function __call($method, $params)
	{
		try {
			// Get the array of params here
			$params = Arr::get($params, 0, array());
            // Normalize the method name for vkontakte
            $method = str_replace('_', '.', $method);
			// URL for request
			$url = $this->config->endpoint.$method;
			// Adding access token to request params
			$params['access_token'] = $this->config->token;
			// Requesting Vkontakte
			$response = Request::factory($url)
				->method(Request::GET)
				->query($params)
				->execute();
			// Returning fetched data
			return Vkapi_Response::factory($response->body())->get_data();
		} catch (Request_Exception $e) {
			// Log request exception
			Kohana::$log->add(
				LOG::ERR,
				'Request to :url failed because of :message',
				array(':url' => $url, ':message' => $e->getMessage())
			);
			// Rethrow it
			throw $e;
		}
	}
}