<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Captcha extends CI_Controller
{
	function __construct() {
		parent::__construct();

		// Load session library
		$this->load->library('session');
		$this->load->library('image_lib');

		// Load the captcha helper
		$this->load->helper('captcha');
		$this->load->helper('url');
		$this->load->helper('form');
	}

	public function index(){
		// If captcha form is submitted
		if($this->input->post('submit')){
			$inputCaptcha = $this->input->post('captcha');
			$sessCaptcha = $this->session->userdata('captchaCode');
			if($inputCaptcha === $sessCaptcha){
				redirect('private_area');
			}else{
				echo 'Captcha code does not match, please try again.';
			}
		}

		// Captcha configuration
		$config = array(
			'img_path'      => 'captcha_images/',
			'img_url'       => base_url().'captcha_images/',
			'font_path'     => 'system/fonts/texb.ttf',
			'img_width'     => '240',
			'img_height'    => 80,
			'word_length'   => 8,
			'font_size'     => 25,
			'expiration'    => 7200
		);
		$captcha = create_captcha($config);

		// Unset previous captcha and set new captcha word
		$this->session->unset_userdata('captchaCode');
		$this->session->set_userdata('captchaCode', $captcha['word']);

		// Pass captcha image to view
		$data['captchaImg'] = $captcha['image'];

		// Load the view
		$this->load->view('captcha', $data);
	}

	public function refresh(){
		// Captcha configuration
		$config = array(
			'img_path'      => 'captcha_images/',
			'img_url'       => base_url().'captcha_images/',
			'font_path'     => 'system/fonts/texb.ttf',
			'img_width'     => '240',
			'img_height'    => 80,
			'word_length'   => 8,
			'font_size'     => 25,
			'expiration'    => 7200
		);
		$captcha = create_captcha($config);

		// Unset previous captcha and set new captcha word
		$this->session->unset_userdata('captchaCode');
		$this->session->set_userdata('captchaCode',$captcha['word']);

		// Display captcha image
		echo $captcha['image'];
	}
}
