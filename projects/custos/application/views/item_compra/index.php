<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Item_compra</title>
</head>
<body>
	<h1>Item_compra - Index</h1>
	<p><?php echo anchor('item_compra/add', 'Add'); ?></p>
	<table border="1">
		<thead>
			<tr align="center">
				<td>Id</td>
				<td>Descricao</td>
				<td>Valor unitario</td>
				<td>Quantidade</td>
				<td>Gasto</td>
				<td>Edit</td>
				<td>Delete</td>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($item_compra as $item_compr) { ?>
			<tr align="center">
				<td><?php echo $item_compr->id; ?></td>
				<td><?php echo $item_compr->descricao; ?></td>
				<td><?php echo $item_compr->valor_unit; ?></td>
				<td><?php echo $item_compr->quantidade; ?></td>
				<td><?php echo $item_compr->gastos_id; ?></td>
				<td><?php echo anchor('item_compra/edit/' . $item_compr->id, 'Edit'); ?></td>
				<td><?php echo anchor('item_compra/delete/' . $item_compr->id, 'Delete'); ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<div><?php echo $pagination; ?></div>
</body>
</html>