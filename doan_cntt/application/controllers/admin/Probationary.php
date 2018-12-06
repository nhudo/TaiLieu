<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/

class Probationary extends MY_Controller
{	
	function __construct(){
		parent::__construct();
		$this->load->model('probationary_model');
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}
	/*
	*lay sanh sach
	*/

	function index(){
		$input = array();
		$list = $this->probationary_model->get_list($input);
		$this->data['list']=$list;
		$total = $this->probationary_model->get_total();
		$this->data['total']=$total;
		$message = $this->session->flashdata('message');
		$this->data['message'] = $message;
		$this->load->library('form_validation');
		$this->load->helper('form');
		if($this->input->post()){
			$this->form_validation->set_rules('name','Tiền lương','required');

		}
		if($this->form_validation->run()){
			$name = $this->input->post('name');
			$data = array(
				'sProbationaryName'=>$name
				);
			if($this->probationary_model->create($data)){
				$this->session->set_flashdata('message','Thêm mới dữ liệu thành công');
			} else{
				$this->session->set_flashdata('message','Không thành công');
			}
			redirect(admin_url('probationary'));
		}
		$this->data['template'] ='admin/probationary/index';
		$this->load->view('admin/main',$this->data);
	}
	function delete(){
		$id = $this->uri->rsegment('3');
		$info = $this->probationary_model->get_info($id);
		if(!$info){
			$this->session->set_flashdata('message','không tồn tại quản trị viên');
			redirect(admin_url('probationary'));
		}
		$this->probationary_model->delete($id);
		$this->session->set_flashdata('message','Xóa dữ liệu thành công');
			redirect(admin_url('probationary'));
	}

	function edit(){
		$input = array();
		$list = $this->probationary_model->get_list($input);
		$this->data['list']=$list;
		$this->load->library('form_validation');
		$this->load->helper('form');
		$id = $this->uri->rsegment('3');
		$info = $this->probationary_model->get_info($id);
		if(!$info){
			$this->session->set_flashdata('message','không tồn tại thành phố');
			redirect(admin_url('naturework'));
		}
		$this->data['info']= $info;
		if($this->input->post()){
			$this->form_validation->set_rules('name','Thành phố','required');
			
		}
		if($this->form_validation->run()){
				$name = $this->input->post('name');
				$timenow = standard_date('DATE_ATOM', time());
				 
				$data = array(
					'sProbationaryName'=>$name,
					'sUpdate'=>$timenow
				);
				//neu thay doi mk thi ta gan mat khau
				
				if($this->naturework_model->update($id,$data)){
					$this->session->set_flashdata('message','Cập nhật dữ liệu thành công ');
				} else{
					$this->session->set_flashdata('message','Không cập nhật được');
				}
				redirect(admin_url('probationary'));
		}
		$this->data['template'] ='admin/probationary/index';
		$this->load->view('admin/main',$this->data);
	}
}