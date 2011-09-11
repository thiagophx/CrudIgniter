<?php
/**
 * Get database informations (tables, fields, etc)
 * 
 * @author Thiago Rigo <thiagophx@gmail.com>
 * @since 1.0
 * @package crudigniter
 * @subpackage generator
 */
abstract class Generator
{
	/**
	 * The database's tables
	 * 
	 * @since 1.0
	 * @access protected
	 * @var array
	 */
	protected $tables = array();
	
	/**
	 * The database configuration's items
	 * 
	 * @since 1.0
	 * @access private
	 * @var array
	 */
	private $db;
	
	/**
	 * PDO object
	 * 
	 * @since 1.0
	 * @access private
	 * @var PDO
	 */
	private $pdo = null;
	
	/**
	 * The name of the used layer
	 * 
	 * @since 1.0
	 * @access protected
	 * @var string
	 */
	protected $layer;
	
	/**
	 * The number of the choosed layer (Table)
	 * 
	 * @since 1.0
	 * @access protected
	 * @var int
	 */
	protected $choosedLayer;
	
	/**
	 * Initialize the class, read the database
	 * configurations file, read the tables
	 * and list the options
	 * 
	 * @since 1.0
	 * @access public
	 * @param string $layer the name of the layer (Model, View or Controller)
	 * @return void
	 */
	public function __construct($layer)
	{
		$this->layer = $layer;
		$this->loadDbConfig();
		$this->readTables();
		$this->listOptions();
	}
	
	/**
	 * Read the database's configuration file
	 * 
	 * @since 1.0
	 * @access private
	 * @param $item the item's name
	 * @return string
	 */
	private function loadDbConfig()
	{
		if (empty($this->db)) {
			require PROJECTS_PATH . DS . ProjectIgniter::getName() . DS . 'db.php';
			
			if ( ($db == null) || (empty($db)) )
				return false;

			$this->db = $db;
		}
	}	
	
	/**
	 * If not exists, create a connection with the database
	 * 
	 * @since 1.0
	 * @access private
	 * @return void
	 */
	private function connect()
	{
		if ($this->pdo != null)
			return;
		
		$driver 	= $this->db['dbdriver'];
		$username 	= $this->db['username'];
		$password 	= $this->db['password'];
		$host 		= $this->db['hostname'];
		$database 	= $this->db['database'];

		try {
			switch ($driver) {
				case 'mysql':
					$this->pdo = new PDO("mysql:host={$host};dbname={$database}", $username, $password);
					$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				break;
			}
		} catch (PDOException $e) {
			ConsoleIgniter::write('ERROR: ' . $e->getMessage());
			ConsoleIgniter::bye();
		}
	}
	
	/**
	 * Reads the database's tables
	 * 
	 * @since 1.0
	 * @access protected
	 * @final
	 * @return void
	 */
	protected final function readTables()
	{
		if (! empty($this->tables))
			return;
		
		$this->connect();
		$database = $this->db['database'];
		
		try {
			$result = $this->pdo->query('SHOW TABLES');
			
			while ($row = $result->fetch(PDO::FETCH_ASSOC))
			    $this->tables[] = array('Name' => $row['Tables_in_' . $database]);

		} catch (PDOException $e) {
			ConsoleIgniter::write('ERROR: ' . $e->getMessage());
			ConsoleIgniter::bye();
		}
	}
	
	/**
	 * Read the fields of a table
	 * 
	 * @since 1.0
	 * @access protected
	 * @final
	 * @param int $tableNumber the table's number
	 * @return void
	 */
	protected final function readFields($tableNumber)
	{
		if ( isset($this->tables[$tableNumber]['Primary']) && isset($this->tables[$tableNumber]['Fields']) )
			return;
		
		$this->connect();
		
		try {
			$result = $this->pdo->query('DESC ' . $this->tables[$tableNumber]['Name']);
			
			while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
				if ($row['Key'] == 'PRI')
		    		$this->tables[$tableNumber]['Primary'] = $row;
				else
					$this->tables[$tableNumber]['Fields'][] = $row;
			}
		} catch (PDOException $e) {
			ConsoleIgniter::write('ERROR: ' . $e->getMessage());
			ConsoleIgniter::bye();
		}
	}

	/**
	 * List possible Models, Views or Controllers
	 * 
	 * @since 1.0
	 * @access public
	 * @return void
	 */
	public function listOptions()
	{
		$this->choosedLayer =  ConsoleIgniter::writeQuestion('What ' . $this->layer . ' do you want to generate?', $this->tables);
	}
	
	/**
	 * Parse the template
	 * 
	 * @since 1.0
	 * @access public
	 * @param string $template the template to parse
	 * @return string
	 */
	public function getTemplate($template = null)
	{
		if ($template == null) {
			$templatePath = TEMPLATES_PATH . DS . strtolower($this->layer . 's') . DS . strtolower($this->layer) . '.php';
		} else {
			$templatePath = TEMPLATES_PATH . DS . strtolower($this->layer . 's') . DS . $template . '.php';
		}
			
		if (! file_exists($templatePath)) {
			ConsoleIgniter::write('ERROR!');
			ConsoleIgniter::write('Template: "' . $templatePath . '" not found!');
			return false;
		}
		
		$this->readFields($this->choosedLayer);
		$table = $this->tables[$this->choosedLayer];

		ob_start();	
		require $templatePath;
		
		$template = ob_get_clean();
		
		$template = str_ireplace(array('<php>', '</php>'), array('<?php', '?>'), $template);
		return $template;
	}
	
	/**
	 * Verify if a file can be overrided
	 * 
	 * @since 1.0
	 * @access protected
	 * @param string $file the file to verify
	 * @return boolean
	 */
	protected function overrideFile($file)
	{
		if (file_exists($file)) {
			$wannaOverride = ConsoleIgniter::writeQuestion('The file ' . $file . ' already exists, do you want to override?', array('y', 'n'), 0);
			if ($wannaOverride == 0)
				return true;
			else
				return false;
		}
		return true;
	}
	
	/**
	 * Generate the layer's files
	 * 
	 * @since 1.0
	 * @access public
	 * @abstract
	 * @return void
	 */
	public abstract function generate();
	
}