<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Forma_pgto</title>
</head>
<body>
	<h1>Forma_pgto - Index</h1>
	<p><?php echo anchor('forma_pgto/add', 'Add'); ?></p>
	<table border="1">
		<thead>
			<tr align="center">
				<td>Id</td>
				<td>Nome</td>
				<td>Edit</td>
				<td>Delete</td>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($forma_pgto as $forma_pgt) { ?>
			<tr align="center">
				<td><?php echo $forma_pgt->id; ?></td>
				<td><?php echo $forma_pgt->nome; ?></td>
				<td><?php echo anchor('forma_pgto/edit/' . $forma_pgt->id, 'Edit'); ?></td>
				<td><?php echo anchor('forma_pgto/delete/' . $forma_pgt->id, 'Delete'); ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<div><?php echo $pagination; ?></div>
</body>
</html>