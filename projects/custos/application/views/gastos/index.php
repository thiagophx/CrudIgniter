<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Gastos</title>
</head>
<body>
	<h1>Gastos - Index</h1>
	<p><?php echo anchor('gastos/add', 'Add'); ?></p>
	<table border="1">
		<thead>
			<tr align="center">
				<td>Id</td>
				<td>Descricao</td>
				<td>Valor</td>
				<td>Data</td>
				<td>Forma pagamento</td>
				<td>Tipo</td>
				<td>Edit</td>
				<td>Delete</td>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($gastos as $gasto) { ?>
			<tr align="center">
				<td><?php echo $gasto->id; ?></td>
				<td><?php echo $gasto->descricao; ?></td>
				<td><?php echo $gasto->valor; ?></td>
				<td><?php echo $gasto->data; ?></td>
				<td><?php echo $gasto->forma_pgto_id; ?></td>
				<td><?php echo $gasto->tipo; ?></td>
				<td><?php echo anchor('gastos/edit/' . $gasto->id, 'Edit'); ?></td>
				<td><?php echo anchor('gastos/delete/' . $gasto->id, 'Delete'); ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<div><?php echo $pagination; ?></div>
</body>
</html>