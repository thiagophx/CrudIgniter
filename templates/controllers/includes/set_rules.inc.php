
	function _set_rules()
	{
<?php
foreach ($table['Fields'] as $field) {
	if (isset($field['ValidateRule'])) { ?>
		$this->form_validation->set_rules('<?php echo $field['Field']; ?>', '<?php echo $field['Name']; ?>', '<?php echo $field['ValidateRule']; ?>');
<?php
	} else { ?>
		$this->form_validation->set_rules('<?php echo $field['Field']; ?>', '<?php echo $field['Name']; ?>');
<?php
	}
} ?>
	}
