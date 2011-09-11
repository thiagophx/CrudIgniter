		
<?php foreach ($table['Fields'] as $field) { ?>
		$data['<?php echo $field['Field']; ?>'] = $this->input->post('<?php echo $field['Field']; ?>');
<?php } ?>
			
		$this-><?php echo strtolower($table['Name']); ?>_model->update($data, $id);		
		redirect('<?php echo strtolower($table['Name']); ?>/');