$this->_set_rules();

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('<?php echo strtolower($table['Name']); ?>/add');
		} else {
			$data = array();
<?php foreach ($table['Fields'] as $field) { ?>
			$data['<?php echo $field['Field']; ?>'] = $this->input->post('<?php echo $field['Field']; ?>');
<?php } ?>

			$this-><?php echo strtolower($table['Name']); ?>_model->insert($data);
			redirect('<?php echo strtolower($table['Name']); ?>/');
		}