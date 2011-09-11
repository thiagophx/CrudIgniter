<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Saques</title>
</head>
<body>
	<h1>Saques - Add</h1>
	<form action="<?php echo site_url('saques/do_add'); ?>" method="post">
		<p>
			<label for="saque_data">Data</label>
			<input type="text" value="<?php echo set_value('saque_data'); ?>"name="saque_data" id="saque_data" />
			<?php echo form_error('saque_data'); ?>
		</p>
		<p>
			<label for="saque_valor">Valor</label>
			<input type="text" value="<?php echo set_value('saque_valor'); ?>"name="saque_valor" id="saque_valor" />
			<?php echo form_error('saque_valor'); ?>
		</p>
		<p>
			<label for="saque_descricao">Descricao</label>
			<input type="text" value="<?php echo set_value('saque_descricao'); ?>"name="saque_descricao" id="saque_descricao" />
			<?php echo form_error('saque_descricao'); ?>
		</p>
		<p>
			<label for="saque_taxa">Taxa</label>
			<input type="text" value="<?php echo set_value('saque_taxa'); ?>"name="saque_taxa" id="saque_taxa" />
			<?php echo form_error('saque_taxa'); ?>
		</p>
		<p>
			<label for="do_action">Add</label>
			<input type="submit" value="Add" id="do_action" name="do_action" />
		</p>
	</form>
</body>
</html>