<?php

class Color
{
	static $verbose = false;
	public $red = 0;
	public $green = 0;
	public $blue = 0;
	
	public static function doc() {
		if (file_exists('./Color.doc.txt'))
			return(file_get_contents('./Color.doc.txt'));
		return('None');
	}
	private function _setAtt( $att, $value ) {
		if ($att == 'red' OR $att == 'green' OR $att == 'blue')
			$this->$att = intval($value);
	}
	public function __construct( array $arg ) {
		if (array_key_exists('rgb', $arg)) {
			$arg['rgb'] = intval($arg['rgb']);
			$this->_setAtt('red', ($arg['rgb'] >> 16) % 256);
			$this->_setAtt('green', ($arg['rgb'] >> 8) % 256);
			$this->_setAtt('blue', $arg['rgb'] % 256);
		}
		else {
			if (array_key_exists('red', $arg))
				$this->_setAtt('red', $arg['red']);
			if (array_key_exists('green', $arg))
				$this->_setAtt('green', $arg['green']);
			if (array_key_exists('blue', $arg))
				$this->_setAtt('blue', $arg['blue']);
		}
		if (self::$verbose === true)
			print($this.' constructed.'.PHP_EOL);
		return;
	}
	//	Retourne un nouvelle instance de la class Color après avoir ajouté les valeurs 'rgb' de l'instance passée en argument.
	public function add( Color $arg ) {
		if ($arg)
			return (new Color(array('red' => $this->red + $arg->red, 'green' => $this->green + $arg->green, 'blue' => $this->blue + $arg->blue)));
		return (new Color(array('red' => $this->red, 'green' => $this->green, 'blue' => $this->blue)));
	}
	//	Retourne un nouvelle instance de la class Color après avoir soustrait les valeurs 'rgb' de l'instance passée en argument.
	public function sub( Color $arg ) {
		if ($arg)
			return (new Color(array('red' => $this->red - $arg->red, 'green' => $this->green - $arg->green, 'blue' => $this->blue - $arg->blue)));
		return (new Color(array('red' => $this->red, 'green' => $this->green, 'blue' => $this->blue)));
	}
	//	Retourne un nouvelle instance de la class Color après avoir multiplié les valeurs 'rgb' par l'indice passée en argument.
	public function mult( $arg ) {
		$arg = floatval($arg);
		return (new Color(array('red' => $this->red * $arg, 'green' => $this->green * $arg, 'blue' => $this->blue * $arg)));
	}
	//	Retourne un string reprennant les valeurs 'rgb' de l'instance.
	public function __toString() {
		return(sprintf("Color( red:%4d, green:%4d, blue:%4d )", $this->red, $this->green, $this->blue));
	}
	public function __destruct() {
		if (self::$verbose === true)
			print($this->__toString().' destructed.'.PHP_EOL);
		return;
	}
}

?>
