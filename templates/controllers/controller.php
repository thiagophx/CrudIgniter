<php> if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class <?php echo ucfirst(strtolower($table['Name'])); ?> extends Controller
{
	function <?php echo ucfirst(strtolower($table['Name'])); ?>()
	{
		parent::Controller();
		$this->load->model('<?php echo strtolower($table['Name']); ?>_model');
		$this->load->library('form_validation');
		$this->load->database();
<?php if (!empty($table['Cache'])) { ?>
		$this->output->cache(<?php echo $table['Cache'] ?>);
<?php } ?>
<?php if (isset($table['Profile'])) { ?>
		$this->output->enable_profiler(true);
<?php } ?>
		$this->load->helper('url');
	}
	
	function index()
	{
		$this->load->library('pagination');		
		$config = array();
		$data = array();
		
		$config['base_url'] = site_url('<?php echo strtolower($table['Name']); ?>/index');
		$config['total_rows'] = $this-><?php echo strtolower($table['Name']); ?>_model->count_all();
		$config['per_page'] = 5;
		$this->pagination->initialize($config);
		
		$offset = $this->uri->segment(3);
		$data['<?php echo strtolower($table['Name']); ?>'] = $this-><?php echo strtolower($table['Name']); ?>_model->get_all(5, $offset);
		$data['pagination'] = $this->pagination->create_links();
		
		$this->load->view('<?php echo strtolower($table['Name']); ?>/index', $data);
	}
	
	function add()
	{
		$this->load->view('<?php echo strtolower($table['Name']); ?>/add');
	}
	
	function do_add()
	{
		if ($this->input->post('do_action') === FALSE)
			redirect('<?php echo strtolower($table['Name']); ?>/');

		<?php
		if (isset($table['Validate']))
			include 'includes/add_validate.inc.php';
		else 
			include 'includes/add_default.inc.php';
		?>
		
	}

	function edit()
	{
		if ($this->uri->segment(3) === FALSE)
			redirect('<?php echo strtolower($table['Name']); ?>/');

		$id = (int)$this->uri->segment(3);
		$<?php echo strtolower($table['Name']); ?> = $this-><?php echo strtolower($table['Name']); ?>_model->get_by_id($id);
					
		$data = array();
<?php foreach ($table['Fields'] as $field) { ?>
		$data['<?php echo strtolower($table['Name']); ?>']['<?php echo $field['Field']; ?>'] = $<?php echo strtolower($table['Name']); ?>-><?php echo $field['Field']; ?>;
<?php } ?>

		$this->load->view('<?php echo strtolower($table['Name']); ?>/edit', $data);
	}

	function do_edit()
	{
		if ($this->input->post('do_action') === FALSE || $this->uri->segment(3) === FALSE)
			redirect('<?php echo strtolower($table['Name']); ?>/');
			
		$id = (int)$this->uri->segment(3);
		$data = array();		
		<?php
		if (isset($table['Validate']))
			include 'includes/edit_validate.inc.php';
		else 
			include 'includes/edit_default.inc.php';
		?>
		
	}
	
	function delete()
	{
		if ($this->uri->segment(3) === FALSE)
			redirect('<?php echo strtolower($table['Name']); ?>/');
		
		$id = (int)$this->uri->segment(3);
		
		$this-><?php echo strtolower($table['Name']); ?>_model->delete($id);
		redirect('<?php echo strtolower($table['Name']); ?>/');
	}	
<?php if (isset($table['Validate']))
	include 'includes/set_rules.inc.php';
?>
}