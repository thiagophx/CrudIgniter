<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Saques</title>
</head>
<body>
	<h1>Saques - Index</h1>
	<p><?php echo anchor('saques/add', 'Add'); ?></p>
	<table border="1">
		<thead>
			<tr align="center">
				<td>Id</td>
				<td>Data</td>
				<td>Valor</td>
				<td>Descricao</td>
				<td>Taxa</td>
				<td>Edit</td>
				<td>Delete</td>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($saques as $saque) { ?>
			<tr align="center">
				<td><?php echo $saque->saque_id; ?></td>
				<td><?php echo $saque->saque_data; ?></td>
				<td><?php echo $saque->saque_valor; ?></td>
				<td><?php echo $saque->saque_descricao; ?></td>
				<td><?php echo $saque->saque_taxa; ?></td>
				<td><?php echo anchor('saques/edit/' . $saque->saque_id, 'Edit'); ?></td>
				<td><?php echo anchor('saques/delete/' . $saque->saque_id, 'Delete'); ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<div><?php echo $pagination; ?></div>
</body>
</html>