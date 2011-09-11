<php> if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class <?php echo ucfirst(strtolower($table['Name'])); ?>_model extends Model
{
	var $table = '<?php echo $table['Name']; ?>';
	
	function <?php echo ucfirst(strtolower($table['Name'])); ?>_model()
	{
		parent::Model();
	}

	function get_all($limit = null, $offset = null)
	{
		$this->db->order_by('<?php echo $table['Primary']['Field']; ?>', 'desc');
		$query = $this->db->get($this->table, $limit, $offset);
		return $query->result();
	}
	
	function get_by_id($id)
	{
		$this->db->where('<?php echo $table['Primary']['Field']; ?>', $id);
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
		$this->db->where('<?php echo $table['Primary']['Field']; ?>', $id);
		$this->db->update($this->table, $data);
	}
	
	function delete($id)
	{
		$this->db->where('<?php echo $table['Primary']['Field']; ?>', $id);
		$this->db->delete($this->table);
	}
}