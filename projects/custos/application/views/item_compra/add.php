<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Item_compra</title>
</head>
<body>
	<h1>Item_compra - Add</h1>
	<form action="<?php echo site_url('item_compra/do_add'); ?>" method="post">
		<p>
			<label for="descricao">Descricao</label>
			<input type="text" value="<?php echo set_value('descricao'); ?>"name="descricao" id="descricao" />
			<?php echo form_error('descricao'); ?>
		</p>
		<p>
			<label for="valor_unit">Valor unitario</label>
			<input type="text" value="<?php echo set_value('valor_unit'); ?>"name="valor_unit" id="valor_unit" />
			<?php echo form_error('valor_unit'); ?>
		</p>
		<p>
			<label for="quantidade">Quantidade</label>
			<input type="text" value="<?php echo set_value('quantidade'); ?>"name="quantidade" id="quantidade" />
			<?php echo form_error('quantidade'); ?>
		</p>
		<p>
			<label for="gastos_id">Gasto</label>
			<input type="text" value="<?php echo set_value('gastos_id'); ?>"name="gastos_id" id="gastos_id" />
			<?php echo form_error('gastos_id'); ?>
		</p>
		<p>
			<label for="do_action">Add</label>
			<input type="submit" value="Add" id="do_action" name="do_action" />
		</p>
	</form>
</body>
</html>