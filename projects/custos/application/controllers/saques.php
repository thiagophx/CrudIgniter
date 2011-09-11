<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Saques extends Controller
{
	function Saques()
	{
		parent::Controller();
		$this->load->model('saques_model');
		$this->load->library('form_validation');
		$this->load->database();
		$this->output->enable_profiler(true);
		$this->load->helper('url');
	}
	
	function index()
	{
		$this->load->library('pagination');		
		$config = array();
		$data = array();
		
		$config['base_url'] = site_url('saques/index');
		$config['total_rows'] = $this->saques_model->count_all();
		$config['per_page'] = 5;
		$this->pagination->initialize($config);
		
		$offset = $this->uri->segment(3);
		$data['saques'] = $this->saques_model->get_all(5, $offset);
		$data['pagination'] = $this->pagination->create_links();
		
		$this->load->view('saques/index', $data);
	}
	
	function add()
	{
		$this->load->view('saques/add');
	}
	
	function do_add()
	{
		if ($this->input->post('do_action') === FALSE)
			redirect('saques/');

		$this->_set_rules();

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('saques/add');
		} else {
			$data = array();
			$data['saque_data'] = $this->input->post('saque_data');
			$data['saque_valor'] = $this->input->post('saque_valor');
			$data['saque_descricao'] = $this->input->post('saque_descricao');
			$data['saque_taxa'] = $this->input->post('saque_taxa');

			$this->saques_model->insert($data);
			redirect('saques/');
		}		
	}

	function edit()
	{
		if ($this->uri->segment(3) === FALSE)
			redirect('saques/');

		$id = (int)$this->uri->segment(3);
		$saques = $this->saques_model->get_by_id($id);
					
		$data = array();
		$data['saques']['saque_data'] = $saques->saque_data;
		$data['saques']['saque_valor'] = $saques->saque_valor;
		$data['saques']['saque_descricao'] = $saques->saque_descricao;
		$data['saques']['saque_taxa'] = $saques->saque_taxa;

		$this->load->view('saques/edit', $data);
	}

	function do_edit()
	{
		if ($this->input->post('do_action') === FALSE || $this->uri->segment(3) === FALSE)
			redirect('saques/');
			
		$id = (int)$this->uri->segment(3);
		$data = array();		
		$this->_set_rules();
		
		if ($this->form_validation->run() === FALSE) {
			$data['saques'] = null;
			$this->load->view('saques/edit', $data);
		} else {
			$data['saque_data'] = $this->input->post('saque_data');
			$data['saque_valor'] = $this->input->post('saque_valor');
			$data['saque_descricao'] = $this->input->post('saque_descricao');
			$data['saque_taxa'] = $this->input->post('saque_taxa');
			
			$this->saques_model->update($data, $id);		
			redirect('saques/');
		}		
	}
	
	function delete()
	{
		if ($this->uri->segment(3) === FALSE)
			redirect('saques/');
		
		$id = (int)$this->uri->segment(3);
		
		$this->saques_model->delete($id);
		redirect('saques/');
	}	

	function _set_rules()
	{
		$this->form_validation->set_rules('saque_data', 'Data', 'required');
		$this->form_validation->set_rules('saque_valor', 'Valor', 'required|numeric');
		$this->form_validation->set_rules('saque_descricao', 'Descricao', 'required');
		$this->form_validation->set_rules('saque_taxa', 'Taxa', 'required|numeric');
	}
}