<?php

require_once('../ex00/Color.class.php');

class Vertex
{
	static $verbose = false;
	private $_x = 0;
	private $_y = 0;
	private $_z = 0;
	private $_w = 0;
	private $_color = 0;
	
	public static function doc() {
		return(file_exists('./Vertex.doc.txt') ? file_get_contents('./Vertex.doc.txt') : 'No doc');
	}
	public function __construct(array $arg) {
		if (!array_key_exists('x', $arg) OR !array_key_exists('y', $arg) OR !array_key_exists('z', $arg))
			return;
		$this->_x = $arg['x'];
		$this->_y = $arg['y'];
		$this->_z = $arg['z'];
		$this->_w = array_key_exists('w', $arg) ? $arg['w'] : 1.0;
		$this->_color = array_key_exists('color', $arg) ? $arg['color'] : new Color( array('rgb' => 0xffffff));
		if (self::$verbose === true)
			print($this.' constructed'."\n");
	}
	public function __get( $att ) {
		$att = '_'.$att;
		if (isset($this->$att))
			return($this->$att);
	}
	public function __set( $att, $value ) {
		$att = '_'.$att;
		if ($att == '_x' OR $att == '_y' OR $att == '_z' OR $att == '_w')
			$this->$att = floatval($value);
		elseif ($att == '_color')
			$this->$att = $value;
	}
	//	Retourne un string reprennant les valeurs 'x, y, z et w' de l'instance.
	public function __toString() {
		return(sprintf("Vertex( x: %.2f, y: %.2f, z:%.2f, w:%.2f%s )", $this->_x, $this->_y, $this->_z, $this->_w, self::$verbose ? ', '.$this->_color : ''));
	}
	public function __destruct() {
		if (self::$verbose === true)
			print($this.' destructed'."\n");
	}
}

?>
