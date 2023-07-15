<?php
	
	Class stringsmanip extends taglibrary {
		
		function dummy(){}
		
		function currency($name, $data, $pars) {
			
			if($data== ''){
				return;
			}
			
			if(str_contains($data,"del")){
				$result = $data . "<del>€</del>";
			}else{
				$result = $data . "€";
			}
			return $result;
			
		}
		
	}
	
?>