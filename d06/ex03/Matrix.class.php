<?php

require_once('../ex01/Vertex.class.php');
require_once('../ex02/Vector.class.php');

class Matrix
{
	static $verbose = false;
	const TRANSLATION = 1;
	const PROJECTION = 2;
	const IDENTITY = 4;
	const SCALE = 8;
	const RX = 16;
	const RY = 32;
	const RZ = 64;
	private $_preset = 0;	// type de Matrice
	private $_scale = 0;	// si SCALE
	private $_angle = 0;	// si RX, RY ou RZ
	private $_ratio = 0;	// si PROJECTION
	private $_near = 0;		// si PROJECTION
	private $_far = 0;		// si PROJECTION
	private $_fov = 0;		// si PROJECTION
	private $_vtc = 0;		// si TRANSLATION
	private $_vtcX = 0;
	private $_vtcY = 0;
	private $_vtcZ = 0;
	private $_vtxO = 0;
	
	public static function doc()
	{
		return(file_exists('./Matrix.doc.txt') ? file_get_contents('./Matrix.doc.txt') : 'No doc');
	}
	public function __construct(array $arg)
	{
		if (!array_key_exists('preset', $arg)
			OR ($arg['preset'] & self::TRANSLATION AND !array_key_exists('vtc', $arg))
			OR ($arg['preset'] & self::SCALE AND !array_key_exists('scale', $arg))
			OR ($arg['preset'] & (self::RX | self::RY | self::RZ) AND !array_key_exists('angle', $arg))
			OR ($arg['preset'] & self::PROJECTION AND (!array_key_exists('ratio', $arg)
				OR !array_key_exists('near', $arg) OR !array_key_exists('far', $arg)
				OR !array_key_exists('fov', $arg) OR !array_key_exists('vtc', $arg))))
			return;
		$this->_preset = $arg['preset'];
		$this->_vtcX = new Vector(array( 'dest' => new Vertex(array('x' => 1, 'y' => 0, 'z' => 0))));
		$this->_vtcY = new Vector(array( 'dest' => new Vertex(array('x' => 0, 'y' => 1, 'z' => 0))));
		$this->_vtcZ = new Vector(array( 'dest' => new Vertex(array('x' => 0, 'y' => 0, 'z' => 1))));
		$this->_vtxO = new Vector(array( 'dest' => new Vertex(array('x' => 0, 'y' => 0, 'z' => 0, 'w' => 2))));
		if (array_key_exists('scale', $arg))
		{
			$this->_scale = $arg['scale'];
			$this->_vtcX = $this->_vtcX->scalarProduct( $this->scale );
			$this->_vtcY = $this->_vtcY->scalarProduct( $this->scale );
			$this->_vtcZ = $this->_vtcZ->scalarProduct( $this->scale );
		}
		if (array_key_exists('angle', $arg))
			$this->_angle = $arg['angle'];
		if (array_key_exists('ratio', $arg))
			$this->_ratio = $arg['ratio'];
		if (array_key_exists('near', $arg))
			$this->_near = $arg['near'];
		if (array_key_exists('far', $arg))
			$this->_far = $arg['far'];
		if (array_key_exists('fov', $arg))
			$this->_fov = $arg['fov'];
		if (array_key_exists('vtc', $arg))
		{
			$this->_vtc = $arg['vtc'];
			$this->_vtxO = $this->_vtxO->add( $this->_vtc );
		}
		$tab = array(1 => 'TRANSLATION', 2 => 'PROJECTION', 4 => 'IDENTITY', 8 => 'SCALE', 16 => 'Ox ROTATION', 32 => 'Oy ROTATION', 64 => 'Oz ROTATION');
		if (self::$verbose === true)
			printf("Matrix %s%s intance constructed\n", $tab[$this->_preset], $this->_preset & self::IDENTITY ? '' : ' preset');
	}
	public function __get( $att )
	{
		$att = '_'.$att;
		return($this->$att);
	}
	public function __toString()
	{
		$line0 = "M | vtcX | vtcY | vtcZ | vtxO\n-----------------------------\n";
		$lineX = sprintf("x | %.2f | %.2f | %.2f | %.2f\n", $this->_vtcX->x, $this->_vtcY->x, $this->_vtcZ->x, $this->_vtxO->x);
		$lineY = sprintf("y | %.2f | %.2f | %.2f | %.2f\n", $this->_vtcX->y, $this->_vtcY->y, $this->_vtcZ->y, $this->_vtxO->y);
		$lineZ = sprintf("z | %.2f | %.2f | %.2f | %.2f\n", $this->_vtcX->z, $this->_vtcY->z, $this->_vtcZ->z, $this->_vtxO->z);
		$lineW = sprintf("w | %.2f | %.2f | %.2f | %.2f\n", $this->_vtcX->w, $this->_vtcY->w, $this->_vtcZ->w, $this->_vtxO->w);
		return($line0.$lineX.$lineY.$lineZ.$lineW);
	}
	public function __destruct()
	{
		if (self::$verbose === true)
			print('Matrix instance destructed'."\n");
	}
}

