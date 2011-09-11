<?php
/**
 * Generates the model
 * 
 * @author Thiago Rigo <thiagophx@gmail.com>
 * @since 1.0
 * @package crudigniter
 * @subpackage generator
 */
class ModelGenerator extends Generator
{
	/**
	 * Constructor
	 *
	 * @see crudigniter/generator/Generator#__construct()
	 */
	public function __construct()
	{
		parent::__construct('Model');
	}
	
	/**
	 * Generates the model's file
	 * 
	 * @see crudigniter/generator/Generator#generate()
	 */
	public function generate()
	{
		$model = ProjectIgniter::getName() . DS . 'application' . DS . strtolower($this->layer . 's') . DS . strtolower($this->tables[$this->choosedLayer]['Name']) . '_' . strtolower($this->layer) . '.php';
		$content = parent::getTemplate();
		
		if ($content === false) {
			ConsoleIgniter::write($this->layer . ' ' . $model . ' was not created!');
		} else {
			if ($this->overrideFile(PROJECTS_PATH . DS . $model)) {
				file_put_contents(PROJECTS_PATH . DS . $model, $content);
				ConsoleIgniter::write($this->layer . ' ' . $model . ' was successfully created!');
			} else {
				ConsoleIgniter::write($this->layer . ' ' . $model . ' was not created!');
			}
		}
	}
}