<?php

abstract class Fighter
{
	public $type = '';

	function __construct( $arg ) {
		$this->type = $arg;
	}
	abstract function fight( $arg );
}

?>
