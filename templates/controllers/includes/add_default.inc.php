$data = array();
<?php foreach ($table['Fields'] as $field) { ?>
		$data['<?php echo $field['Field']; ?>'] = $this->input->post('<?php echo $field['Field']; ?>');
<?php } ?>

		$this-><?php echo strtolower($table['Name']); ?>_model->insert($data);
		redirect('<?php echo strtolower($table['Name']); ?>/');