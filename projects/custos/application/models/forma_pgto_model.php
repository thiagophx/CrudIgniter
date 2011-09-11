<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Forma_pgto_model extends Model
{
	var $table = 'forma_pgto';
	
	function Forma_pgto_model()
	{
		parent::Model();
	}

	function get_all($limit = null, $offset = null)
	{
		$this->db->order_by('id', 'desc');
		$query = $this->db->get($this->table, $limit, $offset);
		return $query->result();
	}
	
	function get_by_id($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get($this->table);
		return $query->row();
	}
	
	function count_all()
	{
		return $this->db->count_all($this->table);
	}
	
	function insert($data)
	{
		$this->db->insert($this->table, $data);
	}
	
	function update($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update($this->table, $data);
	}
	
	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}
}