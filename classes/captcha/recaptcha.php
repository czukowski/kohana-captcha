<?php defined('SYSPATH') OR die('No direct access.');
/**
 * ReCaptcha driver class.
 *
 * @package		Captcha
 * @subpackage	Captcha_Recaptcha
 * @author		Korney Czukowski
 * @copyright	(c) 2010 Korney Czukowski
 * @license		http://kohanaframework.org/license
 */
class Captcha_Recaptcha extends Captcha
{
	/**
	 * Constructs a new ReCaptcha object.
	 *
	 * @throws Kohana_Exception
	 * @param string Config group name
	 * @return void
	 */
	public function __construct($group = NULL)
	{
		// Create a singleton instance once
		empty(Captcha::$instance) and Captcha::$instance = $this;

		require_once(Kohana::find_file('vendor', 'recaptcha/recaptchalib'));

		// No config group name given
		if ( ! is_string($group))
		{
			$group = 'default';
		}

		Captcha::$config = Kohana::config('captcha.'.$group);

		// Generate a new challenge
		$this->response = $this->generate_challenge();
	}

	/**
	 * Returns captcha response from $_POST array
	 */
	public function get_response()
	{
		return Arr::extract($_POST, array('recaptcha_challenge_field', 'recaptcha_response_field'));
	}

	/**
	 * Checks user response against captcha challenge
	 */
	public function check($response)
	{
		$resp = recaptcha_check_answer(Captcha::$config['private_key'], $_SERVER['REMOTE_ADDR'], $response['recaptcha_challenge_field'], $response['recaptcha_response_field']);
		return $resp->is_valid;
	}

	/**
	 * Generates a new ReCaptcha challenge.
	 * @return string The challenge answer
	 */
	public function generate_challenge()
	{
		if (empty(Captcha::$config['public_key']) OR empty(Captcha::$config['private_key']))
		{
			throw Kohana_Exception('You must configure ReCaptcha public and private keys, see http://www.google.com/recaptcha/whyrecaptcha');
		}
	}

	/**
	 * Outputs the ReCaptcha
	 * @param boolean $html Html output (unused)
	 * @return mixed
	 */
	public function render($html = TRUE)
	{
		return recaptcha_get_html(Captcha::$config['public_key']);
	}

} // End ReCaptcha Driver Class