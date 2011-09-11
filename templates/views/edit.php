<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo ucfirst(strtolower($table['Name'])); ?></title>
</head>
<body>
	<h1><?php echo ucfirst(strtolower($table['Name'])); ?> - Edit</h1>
	<form action="<php> echo site_url('<?php echo strtolower($table['Name']); ?>/do_edit/' . $this->uri->segment(3)); </php>" method="post">
<?php foreach ($table['Fields'] as $field) { ?>
		<p>
			<label for="<?php echo $field['Field']; ?>"><?php echo $field['Name']; ?></label>
			<input type="text" value="<php> echo set_value('<?php echo $field['Field'] ?>', $<?php echo strtolower($table['Name']); ?>['<?php echo $field['Field']; ?>']); </php>" name="<?php echo $field['Field']; ?>" id="<?php echo $field['Field']; ?>" />
<?php if (isset($field['Validate'])) { ?>
			<php> echo form_error('<?php echo $field['Field']; ?>'); </php>
<?php } ?>
		</p>
<?php } ?>
		<p>
			<label for="do_action">Edit</label>
			<input type="submit" value="Edit" id="do_action" name="do_action" />
		</p>
	</form>
</body>
</html>