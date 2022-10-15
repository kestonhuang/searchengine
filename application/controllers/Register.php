<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('id'))
		{
			redirect('private_area');
		}
		$this->load->library('form_validation');
		$this->load->model('register_model');
	}

	function index()
	{
		$this->load->view('register');
	}

	public function password_check($str)
	{
		if (preg_match('#[0-9]#', $str) && preg_match('#[a-zA-Z]#', $str)) {
			return TRUE;
		}
		return FALSE;
	}

	function validation()
	{
		$this->form_validation->set_rules('user_name', 'Name', 'required|trim');
		$this->form_validation->set_rules('user_email', 'Email Address', 'required|trim|valid_email|is_unique[account.email]');
		$this->form_validation->set_rules('user_password', 'Password', 'required|min_length[6]|alpha_numeric|callback_password_check');
		$this->form_validation->set_rules('user_studentno', 'Password', 'required|trim');
		if($this->form_validation->run())
		{
			$password = $this->input->post('user_password');
			$verification_key = md5(rand());
			$hashed_password = password_hash($password, PASSWORD_DEFAULT);
			$data = array(
				'name'  => $this->input->post('user_name'),
				'email'  => $this->input->post('user_email'),
				'password' => $hashed_password,
				'student_no'  => $this->input->post('user_studentno'),
				'verification_key' => $verification_key
			);
			$id = $this->register_model->insert($data);
			if($id > 0)
			{
				$subject = "UQAuction: Please verify your email address for login";
				$message = "
				<p>Hi ".$this->input->post('user_name').",</p>
				<p>This is an verification email from UQAuction. To complete your registration process and log in into 
				UQAuction, verify your email by clicking on this link 
				<a href='".base_url()."register/verify_email/".$verification_key."'>link</a>.</p>
				<p>Your email will be verified upon the clicking of the link.</p>
				<p>We hope you have an awesome experience with UQ Auction!</p>
				<p>Regards,</p>
				<p>UQAuction staff</p>
				";
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
				$this->email->to($this->input->post('user_email'));
				$this->email->subject($subject);
				$this->email->message($message);
				$this->email->send();

				$this->load->view('after_registration');
			}
		}
		else
		{
			$this->index();
		}
	}

	function verify_email()
	{
		if($this->uri->segment(3))
		{
			$verification_key = $this->uri->segment(3);
			if($this->register_model->verify_email($verification_key))
			{
				$data['message'] = '<h1 align="center">Your Email has been successfully verified, you can now login from <a href="'.base_url().'login">here</a></h1>';
			}
			else
			{
				$data['message'] = '<h1 align="center">Invalid Link</h1>';
			}
			$this->load->view('email_verification', $data);
		}
	}

}

?>
