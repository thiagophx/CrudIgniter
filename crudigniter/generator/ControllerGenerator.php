<?php
/**
 * Generates the controller
 * 
 * @author Thiago Rigo <thiagophx@gmail.com>
 * @since 1.0
 * @package crudigniter
 * @subpackage generator
 */
class ControllerGenerator extends Generator
{
	/**
	 * Validation types
	 * 
	 * @since 1.0
	 * @access private
	 * @var array
	 */
	private $validationTypes = array();
	
	/**
	 * Constructor
	 *
	 * @see crudigniter/generator/Generator#__construct()
	 */
	public function __construct()
	{
		parent::__construct('Controller');
		
		$this->validate();
		$this->cache();
		$this->profile();
	}

	/**
	 * Ask if the user wanna validate the form fields
	 * 
	 * @since 1.0
	 * @access private
	 * @return void
	 */
	private function validate()
	{
		$wannaValidate = ConsoleIgniter::writeQuestion('Do you want to supply validation rules for the fields?', array('y', 'n'), 0);
		
		if ($wannaValidate == 0)
			$this->validateFields();
	}

	/**
	 * Validate form fields
	 * 
	 * List all fields in the selected table and
	 * show validate options for each field
	 * 
	 * @since 1.0
	 * @access private
	 * @return void
	 */
	private function validateFields()
	{
		$this->readFields($this->choosedLayer);
		$this->loadValidationTypes();
		$table = $this->tables[$this->choosedLayer];

		foreach ($table['Fields'] as $key => $field) {
			ConsoleIgniter::line();
			ConsoleIgniter::write('Field: ' . $field['Field'] . ' Type: ' . $field['Type']);
			ConsoleIgniter::line();

			$validate = '';
			while ($validate === '') {
				$validate = ConsoleIgniter::writeQuestion('Choose a number', $this->validationTypes, 0, false, true, true);
				
				if (strstr($validate, ',') !== false) {
					if (! preg_match('/^([23456789]{1}[\d]*,|[01]{1}[\d]+,)+([23456789]{1}[\d]*|[01]{1}[\d]+)$/', $validate)) {
						ConsoleIgniter::write('The numbers 1 and 2 cannot be part of multiple rules.');
						$validate = '';
					}
				}
			}
			
			// This field don't need to be validated
			if ($validate != 0) {
				$this->setValidationField($this->tables[$this->choosedLayer]['Fields'][$key], $validate);
				$this->tables[$this->choosedLayer]['Validate'] = true;
			}
		}
		
		if (isset($this->tables[$this->choosedLayer]['Validate']))
			$this->getHumanNames();
	}

	/**
	 * Loads the validation file
	 * 
	 * All the validation types in the file,
	 * will be available in $this->validationTypes
	 * 
	 * @since 1.0
	 * @access private
	 * @return void
	 */
	private function loadValidationTypes()
	{
		if (! empty($this->validationTypes))
			return;

		if (! file_exists(VALIDATION_PATH . DS . 'ValidationTypes.php')) {
			ConsoleIgniter::write('ERROR');
			ConsoleIgniter::write('The validation file was not found!');
			ConsoleIgniter::bye();
		}
		
		require VALIDATION_PATH . DS . 'ValidationTypes.php';
		
		$this->validationTypes = $ValidationTypes;
	}
	
	/**
	 * Call the correct validation method
	 * 
	 * If was selected to type your own validation rule,
	 * or a predefined rule, or even concatenate the options
	 * 
	 * @since 1.0
	 * @access private
	 * @param array $field the field that will be validated
	 * @param mixed $rule the rule you want to apply (string or int)
	 * @return void
	 */
	private function setValidationField(&$field, $rule)
	{
		if ($rule == 1)
			$this->typedRule($field);
		elseif (preg_match('/^[0-9]+$/', $rule))
			$this->preDefRule($field, $rule);
		else
			$this->concatRule($field, $rule);
	}
	
