<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('id'))
		{
			redirect('captcha');
		}
		$this->load->library('form_validation');
		$this->load->library('encryption');
		$this->load->model('login_model');
		$this->load->helper('cookie');
	}

	function index()
	{
		$this->load->view('login');
	}

	function validation()
	{
		$this->form_validation->set_rules('user_email', 'Email Address', 'required|trim|valid_email');
		$this->form_validation->set_rules('user_password', 'Password', 'required');
		if($this->form_validation->run())
		{
			$email = $this->input->post("user_email");
			$password  = $this->input->post("user_password");
			$result = $this->login_model->can_login($this->input->post('user_email'), $this->input->post('user_password'));
			if($result == "SUCCESS")
			{
				if ($this->input->post("chkremember"))
				{
					$this->input->set_cookie('uemail', $email, 21600); /* Create cookie for store emailid */
					$this->input->set_cookie('upassword', $password, 21600); /* Create cookie for password */
				}
				else
				{
					delete_cookie('uemail'); /* Delete email cookie */
					delete_cookie('upassword'); /* Delete password cookie */
				}
				redirect('captcha');
			}
			else
			{
				$this->session->set_flashdata('message',$result);
				redirect('login');
			}
		}
		else
		{
			$this->index();
		}
	}

	public function google_login()
	{
		include_once APPPATH . "libraries/vendor/autoload.php";

		$google_client = new Google_Client();

		$google_client->setClientId('368590564487-279uo62s6gqn7if82vs75ql1181nt3q2.apps.googleusercontent.com'); //Define your ClientID

		$google_client->setClientSecret('JRoO6KdIvyDfhpj5YaR2oIS3'); //Define your Client Secret Key

		$google_client->setRedirectUri('https://infs3202-cfba0131.uqcloud.net/infs3202project/private_area'); //Define your Redirect Uri

		$google_client->addScope('email');

		$google_client->addScope('profile');

		if(isset($_GET["code"]))
		{
			$token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

			if(!isset($token["error"]))
			{
				$google_client->setAccessToken($token['access_token']);

				$this->session->set_userdata('access_token', $token['access_token']);

				$google_service = new Google_Service_Oauth2($google_client);

				$data = $google_service->userinfo->get();

				if($this->login_model->Is_already_register($data['id']))
				{
					//update data
					$user_data = array(
						'name' => $data['given_name'],
						'email' => $data['email']
					);

					$this->login_model->Update_user_data($user_data, $data['id']);
				}
				else
				{
					//insert data
					$user_data = array(
//						'id' => $data['id'],
						'name' => $data['given_name'],
						'email'  => $data['email']
					);

					$this->login_model->Insert_user_data($user_data);
				}
				$this->session->set_userdata('user_data', $user_data);
			}
		}
		$login_button = '';
		if(!$this->session->userdata('access_token'))
		{
			$login_button = '<a href="'.$google_client->createAuthUrl().'"><img src="'.base_url().'./images/google.png" /></a>';
			$data['login_button'] = $login_button;
			$this->load->view('google_login', $data);
		}
		else
		{
			$this->load->view('google_login', $data);
		}
	}


	/* Fuction for display cookies */
	public function DisplayCookieData()
	{
		$this->load->view('displaylogincookiedata'); /* load displaylogincookiedata.php file form views folder */
	}

	public function forgot()
	{
		// Redirect to your logged in landing page here
		$this->load->library('form_validation');
		$this->load->helper('form');
		$data['success'] = false;

		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_exists');

		if($this->form_validation->run()){
			$email = $this->input->post('email');
			$this->load->model('login_model');
			$user = $this->login_model->get_user_by_email($email);
			$slug = md5($user->id . $user->email . date('Ymd'));

			$config = array(
				'protocol'  => 'smtp',
				'smtp_host' => 'mailhub.eait.uq.edu.au',
				'smtp_port' => 25,
				'mailtype'  => 'html',
				'charset'    => 'iso-8859-1',
				'wordwrap'   => TRUE,
				'newline'	=> "\r\n"
			);
			$this->load->library('email', $config);
			$this->email->from('noreply@infs3202-cfba0131.uqcloud.net');
			$this->email->to($email);
			$this->email->subject('UQAuction: Reset your Password');
			$this->email->message('To reset your password please click the link below and follow the instructions:   
			'. site_url('login/reset/'. $user->id .'/'. $slug) .'
			If you did not request to reset your password then please just ignore this email and no changes will occur.
			Note: This reset code will expire after '. date('j M Y') .'.');
			$this->email->send();

			$data['success'] = true;
		}

		$this->load->view('forgot_password', $data);
	}


	public function email_exists($email)
	{
		$this->load->model('login_model');

		if($this->login_model->get_user_by_email($email)){
			return true;
		} else {
			$this->form_validation->set_message('email_exists', 'We couldn\'t find that email address in our system.');
			return false;
		}
	}

	public function reset()
	{

		$this->load->library('form_validation');
		$this->load->helper('form');
		$data['success'] = false;

		$user_id = $this->uri->segment(3);
		if(!$user_id) show_error('Invalid reset code.');
		$hash = $this->uri->segment(4);
		if(!$hash) show_error('Invalid reset code.');

		$this->load->model('login_model');
		$user = $this->login_model->get_user($user_id);
		if(!$user) show_error('Invalid reset code.');
		$slug = md5($user->id . $user->email . date('Ymd'));
		if($hash != $slug) show_error('Invalid reset code.');

		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('password_conf', 'Confirm Password', 'required|matches[password]');

		if($this->form_validation->run()){
			$password = $this->input->post('password');
			$this->login_model->update_user($user_id, array('password' => $password));
			$data['success'] = true;
		}

		$this->load->view('reset_password', $data);
	}

}

?>
