<?php
/**
 * 
 * @author: Paul Chubatyy <xobb@citylance.biz>
 * Date: 8/24/11
 * Time: 2:56 PM 
 */
 
class Vkapi_Response {

	/**
	 * Factory
	 * @static
	 * @param string $json
	 * @return Vkapi_Response
	 */
	public static function factory($json)
	{
		return new Vkapi_Response($json);
	}

	/**
	 * Renders the api response from json
	 * @param string $json
	 */
	public function __construct($json)
	{
		$this->data = json_decode($json, TRUE);
		if ($this->is_error()) {
			throw new Vkapi_Exception(
				'Vkontakte returned error: :code: :msg',
				array(':code' => $this->error_code(), ':msg' => $this->error_message()),
				$this->error_code()
			);
		}
	}

	/**
	 * Checks if error occured
	 * @return bool
	 */
	public function is_error()
	{
		return (bool) Arr::get($this->data, 'error', false);
	}

	/**
	 * Returns error code
	 * @return int
	 */
	public function error_code()
	{
		return Arr::path($this->data, 'error.error_code', 1);
	}

	/**
	 * Returns error message
	 * @return string
	 */
	public function error_message()
	{
		return Arr::path($this->data, 'error.error_msg', 'Unknown error');
	}

	/**
	 * Returns associative array of values that are fetched from vkontakte
	 * @return array
	 */
	public function get_data()
	{
		return $this->data;
	}
}