	/**
	 * Set the typed rule to the passed field
	 * 
	 * @since 1.0
	 * @access private
	 * @param array $field the field that will be validated
	 * @return void
	 */
	private function typedRule(&$field)
	{
		$field['ValidateRule'] = ConsoleIgniter::writeQuestion('Type the rule.');
	}

	/**
	 * Set the predefined rule to the passed field
	 * 
	 * If the rule has parameters, ask for them,
	 * if not, set the rule to the field
	 * 
	 * @since 1.0
	 * @access private
	 * @param array $field the field that will be validated
	 * @param mixed $rule the rule you want to apply (string or int)
	 * @param bool $return if you want to return the rule
	 * @return string
	 */	
	private function preDefRule(&$field, $rule, $return = false)
	{
		$parameters = array();		
		if (preg_match_all('/\[%s]/', $this->validationTypes[$rule]['Rule'], $match) > 0) {
			foreach ($match[0] as $matchKey => $matchValue) {
				$parameter = '';
				while ($parameter == '') {
					$parameter = ConsoleIgniter::writeQuestion('Rule ' . $this->validationTypes[$rule]['Name'] . ' parameter ' . ++$matchKey . ': ');
					if ($parameter == '')
						ConsoleIgniter::write('Type the value of the parameter.');
				}
				$parameters[] = $parameter;
			}
		}
		if ($return == false)
			$field['ValidateRule'] = vsprintf($this->validationTypes[$rule]['Rule'], $parameters);
		else
			return vsprintf($this->validationTypes[$rule]['Rule'], $parameters);
	}
	
	/**
	 * Set the concatenate rule to the passed field
	 * 
	 * Break the rule, check if each breaked part has
	 * parameters and create a valid rule.
	 * 
	 * @since 1.0
	 * @access private
	 * @param array $field the field that will be validated
	 * @param string $rule the rule you want to apply
	 * @return void
	 */
	private function concatRule(&$field, $rule)
	{
		$rules = explode(',', $rule);
		$rule = '';
		foreach ($rules as $ruleNumber) {
			$rule .= $this->preDefRule($field, $ruleNumber, true) . '|';
		}
		$field['ValidateRule'] = substr($rule, 0, -1);
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
			$this->humanName($this->tables[$this->choosedLayer]['Fields'][$i]);
	}
	
	/**
	 * Ask if the user wanna cache the pages
	 * 
	 * @since 1.0
	 * @access private
	 * @return void
	 */
	private function cache()
	{
		$wannaCache = ConsoleIgniter::writeQuestion('Do you want to use cache?', array('y', 'n'), 1);
		if ($wannaCache == 0) {
			$minutes = (int)ConsoleIgniter::writeQuestion('How many minutes?', null, 10);
			$this->tables[$this->choosedLayer]['Cache'] = $minutes;
		}
	}
	
	/**
	 * Ask if the user wanna profile the application
	 * 
	 * @since 1.0
	 * @access private
	 * @return void
	 */
	private function profile()
	{
		$wannaProfile = ConsoleIgniter::writeQuestion('Do you want to do a profile?', array('y', 'n'), 1);
		if ($wannaProfile == 0)
			$this->tables[$this->choosedLayer]['Profile'] = true;
	}
	
	/**
	 * Generates the controller's file
	 * 
	 * @see crudigniter/generator/Generator#generate()
	 */
	public function generate()
	{
		$controller = ProjectIgniter::getName() . DS . 'application' . DS . strtolower($this->layer . 's') . DS . strtolower($this->tables[$this->choosedLayer]['Name']) . '.php';
		$content = parent::getTemplate();
		
		if ($content === false) {
			ConsoleIgniter::write($this->layer . ' ' . $controller . ' was not created!');
		} else {		
			if ($this->overrideFile(PROJECTS_PATH . DS . $controller)) {
				file_put_contents(PROJECTS_PATH . DS . $controller, $content);
				ConsoleIgniter::write($this->layer . ' ' . $controller . ' was successfully created!');
			} else {
				ConsoleIgniter::write($this->layer . ' ' . $controller . ' was not created!');
			}
		}
	}
}