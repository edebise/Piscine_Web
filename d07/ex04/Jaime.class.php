<?php

class Jaime extends Lannister
{
	public $genre = 'male';
	
	function sleepWith ( $other ) {
		if ($this->family == $other->family AND $this->genre != $other->genre)
			return (print("With pleasure, but only in a tower in Winterfell, then.\n"));
		return (parent::sleepWith( $other ));
	}
}

?>
