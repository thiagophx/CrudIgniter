<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Gastos</title>
</head>
<body>
	<h1>Gastos - Add</h1>
	<form action="<?php echo site_url('gastos/do_add'); ?>" method="post">
		<p>
			<label for="descricao">Descricao</label>
			<input type="text" value="<?php echo set_value('descricao'); ?>"name="descricao" id="descricao" />
			<?php echo form_error('descricao'); ?>
		</p>
		<p>
			<label for="valor">Valor</label>
			<input type="text" value="<?php echo set_value('valor'); ?>"name="valor" id="valor" />
			<?php echo form_error('valor'); ?>
		</p>
		<p>
			<label for="data">Data</label>
			<input type="text" value="<?php echo set_value('data'); ?>"name="data" id="data" />
			<?php echo form_error('data'); ?>
		</p>
		<p>
			<label for="forma_pgto_id">Forma pagamento</label>
			<input type="text" value="<?php echo set_value('forma_pgto_id'); ?>"name="forma_pgto_id" id="forma_pgto_id" />
			<?php echo form_error('forma_pgto_id'); ?>
		</p>
		<p>
			<label for="tipo">Tipo</label>
			<input type="text" value="<?php echo set_value('tipo'); ?>"name="tipo" id="tipo" />
			<?php echo form_error('tipo'); ?>
		</p>
		<p>
			<label for="do_action">Add</label>
			<input type="submit" value="Add" id="do_action" name="do_action" />
		</p>
	</form>
</body>
</html>