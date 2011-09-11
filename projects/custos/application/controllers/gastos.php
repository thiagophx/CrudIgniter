<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Gastos extends Controller
{
	function Gastos()
	{
		parent::Controller();
		$this->load->model('gastos_model');
		$this->load->library('form_validation');
		$this->load->database();
		$this->load->helper('url');
	}
	
	function index()
	{
		$this->load->library('pagination');		
		$config = array();
		$data = array();
		
		$config['base_url'] = site_url('gastos/index');
		$config['total_rows'] = $this->gastos_model->count_all();
		$config['per_page'] = 5;
		$this->pagination->initialize($config);
		
		$offset = $this->uri->segment(3);
		$data['gastos'] = $this->gastos_model->get_all(5, $offset);
		$data['pagination'] = $this->pagination->create_links();
		
		$this->load->view('gastos/index', $data);
	}
	
	function add()
	{
		$this->load->view('gastos/add');
	}
	
	function do_add()
	{
		if ($this->input->post('do_action') === FALSE)
			redirect('gastos/');

		$this->_set_rules();

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('gastos/add');
		} else {
			$data = array();
			$data['descricao'] = $this->input->post('descricao');
			$data['valor'] = $this->input->post('valor');
			$data['data'] = $this->input->post('data');
			$data['forma_pgto_id'] = $this->input->post('forma_pgto_id');
			$data['tipo'] = $this->input->post('tipo');

			$this->gastos_model->insert($data);
			redirect('gastos/');
		}		
	}

	function edit()
	{
		if ($this->uri->segment(3) === FALSE)
			redirect('gastos/');

		$id = (int)$this->uri->segment(3);
		$gastos = $this->gastos_model->get_by_id($id);
					
		$data = array();
		$data['gastos']['descricao'] = $gastos->descricao;
		$data['gastos']['valor'] = $gastos->valor;
		$data['gastos']['data'] = $gastos->data;
		$data['gastos']['forma_pgto_id'] = $gastos->forma_pgto_id;
		$data['gastos']['tipo'] = $gastos->tipo;

		$this->load->view('gastos/edit', $data);
	}

	function do_edit()
	{
		if ($this->input->post('do_action') === FALSE || $this->uri->segment(3) === FALSE)
			redirect('gastos/');
			
		$id = (int)$this->uri->segment(3);
		$data = array();		
		$this->_set_rules();
		
		if ($this->form_validation->run() === FALSE) {
			$data['gastos'] = null;
			$this->load->view('gastos/edit', $data);
		} else {
			$data['descricao'] = $this->input->post('descricao');
			$data['valor'] = $this->input->post('valor');
			$data['data'] = $this->input->post('data');
			$data['forma_pgto_id'] = $this->input->post('forma_pgto_id');
			$data['tipo'] = $this->input->post('tipo');
			
			$this->gastos_model->update($data, $id);		
			redirect('gastos/');
		}		
	}
	
	function delete()
	{
		if ($this->uri->segment(3) === FALSE)
			redirect('gastos/');
		
		$id = (int)$this->uri->segment(3);
		
		$this->gastos_model->delete($id);
		redirect('gastos/');
	}	

	function _set_rules()
	{
		$this->form_validation->set_rules('descricao', 'Descricao', 'required');
		$this->form_validation->set_rules('valor', 'Valor', 'required|numeric');
		$this->form_validation->set_rules('data', 'Data', 'required');
		$this->form_validation->set_rules('forma_pgto_id', 'Forma pagamento', 'required|integer');
		$this->form_validation->set_rules('tipo', 'Tipo', 'required|integer');
	}
}