Vertex::$verbose = False;
Vector::$verbose = False;

// print( Matrix::doc() );
	// Vertex::$verbose = True;
	// Vector::$verbose = True;
Matrix::$verbose = True;

print( 'Let\'s start with an harmless identity matrix :' . PHP_EOL );
$I = new Matrix( array( 'preset' => Matrix::IDENTITY ) );
print( $I . PHP_EOL . PHP_EOL );

print( 'So far, so good. Let\'s create a translation matrix now.' . PHP_EOL );
$vtx = new Vertex( array( 'x' => 20.0, 'y' => 20.0, 'z' => 0.0 ) );
$vtc = new Vector( array( 'dest' => $vtx ) );
$T  = new Matrix( array( 'preset' => Matrix::TRANSLATION, 'vtc' => $vtc ) );
print( $T . PHP_EOL . PHP_EOL );

print( 'A scale matrix is no big deal.' . PHP_EOL );
$S  = new Matrix( array( 'preset' => Matrix::SCALE, 'scale' => 10.0 ) );
print( $S . PHP_EOL . PHP_EOL );

print("\n");

// print( 'A Rotation along the OX axis :' . PHP_EOL );
// $RX = new Matrix( array( 'preset' => Matrix::RX, 'angle' => M_PI_4 ) );
// print( $RX . PHP_EOL . PHP_EOL );

// print( 'Or along the OY axis :' . PHP_EOL );
// $RY = new Matrix( array( 'preset' => Matrix::RY, 'angle' => M_PI_2 ) );
// print( $RY . PHP_EOL . PHP_EOL );

// print( 'Do a barrel roll !' . PHP_EOL );
// $RZ = new Matrix( array( 'preset' => Matrix::RZ, 'angle' => 2 * M_PI ) );
// print( $RZ . PHP_EOL . PHP_EOL );

// print( 'The bad guy now, the projection matrix : 3D to 2D !' . PHP_EOL );
// print( 'The values are arbitray. We\'ll decipher them in the next exercice.' . PHP_EOL );
// $P = new Matrix( array( 'preset' => Matrix::PROJECTION,
// 						'fov' => 60,
// 						'ratio' => 640/480,
// 						'near' => 1.0,
// 						'far' => -50.0 ) );
// print( $P . PHP_EOL . PHP_EOL );

// print( 'Matrices are so awesome, that they can be combined !' . PHP_EOL );
// print( 'This is a model matrix that scales, then rotates around OY axis,' . PHP_EOL );
// print( 'then rotates around OX axis and finally translates.' . PHP_EOL );
// print( 'Please note the reverse operations order. It\'s not an error.' . PHP_EOL );
// $M = $T->mult( $RX )->mult( $RY )->mult( $S );
// print( $M . PHP_EOL . PHP_EOL );

// print( 'What can you do with a matrix and a vertex ?' . PHP_EOL );
// $vtxA = new Vertex( array( 'x' => 1.0, 'y' => 1.0, 'z' => 0.0 ) );
// print( $vtxA . PHP_EOL );
// print( $M . PHP_EOL );
// print( 'Transform the damn vertex !' . PHP_EOL );
// $vtxB = $M->transformVertex( $vtxA );
// print( $vtxB . PHP_EOL . PHP_EOL );

?>
