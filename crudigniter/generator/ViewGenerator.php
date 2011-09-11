<?php
/**
 * Generates the view
 * 
 * @author Thiago Rigo <thiagophx@gmail.com>
 * @since 1.0
 * @package crudigniter
 * @subpackage generator
 */
class ViewGenerator extends Generator
{
	/**
	 * The views found in the template's directory
	 * 
	 * @since 1.0
	 * @access private
	 * @var array
	 */
	private $views = array();
	
	/**
	 * Constructor
	 *
	 * @see crudigniter/generator/Generator#__construct()
	 */
	public function __construct()
	{
		parent::__construct('View');
		$this->listViews();
		$this->hasValidation();
	}
	
	/**
	 * List the templates of view
	 * 
	 * @since 1.0
	 * @access private
	 * @return void
	 */
	private function listViews()
	{
		$this->loadViews();
		
		$view = ConsoleIgniter::writeQuestion('What templates do you want to generate?', $this->views, 0, false, true, true);		
		$this->addView($view);
	}
	
	/**
	 * Read all the template files in the directory
	 * 
	 * @since 1.0
	 * @access private
	 * @return void
	 */
	private function loadViews()
	{
		if (! empty($this->views))
			return;
		
		$this->views = array('CRUD(add, edit, index)');
		
		$templates = scandir(TEMPLATES_PATH . DS . 'views' . DS);
		foreach ($templates as $template) {
			if (preg_match('/^.+\.php$/i', $template)) {
				
				// If isn't the CRUD template
				if ( ($template != 'add.php') && ($template != 'edit.php') && ($template != 'index.php') )
					$this->views[] = substr($template, 0, strrpos($template, '.'));
			}
		}
	}
	
	/**
	 * Add a view template to the tables array
	 * 
	 * If the template is the CRUD template,
	 * add all the add, edit and index templates
	 * 
	 * @since 1.0
	 * @access private
	 * @param mixed $views the number of the view's template
	 * @return void
	 */
	private function addView($views)
	{
		if (! preg_match('/^[0-9]+$/', $views))
			$views = explode(',', $views);
		else
			$views = array($views);

		foreach ($views as $view) {
			if ($view == 0) {
				$this->tables[$this->choosedLayer]['Views'][] = 'add';
				$this->tables[$this->choosedLayer]['Views'][] = 'edit';
				$this->tables[$this->choosedLayer]['Views'][] = 'index';
			} else {
				$this->tables[$this->choosedLayer]['Views'][] = $this->views[$view];
			}
		}
	}
	
	/**
	 * Verify if the controller's fields has validations
	 * 
	 * @since 1.0
	 * @access private
	 * @return void
	 */
	private function hasValidation()
	{
		$this->readFields($this->choosedLayer);
		
		// Read the controller to get the validate rules if it exists
		$controller = ProjectIgniter::getName() . DS . 'application' . DS . 'controllers' . DS . strtolower($this->tables[$this->choosedLayer]['Name']) . '.php';
		if (! file_exists(PROJECTS_PATH . DS . $controller)) {
			ConsoleIgniter::write('Controller ' . $controller . ' not found.');
			ConsoleIgniter::bye();
		}
		$controller = file_get_contents(PROJECTS_PATH . DS . $controller);
		
		// Has rules to validate?
		if (preg_match_all('/\$this->form_validation->set_rules\(.+\)/', $controller, $rules)) {
			$this->tables[$this->choosedLayer]['Validate'] = true;

			foreach ($rules[0] as $rule) {
				if (preg_match_all('/(?:\'|"){1}.+(?:\'|"){1}/i', $rule, $parameters)) {
					$parameters = eval("return ViewGenerator::getParameters({$parameters[0][0]});");

					$fieldName = $parameters[0];
					$fieldHumanName = $parameters[1];
					
					foreach ($this->tables[$this->choosedLayer]['Fields'] as $key => $field) {
						if ($field['Field'] == $fieldName) {
							$this->tables[$this->choosedLayer]['Fields'][$key]['Name'] = $fieldHumanName;
							
							if (isset($parameters[2]))
								$this->tables[$this->choosedLayer]['Fields'][$key]['Validate'] = true;

							break;
						}
					}
				}
			}
		}
		
		// To add the humanName even if the field doesn't has validation rules
		$this->getHumanNames();
	}
	
	/**
	 * Ask for the field's human name
	 * 
	 * @since 1.0
	 * @access private
	 * @param array $field the field that will recive the name
	 * @return void
	 */
	private function humanName(&$field)
	{
		$field['Name'] = ConsoleIgniter::writeQuestion("What is the human name to the field {$field['Field']}?");
	}
	
	/**
	 * Ask for all the field's human name
	 * 
	 * @since 1.0
	 * @access private
	 * @return void
	 */
	private function getHumanNames()
	{
		$fields = count($this->tables[$this->choosedLayer]['Fields']);
		
		for ($i = 0; $i < $fields; $i++)
			if (! isset($this->tables[$this->choosedLayer]['Fields'][$i]['Name']))
				$this->humanName($this->tables[$this->choosedLayer]['Fields'][$i]);
				
		$this->humanName($this->tables[$this->choosedLayer]['Primary']);
	}
	
	/**
	 * Get the parameters of _set_rules in Controller
	 * 
	 * @since 1.1
	 * @access private
	 * @return array
	 * @param string A comma separated string with the parameters
	 * @static
	 */
	private static function getParameters()
	{
		return func_get_args();
	}
	
	/**
	 * Generates the view's files
	 * 
	 * @see crudigniter/generator/Generator#generate()
	 */
	public function generate()
	{
		$table = strtolower($this->tables[$this->choosedLayer]['Name']);
		if (! file_exists(PROJECTS_PATH . DS . ProjectIgniter::getName() . DS . 'application' . DS . 'views' . DS .  $table))
			mkdir(PROJECTS_PATH . DS . ProjectIgniter::getName() . DS . 'application' . DS . 'views' . DS .  $table);
		
		foreach ($this->tables[$this->choosedLayer]['Views'] as $view) {
			$content  = parent::getTemplate($view);
			$template = ProjectIgniter::getName() . DS . 'application' . DS . strtolower($this->layer . 's') . DS . $table . DS . $view . '.php';
			
			if ($content === false) {
				ConsoleIgniter::write($this->layer . ' ' . $template . ' was not created!');
			} else {		
				if ($this->overrideFile(PROJECTS_PATH . DS . $template)) {
					file_put_contents(PROJECTS_PATH . DS . $template, $content);
					ConsoleIgniter::write($this->layer . ' ' . $template . ' was successfully created!');
				} else {
					ConsoleIgniter::write($this->layer . ' ' . $template . ' was not created!');
				}
			}
		}
	}
}