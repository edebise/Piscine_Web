<?php

require_once('../ex01/Vertex.class.php');

class Vector
{
	static $verbose = false;
	private $_x;
	private $_y;
	private $_z;
	private $_w;
	
	public static function doc() {
		return(file_exists('./Vector.doc.txt') ? file_get_contents('./Vector.doc.txt') : 'No doc');
	}
	public function __construct(array $arg) {
		if (!array_key_exists('dest', $arg))
			return;
		$dest = $arg['dest'];
		$orig = (array_key_exists('orig', $arg) ? $arg['orig'] : new Vertex(array('x' => 0, 'y' => 0, 'z' => 0)));
		$this->_setAtt( '_x', $dest->x - $orig->x );
		$this->_setAtt( '_y', $dest->y - $orig->y );
		$this->_setAtt( '_z', $dest->z - $orig->z );
		$this->_setAtt( '_w', $dest->w - $orig->w );
		if (self::$verbose === true)
			print($this.' constructed'."\n");
		return;
	}
	public function __get( $att ) {
		$att = '_'.$att;
		return($this->$att);
	}
	//	Retourne un string reprennant les valeurs 'x, y, z et w' de l'instance.
	public function __toString() {
		return(sprintf("Vector( x:%.2f, y:%.2f, z:%.2f, w:%.2f )", $this->_x, $this->_y, $this->_z, $this->_w));
	}
	public function __destruct() {
		if (self::$verbose === true)
			print($this.' destructed'."\n");
		return;
	}
	private function _setAtt( $att, $value ) {
		if ($att == '_x' OR $att == '_y' OR $att == '_z' OR $att == '_w')
			$this->$att = floatval($value);
	}
	//	Retourne la magnitude du vecteur, autrement dit retourne la racine carrée de la somme des carrés de x, y et z.
	public function magnitude() {
		return(sqrt(pow($this->_x, 2) + pow($this->_y, 2) + pow($this->_z, 2)));
	}
	public function normalize() {
		$length = $this->magnitude();
		return( new $this(array('dest' => new Vertex(array('x' => $this->_x / $length, 'y' => $this->_y / $length, 'z' => $this->_z / $length)))));
	}
	//	Retourne un nouvelle instance de la class Vector avec (Vertex(dest) = $this + $arg) et (Vertex(origin) = 0).
	public function add( Vector $v ) {
		return( new $this(array('dest' => new Vertex(array('x' => $this->_x + $v->x, 'y' => $this->_y + $v->y, 'z' => $this->_z + $v->z, 'w' => $this->_w + $v->w)), 'orig' => new Vertex(array('x' => 0, 'y' => 0, 'z' => 0, 'w' => 0)))));
	}
	//	Retourne un nouvelle instance de la class Vector avec (Vertex(dest) = $this - $arg) et (Vertex(origin) = 0).
	public function sub( Vector $v ) {
		return( new $this(array('dest' => new Vertex(array('x' => $this->_x - $v->x, 'y' => $this->_y - $v->y, 'z' => $this->_z - $v->z, 'w' => $this->_w - $v->w)), 'orig' => new Vertex(array('x' => 0, 'y' => 0, 'z' => 0, 'w' => 0)))));
	}
	//	Retourne un nouvelle instance de la class Vector avec -x, -y et -z.
	public function opposite() {
		return( new $this(array('dest' => new Vertex(array('x' => -$this->_x, 'y' => -$this->_y, 'z' => -$this->_z)))));
	}
	//	Retourne un nouvelle instance de la class Vector avec Vertex(dest) = $this * $k.
	public function scalarProduct( $k ) {
		return( new $this(array('dest' => new Vertex(array('x' => $this->_x * $k, 'y' => $this->_y * $k, 'z' => $this->_z * $k)))));
	}
	//	Retourne la somme du produit de $this et $arg.
	public function dotProduct( Vector $v ) {
		return( $this->_x * $v->x + $this->_y * $v->y + $this->_z * $v->z );
	}
	public function cos( Vector $v ) {
		return( $this->dotProduct( $v ) / ($this->magnitude() * $v->magnitude()) );
	}
	public function crossProduct( Vector $v ) {
		return( new Vector(array('dest' => new Vertex(array('x' => $this->_y * $v->z - $this->_z * $v->y, 'y' => $this->_z * $v->x - $this->_x * $v->z, 'z' => $this->_x * $v->y - $this->_y * $v->x)))));
	}
}

?>
