<?php
/**
 * MVC App
 */

namespace Datalaere\PHPMvcFramework;

class App
{
	// object instance 
	private static $_instance = null;

	public $data;

	// singleton instance
	public static function load()
	{
		if (!isset(self::$_instance)) {
			self::$_instance = new App();
		}

		return self::$_instance;
	}

	public function set($case, $input)
	{
		return $this->data[$case] = $input;
	}

	public function get($index, $default = null)
	{
		$index = explode('.', $index);
		$data = $this->_getValue($index, $this->data);

		if ($data) {
			return $data;
		}

		return false;
	}

	/**
	* @param array      $id
	* @param int|string $position
 	* @param mixed      $value
 	*/	
	public function add($id, $value, $position = 1)
	{
		if (is_int($position)) {
   			return array_splice($this->data[$id], $position, 0, $value);
    	} else {
        $pos   = array_search($position, array_keys($this->data[$id]));

	       	return $this->data[$id] = array_merge(
	            array_slice($this->data[$id], 0, $pos),
	            $value,
	            array_slice($this->data[$id], $pos)
	        );
    	}
	}

	private function _getValue($index, $value)
	{
		if (is_array($index) && count($index)) {
			$current_index = array_shift($index);
		}

		if (is_array($index) &&
			count($index) &&
			isset($value[$current_index]) &&
			is_array($value[$current_index]) &&
			count($value[$current_index])) {
			return $this->_getValue($index, $value[$current_index]);
		} elseif (isset($value[$current_index])) {
			return $value[$current_index];
		} else {
			return false;
		}
	}
}
