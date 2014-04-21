<?php
class encryption{
	/* contains values used the the encryption */
	function __construct($p, $q){
		$this->p = $p;
		$this->q = $q;
		$this->N = $p*$q;
		$this->M = ($p-1) * ($q-1);
	}
}
?>