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

	protected $config;

	public function __construct($token = null)
	{
		$this->config = Kohana::$config->load('vkapi');
		if ($token) {
			$this->config->token = $token;
		}
	}

	public function __call($method, $params)
	{
		if (!array_key_exists($method, $this->config->methods)) {
			throw new Vkapi_Exception(
				'Unknown method requested: :method',
				array(':method' => $method),
				self::API_UNKNOWN_METHOD,
			);
		}

		$url = $this->config->endpoint.$method;
		$params['access_token'] = $this->config->token;
		try {
			$response = Request::factory($url)
				->method(Request::GET)
				->query($params)
				->execute();

			Kohana::$log->add(
				Log::DEBUG,
				'Request to :url provided the following response: :response',
				array(':url' => $url, ':response' => $response->body())
			);

			$data = json_decode($response->body());

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