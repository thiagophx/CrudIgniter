<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Forma_pgto extends Controller
{
	function Forma_pgto()
	{
		parent::Controller();
		$this->load->model('forma_pgto_model');
		$this->load->library('form_validation');
		$this->load->database();
		$this->load->helper('url');
	}
	
	function index()
	{
		$this->load->library('pagination');		
		$config = array();
		$data = array();
		
		$config['base_url'] = site_url('forma_pgto/index');
		$config['total_rows'] = $this->forma_pgto_model->count_all();
		$config['per_page'] = 5;
		$this->pagination->initialize($config);
		
		$offset = $this->uri->segment(3);
		$data['forma_pgto'] = $this->forma_pgto_model->get_all(5, $offset);
		$data['pagination'] = $this->pagination->create_links();
		
		$this->load->view('forma_pgto/index', $data);
	}
	
	function add()
	{
		$this->load->view('forma_pgto/add');
	}
	
	function do_add()
	{
		if ($this->input->post('do_action') === FALSE)
			redirect('forma_pgto/');

		$this->_set_rules();

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('forma_pgto/add');
		} else {
			$data = array();
			$data['nome'] = $this->input->post('nome');

			$this->forma_pgto_model->insert($data);
			redirect('forma_pgto/');
		}		
	}

	function edit()
	{
		if ($this->uri->segment(3) === FALSE)
			redirect('forma_pgto/');

		$id = (int)$this->uri->segment(3);
		$forma_pgto = $this->forma_pgto_model->get_by_id($id);
					
		$data = array();
		$data['forma_pgto']['nome'] = $forma_pgto->nome;

		$this->load->view('forma_pgto/edit', $data);
	}

	function do_edit()
	{
		if ($this->input->post('do_action') === FALSE || $this->uri->segment(3) === FALSE)
			redirect('forma_pgto/');
			
		$id = (int)$this->uri->segment(3);
		$data = array();		
		$this->_set_rules();
		
		if ($this->form_validation->run() === FALSE) {
			$data['forma_pgto'] = null;
			$this->load->view('forma_pgto/edit', $data);
		} else {
			$data['nome'] = $this->input->post('nome');
			
			$this->forma_pgto_model->update($data, $id);		
			redirect('forma_pgto/');
		}		
	}
	
	function delete()
	{
		if ($this->uri->segment(3) === FALSE)
			redirect('forma_pgto/');
		
		$id = (int)$this->uri->segment(3);
		
		$this->forma_pgto_model->delete($id);
		redirect('forma_pgto/');
	}	

	function _set_rules()
	{
		$this->form_validation->set_rules('nome', 'Nome', 'required');
	}
}