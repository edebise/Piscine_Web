<?php

class NightsWatch
{
	private $team = array();

	public function recruit( $soldier ) {
		if ($soldier)
			$this->team[] = $soldier;
	}
	public function fight() {
		foreach ($this->team as $soldier)
			if ($soldier instanceof IFighter)
				$soldier->fight();
	}
}

?>
