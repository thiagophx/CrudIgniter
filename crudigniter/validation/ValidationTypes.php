<?php
/**
 * Validation rules
 * 
 * @author Thiago Rigo <thiagophx@gmail.com>
 * @since 1.0
 * @package crudigniter
 * @subpackage validation
 */
$ValidationTypes = array(
	array(
		'Name' => 'Do not validate this field'
	),
	array(
		'Name' => 'Type validation rule'
	),
	array(
		'Name' => 'Required',
		'Rule' => 'required'
	),
	array(
		'Name' => 'Matches',
		'Rule' => 'matches[%s]'
	),
	array(
		'Name' => 'Min_length',
		'Rule' => 'min_length[%s]'
	),
	array(
		'Name' => 'Max_length',
		'Rule' => 'max_length[%s]'
	),
	array(
		'Name' => 'Exact_length',
		'Rule' => 'exact_length[%s]'
	),
	array(
		'Name' => 'Alpha',
		'Rule' => 'alpha'
	),
	array(
		'Name' => 'Alpha_numeric',
		'Rule' => 'alpha_numeric'
	),
	array(
		'Name' => 'Alpha_dash',
		'Rule' => 'alpha_dash'
	),
	array(
		'Name' => 'Numeric',
		'Rule' => 'numeric'
	),
	array(
		'Name' => 'Integer',
		'Rule' => 'integer'
	),
	array(
		'Name' => 'Is_natural',
		'Rule' => 'is_natural'
	),
	array(
		'Name' => 'Is_natural_no_zero',
		'Rule' => 'is_natural_no_zero'
	),
	array(
		'Name' => 'Valid_email',
		'Rule' => 'valid_email'
	),
	array(
		'Name' => 'Valid_emails',
		'Rule' => 'valid_emails'
	),
	array(
		'Name' => 'Valid_ip',
		'Rule' => 'valid_ip'
	),
	array(
		'Name' => 'Valid_base64',
		'Rule' => 'valid_base64'
	)
);