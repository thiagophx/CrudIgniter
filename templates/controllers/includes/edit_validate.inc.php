$this->_set_rules();
		
		if ($this->form_validation->run() === FALSE) {
			$data['<?php echo strtolower($table['Name']); ?>'] = null;
			$this->load->view('<?php echo strtolower($table['Name']); ?>/edit', $data);
		} else {
<?php foreach ($table['Fields'] as $field) { ?>
			$data['<?php echo $field['Field']; ?>'] = $this->input->post('<?php echo $field['Field']; ?>');
<?php } ?>
			
			$this-><?php echo strtolower($table['Name']); ?>_model->update($data, $id);		
			redirect('<?php echo strtolower($table['Name']); ?>/');
		}