<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Upload extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('login_model');
	}
	public function file_view()
	{
		$this->load->view('file_view', array(
			'error' => ' '
		));
	}
	public function do_upload()
	{
		$config = array(
			'upload_path' => "./uploads/",
			'allowed_types' => "gif|jpg|png|jpeg",
			'overwrite' => TRUE,
			'max_size' => 100000,
			'max_height' => 1024,
			'max_width' => 768
		);
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('userfile')) {
			$error = array(
				'error' => $this->upload->display_errors()
			);
			$this->load->view('templates/header');
			$this->load->view('show_profile', $error);
			$this->load->view('templates/footer');
		} else {
			$data = array(
				'upload_data' => $this->upload->data()
			);
//			$image_name = ($data['upload_data']['file_name']);
//			$resume = base_url().$image_name;
			$this->load->view('templates/header');
			$this->load->view('upload_success', $data);
			$this->load->view('templates/footer');
		}
	}

}
?>
