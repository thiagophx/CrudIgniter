<?php
/**
 * Manage the projects in CrudIgniter
 * 
 * @author Thiago Rigo <thiagophx@gmail.com>
 * @since 1.0
 * @package crudigniter
 * @subpackage core
 */
class ProjectIgniter
{
	/**
	 * The project's name
	 * 
	 * @since 1.0
	 * @access private
	 * @static
	 * @var string
	 */
	private static $name;
	
	/**
	 * Receives the name of the project and decide 
	 * what to do, create a new or use an existing
	 * 
	 * @since 1.0
	 * @access public
	 * @param string $name the project's name
	 * @return void
	 */
	public function __construct($name)
	{
		self::$name = $name;

		if (! file_exists(PROJECTS_PATH . DS . self::$name)) {
			ConsoleIgniter::write('Project not found!');
			$this->newProject();
		} else {	
			if (! file_exists(PROJECTS_PATH . DS . self::$name . DS . 'db.php')) {
				ConsoleIgniter::write('Cannot find database configurations!');
				$this->createDbConfig();
			}
		}
	}

	/**
	 * Get the projets's name
	 * 
	 * @since 1.0
	 * @access public
	 * @static
	 * @return string
	 */
	public static function getName()
	{
		return self::$name;
	}
	
	/**
	 * Create a new project
	 * 
	 * @since 1.0
	 * @access private
	 * @return void
	 */
	private function newProject()
	{
		mkdir(PROJECTS_PATH . DS . self::$name);
		mkdir(PROJECTS_PATH . DS . self::$name . DS . 'application');
		
		ConsoleIgniter::write('Creating project...');
		ConsoleIgniter::line();
		$this->createTemplate();
		
		ConsoleIgniter::write('');
		ConsoleIgniter::write('Define the database configuration...');
		ConsoleIgniter::line();		
		$this->createDbConfig();	
	}
	
	/**
	 * Create the project's folder structure
	 * 
	 * @since 1.0
	 * @access private
	 * @return void
	 */
	private function createTemplate()
	{
		$folders  = array('controllers', 'models', 'views');
		$errors   = array();
		$messages = array();

		foreach ($folders as $folder) {
			if (! mkdir(PROJECTS_PATH . DS . self::$name . DS . 'application' . DS . $folder))
				$errors[] = 'Was not possible to create the folder ' . $folder;
			else
				$messages[] = 'Folder ' . $folder . ' was successfully created';
		}

		foreach ($errors as $error)
			ConsoleIgniter::write($error);
			
		foreach ($messages as $message)
			ConsoleIgniter::write($message);
	}
	
	/**
	 * Create the project's database configurations file
	 * 
	 * @since 1.0
	 * @access private
	 * @return void
	 */
	private function createDbConfig()
	{
		//--------------------------------------------------------------------
		// DEFINE THE DATABASE CONFIGURATION
		//--------------------------------------------------------------------
		
		$db = array();		
		$driverTypes = array('mysql');
		
		$db['dbdriver'] = $driverTypes[ConsoleIgniter::writeQuestion('What is the database driver?', $driverTypes, 0)];
		$db['hostname'] = ConsoleIgniter::writeQuestion('What is the host of the database server?', null, 'localhost');
		$db['username'] = ConsoleIgniter::writeQuestion('What is the database username?', null, 'root');		
		$db['password'] = ConsoleIgniter::writeQuestion('What is the database password?', null, null, true);
		$db['database'] = ConsoleIgniter::writeQuestion('What is the name of the database?', null, 'code_igniter');
		
		//--------------------------------------------------------------------
		// SHOW THE DATABASE CONFIGURATION
		//--------------------------------------------------------------------
			
		ConsoleIgniter::write('');
		ConsoleIgniter::line();
		ConsoleIgniter::write('The following database configuration will be created.');
		ConsoleIgniter::line();
		
		ConsoleIgniter::write('Driver		: ' . $db['dbdriver']);
		ConsoleIgniter::write('Host			: ' . $db['hostname']);
		ConsoleIgniter::write('Username		: ' . $db['username']);
		ConsoleIgniter::write('Password		: ' . $db['password']);
		ConsoleIgniter::write('Database		: ' . $db['database']);
		ConsoleIgniter::line();
		
		$confirm = ConsoleIgniter::writeQuestion('The information above is correct?', array('y', 'n'), 0);
		
		if ($confirm != 0)
			ConsoleIgniter::bye();
			
		//--------------------------------------------------------------------
		// SAVE THE DATABASE CONFIGURATION
		//--------------------------------------------------------------------
		if (! file_exists(TEMPLATES_PATH . DS . 'db.php')) {
			ConsoleIgniter::write('ERROR!');
			ConsoleIgniter::write('Template: "' . TEMPLATES_PATH . DS . 'db.php" not found!');
			ConsoleIgniter::bye();
		}

		ob_start();
		require TEMPLATES_PATH . DS . 'db.php';
		
		$template = ob_get_clean();
		$template = "<?php\n" . $template;
		
		file_put_contents(PROJECTS_PATH . DS . self::$name . DS . 'db.php', $template);
		ConsoleIgniter::write('Database configuration was successfully created.');
	}
}