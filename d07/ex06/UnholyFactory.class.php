<?php

class UnholyFactory
{
	private $team = array();

	function absorb( $soldier )
	{
		if (!$soldier OR !($soldier instanceof Fighter))
			return(print("(Factory can't absorb this, it's not a fighter)\n"));
		elseif ($this->team[$soldier->type])
			return(print("(Factory already absorbed a fighter of type ".$soldier->type.")\n"));
		$this->team[$soldier->type] = $soldier;
		return(print("(Factory absorbed a fighter of type ".$soldier->type.")\n"));
	}
	function fabricate( $request )
	{
		if ($this->team[$request]) {
			print("(Factory fabricates a fighter of type ".$request.")\n");
			return($this->team[$request]);
		}
		print("(Factory hasn't absorbed any fighter of type ".$request.")\n");
	}
}

?>
