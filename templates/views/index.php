<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo ucfirst(strtolower($table['Name'])); ?></title>
</head>
<body>
	<h1><?php echo ucfirst(strtolower($table['Name'])); ?> - Index</h1>
	<p><php> echo anchor('<?php echo strtolower($table['Name']); ?>/add', 'Add'); </php></p>
	<table border="1">
		<thead>
			<tr align="center">
				<td><?php echo $table['Primary']['Name']; ?></td>
<?php foreach ($table['Fields'] as $field) { ?>
				<td><?php echo $field['Name']; ?></td>
<?php } ?>
				<td>Edit</td>
				<td>Delete</td>
			</tr>
		</thead>
		<tbody>
		<php> foreach ($<?php echo strtolower($table['Name']); ?> as $<?php echo substr(strtolower($table['Name']), 0, -1); ?>) { </php>
			<tr align="center">
				<td><php> echo $<?php echo substr(strtolower($table['Name']), 0, -1); ?>-><?php echo $table['Primary']['Field']; ?>; </php></td>
<?php foreach ($table['Fields'] as $field) { ?>
				<td><php> echo $<?php echo substr(strtolower($table['Name']), 0, -1); ?>-><?php echo $field['Field']; ?>; </php></td>
<?php } ?>
				<td><php> echo anchor('<?php echo strtolower($table['Name']); ?>/edit/' . $<?php echo substr(strtolower($table['Name']), 0, -1); ?>-><?php echo $table['Primary']['Field']; ?>, 'Edit'); </php></td>
				<td><php> echo anchor('<?php echo strtolower($table['Name']); ?>/delete/' . $<?php echo substr(strtolower($table['Name']), 0, -1); ?>-><?php echo $table['Primary']['Field']; ?>, 'Delete'); </php></td>
			</tr>
		<php> } </php>
		</tbody>
	</table>
	<div><php> echo $pagination; </php></div>
</body>
</html>