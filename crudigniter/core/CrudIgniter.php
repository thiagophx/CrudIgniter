<?php
/**
 * Control the CrudIgniter execution
 * 
 * @author Thiago Rigo <thiagophx@gmail.com>
 * @since 1.0
 * @package crudigniter
 * @subpackage core
 */
class CrudIgniter
{
	/**
	 * Validate the request and send to the
	 * ProjectIgniter class
	 * 
	 * @since 1.0
	 * @access public
	 * @param array $args the arguments of console
	 * @return void
	 */
	public function __construct($args)
	{
		if (! isset($args[1])) {
			ConsoleIgniter::write('To access help, type "php ci -help"');
			ConsoleIgniter::bye();
		}
		
		$this->welcome();
		
		if ( ($args[1] == '-help') || ($args[1] == '-h') ) {
			$this->help();
		} else {
			new ProjectIgniter($args[1]);
			$this->listOptions();
		}
	}
	
	/**
	 * Write the CrudIgniter welcome message
	 * 
	 * @since 1.0
	 * @access public
	 * @return void
	 */
	public function welcome()
	{
		ConsoleIgniter::write('');
		ConsoleIgniter::write('****************************************************************');
		ConsoleIgniter::write('************************* CRUD IGNITER *************************');
		ConsoleIgniter::write('*********************** IGNITE YOUR CRUD ***********************');
		ConsoleIgniter::write('****************************************************************');
		ConsoleIgniter::line();
		ConsoleIgniter::write('');
	}

	/**
	 * Write the CrudIgniter help message
	 * 
	 * @since 1.0
	 * @access public
	 * @return void
	 */
	public function help()
	{
		ConsoleIgniter::write('');
		ConsoleIgniter::write('To use CrudIgniter type "php ci projectName"');
		ConsoleIgniter::bye();
	}
	
	/**
	 * List the CrudIgniter options
	 * 
	 * @since 1.0
	 * @access public
	 * @return void
	 */
	public function listOptions()
	{
		$result = ConsoleIgniter::writeQuestion('What do you want to generate?', array('MODEL', 'VIEW', 'CONTROLLER', 'EXIT'), 0);
		$generator = null;

		$result = strtolower($result);
		switch ($result) {
			case 0:
				if (class_exists('MY_ModelGenerator'))
					$generator = new MY_ModelGenerator();
				else
					$generator = new ModelGenerator();
			break;	
			case 1:
				if (class_exists('MY_ViewGenerator'))
					$generator = new MY_ViewGenerator();
				else
					$generator = new ViewGenerator();
			break;
			case 2:
				if (class_exists('MY_ControllerGenerator'))
					$generator = new MY_ControllerGenerator();
				else
					$generator = new ControllerGenerator();
			break;
			default:
				ConsoleIgniter::bye();
		}
		$generator->generate();
		ConsoleIgniter::bye();
	}
}