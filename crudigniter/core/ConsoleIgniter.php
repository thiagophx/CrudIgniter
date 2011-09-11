<?php
/**
 * Provides a console API
 * 
 * @author Thiago Rigo <thiagophx@gmail.com>
 * @since 1.0
 * @package crudigniter
 * @subpackage core
 */
class ConsoleIgniter
{
	/**
	 * The Standard input stream
	 * 
	 * @var string
	 * @since 1.0
	 * @access private
	 * @static
	 */
	private static $stdin = 'php://stdin';
	
	/**
	 * The Standard output stream
	 * 
	 * @var string
	 * @since 1.0
	 * @access private
	 * @static
	 */
	private static $stdout = 'php://stdout';
	
	/**
	 * The error's messages
	 * 
	 * @var array
	 * @since 1.0
	 * @access private
	 * @static
	 */
	private static $messages = array(
		'empty' => 'Cannot be empty.',
		'invalid_number' => 'Invalid number.',
		'invalid_numbers' => 'The numbers are out of the options.',
		'invalid_format' => 'Invalid format.'
	);
	
	/**
	 * Set the empty message
	 * 
	 * @since 1.0
	 * @access public
	 * @static
	 * @param string $msg empty message
	 * @return void
	 */
	public static function setEmptyMsg($msg)
	{
		self::$messages['empty'] = $msg;
	}
	
	/**
	 * Get the empty message
	 * 
	 * @since 1.0
	 * @access public
	 * @static
	 * @return string
	 */
	public static function getEmptyMsg()
	{
		return self::$messages['empty'];
	}
	
	/**
	 * Set the invalid number message
	 * 
	 * @since 1.0
	 * @access public
	 * @static
	 * @param string $msg invalid number message
	 * @return void
	 */
	public static function setInvalidNumberMsg($msg)
	{
		self::$messages['invalid_number'] = $msg;
	}
	
	/**
	 * Get the invalid number message
	 * 
	 * @since 1.0
	 * @access public
	 * @static
	 * @return string
	 */
	public static function getInvalidNumberMsg()
	{
		return self::$messages['invalid_number'];
	}
	
	/**
	 * Set the invalid numbers message
	 * 
	 * @since 1.0
	 * @access public
	 * @static
	 * @param string $msg invalid numbers message
	 * @return void
	 */
	public static function setInvalidNumbersMsg($msg)
	{
		self::$messages['invalid_numbers'] = $msg;
	}
	
	/**
	 * Get the invalid numbers message
	 * 
	 * @since 1.0
	 * @access public
	 * @static
	 * @return string
	 */
	public static function getInvalidNumbersMsg()
	{
		return self::$messages['invalid_numbers'];
	}

	/**
	 * Set the invalid format message
	 * 
	 * @since 1.0
	 * @access public
	 * @static
	 * @param string $msg invalid format message
	 * @return void
	 */
	public static function setInvalidFormatMsg($msg)
	{
		self::$messages['invalid_format'] = $msg;
	}
	
	/**
	 * Get the invalid format message
	 * 
	 * @since 1.0
	 * @access public
	 * @static
	 * @return string
	 */
	public static function getInvalidFormatMsg()
	{
		return self::$messages['invalid_format'];
	}
	
	/**
	 * Write in console
	 * 
	 * @since 1.0
	 * @access public
	 * @static
	 * @param string $msg the text to write
	 * @param bool $newLine if wanna write a blank line after message
	 * @return void
	 */
	public static function write($msg, $newLine = true) {
		if ($newLine)
			fwrite(fopen(self::$stdout, 'w'), $msg . "\n");
		else
			fwrite(fopen(self::$stdout, 'w'), $msg);
	}

	/**
	 * Read the console input
	 * 
	 * @since 1.0
	 * @access public
	 * @static
	 * @return string
	 */
	public static function read()
	{
		return fgets(fopen(self::$stdin, 'r'));
	}

	/**
	 * Write a question in console, and wait the response
	 * 
	 * @since 1.0
	 * @access public
	 * @static
	 * @param stirng $question the question to write
	 * @param array $options an array of options
	 * @param string $default the default value
	 * @param bool $canBeEmpty if the response can be empty
	 * @param bool $validate if the response needs validation
	 * @param bool $concat if the response can be multiple options
	 * @param bool $recursive if the validation can be recursive
	 * @return mixed
	 */
	public static function writeQuestion($question, array $options = null, $default = null, $canBeEmpty = false, $validate = true, $concat = false, $recursive = true)
	{
		do {
			self::write('');
			self::write($question);
			
			if ($options != null) {
				foreach ($options as $key => $value) {
					if ( is_array($value) && isset($value['Name']) )
						self::write($key + 1 . '. ' . $value['Name']);
					else
						self::write($key + 1 . '. ' . $value);
				}
			}

			if ((string)$default !== '') {
				if ( is_numeric($default) && $options != null )
					self::write('[' . ($default + 1) . '] > ', false);
				else
					self::write('[' . $default . '] > ', false);
			} else {
				self::write('> ', false);
			}
			
			$result = trim(self::read());
			
			if ( $result === '' && $default !== null ) {
				if ( is_numeric($default) && $options != null )
					$result = $default + 1;
				else
					$result = $default;
			}
			
			if ($result === '') {
				if ($canBeEmpty) {
					return $result;
				} else {
					self::write(self::$messages['empty']);
					continue;
				}
			}
			
			if ($options == null)
				return $result;

			if ( (! $validate) && ($options != null) ) {
				if (is_numeric($result))
					return --$result;
				else
					return $result;
			}
			
			if ( $validate && ($options != null) ) {
				if (preg_match('/^[0-9]+$/', $result)) {
					if (! isset($options[$result - 1]))
						self::write(self::$messages['invalid_number']);
					else
						return --$result;
				} elseif ( $concat && (preg_match('/^([\d]+,)+[\d]+$/', $result)) ) {
					$numbers = explode(',', $result);
					$totalNumbers = count($numbers);
					
					for ($i = 0; $i < $totalNumbers; $i++) {
						if (! isset($options[--$numbers[$i]])) {
							self::write(self::$messages['invalid_numbers']);
							continue 2;
						}
					}
					return implode(',', $numbers);
				} else {
					self::write(self::$messages['invalid_format']);
				}
			}
			
		} while($recursive);
	}
	
	/**
	 * Write a line in the console
	 * 
	 * @since 1.0
	 * @access public
	 * @static
	 * @return void
	 */
	public static function line()
	{
		self::write('----------------------------------------------------------------');
	}
	
	/**
	 * Exit the CrudIgniter
	 * 
	 * @since 1.0
	 * @access public
	 * @static
	 * @return void
	 */
	public static function bye()
	{
		self::write('CrudIgniter exit.');
		exit(0);
	}
}