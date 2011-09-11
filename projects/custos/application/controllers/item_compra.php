<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Item_compra extends Controller
{
	function Item_compra()
	{
		parent::Controller();
		$this->load->model('item_compra_model');
		$this->load->library('form_validation');
		$this->load->database();
		$this->load->helper('url');
	}
	
	function index()
	{
		$this->load->library('pagination');		
		$config = array();
		$data = array();
		
		$config['base_url'] = site_url('item_compra/index');
		$config['total_rows'] = $this->item_compra_model->count_all();
		$config['per_page'] = 5;
		$this->pagination->initialize($config);
		
		$offset = $this->uri->segment(3);
		$data['item_compra'] = $this->item_compra_model->get_all(5, $offset);
		$data['pagination'] = $this->pagination->create_links();
		
		$this->load->view('item_compra/index', $data);
	}
	
	function add()
	{
		$this->load->view('item_compra/add');
	}
	
	function do_add()
	{
		if ($this->input->post('do_action') === FALSE)
			redirect('item_compra/');

		$this->_set_rules();

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('item_compra/add');
		} else {
			$data = array();
			$data['descricao'] = $this->input->post('descricao');
			$data['valor_unit'] = $this->input->post('valor_unit');
			$data['quantidade'] = $this->input->post('quantidade');
			$data['gastos_id'] = $this->input->post('gastos_id');

			$this->item_compra_model->insert($data);
			redirect('item_compra/');
		}		
	}

	function edit()
	{
		if ($this->uri->segment(3) === FALSE)
			redirect('item_compra/');

		$id = (int)$this->uri->segment(3);
		$item_compra = $this->item_compra_model->get_by_id($id);
					
		$data = array();
		$data['item_compra']['descricao'] = $item_compra->descricao;
		$data['item_compra']['valor_unit'] = $item_compra->valor_unit;
		$data['item_compra']['quantidade'] = $item_compra->quantidade;
		$data['item_compra']['gastos_id'] = $item_compra->gastos_id;

		$this->load->view('item_compra/edit', $data);
	}

	function do_edit()
	{
		if ($this->input->post('do_action') === FALSE || $this->uri->segment(3) === FALSE)
			redirect('item_compra/');
			
		$id = (int)$this->uri->segment(3);
		$data = array();		
		$this->_set_rules();
		
		if ($this->form_validation->run() === FALSE) {
			$data['item_compra'] = null;
			$this->load->view('item_compra/edit', $data);
		} else {
			$data['descricao'] = $this->input->post('descricao');
			$data['valor_unit'] = $this->input->post('valor_unit');
			$data['quantidade'] = $this->input->post('quantidade');
			$data['gastos_id'] = $this->input->post('gastos_id');
			
			$this->item_compra_model->update($data, $id);		
			redirect('item_compra/');
		}		
	}
	
	function delete()
	{
		if ($this->uri->segment(3) === FALSE)
			redirect('item_compra/');
		
		$id = (int)$this->uri->segment(3);
		
		$this->item_compra_model->delete($id);
		redirect('item_compra/');
	}	

	function _set_rules()
	{
		$this->form_validation->set_rules('descricao', 'Descricao', 'required');
		$this->form_validation->set_rules('valor_unit', 'Valor unitario', 'required|numeric');
		$this->form_validation->set_rules('quantidade', 'Quantidade', 'required|integer');
		$this->form_validation->set_rules('gastos_id', 'Gasto', 'required|integer');
	}
}