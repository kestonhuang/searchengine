<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Private_area extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('id'))
		{
			redirect('login');
		}
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('image_lib');
		$this->load->model('login_model');
	}

	function index()
	{
		$this->load->view('templates/header');
		$this->load->view('home');
		$this->load->view('templates/footer');
	}

	public function profile(){
		$data = array();
		if($this->session->userdata('id')){
			$con = array(
				'id' => $this->session->userdata('id')
			);
			$data['user'] = $this->login_model->getRows($con);

			// Pass the user data and load view
			$this->load->view('templates/header');
			$this->load->view('show_profile', $data);
			$this->load->view('templates/footer');
		} else{
			redirect('login');
		}
	}

	public function address(){
		$this->load->view('templates/header');
		$this->load->view('address');
		$this->load->view('templates/footer');
	}

	public function update_profile(){
		$data = array();
		$con = array(
			'id' => $this->session->userdata('id')
		);
		$data['user'] = $this->login_model->getRows($con);
		$this->load->view('templates/header');
		$this->load->view('update_profile', $data);
		$this->load->view('templates/footer');

		if($this->input->post('update'))
		{
			$data = array(
				'name' => $this->input->post('name'),
				'gender' => $this->input->post('gender'),
				'mobile' => $this->input->post('mobile'),
				'bio' => $this->input->post('bio')
			);

			$this->login_model->update_user($this->session->userdata('id'), $data);
			redirect("private_area/profile");
		}
	}

	function search()
	{
		$this->load->view('templates/header');
		$this->load->view('search');
		$this->load->view('templates/footer');
	}

	function ajax_fetch()
	{
		$output = '';
		$query = '';
		if($this->input->post('query'))
		{
			$query = $this->input->post('query');
		}
		$data = $this->login_model->fetch_data($query);
		$output .= '
  <div class="table-responsive">
     <table class="table table-bordered table-striped">
      <tr>
       <th>Item Name</th>
       <th>Category</th>
       <th>Listed By User ID</th>
      </tr>
  ';
		if($data->num_rows() > 0)
		{
			foreach($data->result() as $row)
			{
				$output .= '
      <tr>
       <td><a href="'.base_url().'private_area/'.$row->name.'">'.$row->name.'</a></td>
       <td>'.$row->category.'</td>
       <td>'.$row->listedByUserID.'</td>
      </tr>
    ';
			}
		}
		else
		{
			$output .= '<tr>
       <td colspan="5">No Data Found</td>
      </tr>';
		}
		$output .= '</table>';
		echo $output;
	}

	function sofa(){
		$this->load->view('templates/header');
		$this->load->view('sofa');
		$this->load->view('templates/footer');
	}

	public function image_manipulation() {
		$this->load->view('templates/header');
		$this->load->view('manipulation');
	}

	public function value() {
		if ($this->input->post("submit")) {
			$config = array(
				'upload_path' => "imagemanipulation/",
				'upload_url' => base_url() . "imagemanipulation/",
				'allowed_types' => "gif|jpg|png|jpeg"
			);
			$this->load->library('upload', $config);
			if ($this->upload->do_upload()) {
				$image_data = $this->upload->data();
			}

			switch ($this->input->post("mode")) {
				case "crop":
					$data = $this->crop($image_data);
					$this->load->view('templates/header');
					$this->load->view('manipulation', $data);
					break;
				case "resize":
					$data = $this->resize($image_data);
					$this->load->view('templates/header');
					$this->load->view('manipulation', $data);
					break;
				case "rotate":
					$data = $this->rotate($image_data);
					$this->load->view('templates/header');
					$this->load->view('manipulation', $data);
					break;
				case "watermark":
					$data = $this->water_marking($image_data);
					$this->load->view('templates/header');
					$this->load->view('manipulation', $data);
					break;
				default:
					echo "<script type='text/javascript'> alert('Please Select any option which you want to operate'); </script>";
					$this->load->view('templates/header');
					$this->load->view('manipulation');
					$this->load->view('templates/footer');
					break;
			}
		}
	}

	public function resize($image_data) {
		$img = substr($image_data['full_path'], 51);
		$config['image_library'] = 'gd2';
		$config['source_image'] = $image_data['full_path'];
		$config['new_image'] = './imagemanipulation/new_' . $img;
		$config['width'] = $this->input->post('width');
		$config['height'] = $this->input->post('height');

		$this->image_lib->initialize($config);
		$src = $config['new_image'];
		$data['new_image'] = substr($src, 2);
		$data['img_src'] = base_url() . $data['new_image'];
		$this->image_lib->resize();
		return $data;
	}

	public function rotate($image_data) {
		$img = substr($image_data['full_path'], 51);
		$config['image_library'] = 'gd2';
		$config['source_image'] = $image_data['full_path'];
		$config['rotation_angle'] = $this->input->post('degree');
		$config['quality'] = "90%";
		$config['new_image'] = './imagemanipulation/rot_' . $img;

		$this->image_lib->initialize($config);
		$src = $config['new_image'];
		$data['rot_image'] = substr($src, 2);
		$data['rot_image'] = base_url() . $data['rot_image'];
		$this->image_lib->rotate();
		return $data;
	}

	public function water_marking($image_data) {
		$img = substr($image_data['full_path'], 51);
		$config['image_library'] = 'gd2';
		$config['source_image'] = $image_data['full_path'];
		$config['wm_text'] = $this->input->post('text');
		$config['wm_type'] = 'text';
		$config['wm_font_path'] = './system/fonts/texb.ttf';
		$config['wm_font_size'] = '50';
		$config['wm_font_color'] = '#707A7C';
		$config['wm_hor_alignment'] = 'center';
		$config['new_image'] = './imagemanipulation/watermark_' . $img;

		$this->image_lib->initialize($config);
		$src = $config['new_image'];
		$data['watermark_image'] = substr($src, 2);
		$data['watermark_image'] = base_url() . $data['watermark_image'];
		$this->image_lib->watermark();
		return $data;
	}

	public function crop($image_data) {
		$img = substr($image_data['full_path'], 51);
		$config['image_library'] = 'gd2';
		$config['source_image'] = $image_data['full_path'];
		$config['x_axis'] = $this->input->post('x1');
		$config['y_axis'] = $this->input->post('y1');
		$config['maintain_ratio'] = TRUE;
		$config['width'] = $this->input->post('width_cor');
		$config['height'] = $this->input->post('height_cor');
		$config['new_image'] = './imagemanipulation/crop_' . $img;

		$this->image_lib->initialize($config);
		$src = $config['new_image'];
		$data['crop_image'] = substr($src, 2);
		$data['crop_image'] = base_url() . $data['crop_image'];
		$this->image_lib->crop();
		return $data;
	}

	function zip_download() {
		$this->load->library('zip');
		// pass second argument as FALSE if want to ignore preceding directories
		$this->zip->read_dir('imagemanipulation/');
		// create zip file on server
		$this->zip->archive('imagemanipulation/'.'images.zip');
		// prompt user to download the zip file
		$this->zip->download('images.zip');
	}

	function logout()
	{
		$data = $this->session->all_userdata();
		$this->session->unset_userdata('access_token');
		foreach($data as $row => $rows_value)
		{
			$this->session->unset_userdata($row);
		}
		redirect('login');
	}
}

?>
