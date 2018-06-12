<?php

abstract class Lannister
{
	public $family = 'Lannister';
	public $genre = 'unknown';

	function sleepWith ( $other ) {
		if ($this->family == $other->family OR $this->genre == $other->genre)
			return (print("Not even if I'm drunk !\n"));
		return (print("Let's do this.\n"));
	}
}

?>
