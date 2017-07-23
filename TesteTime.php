<?php 

	date_default_timezone_set('Brazil/East');

	function toStringDiff(DateInterval $diff){
		$unidades = ['a' => 'y', 'm' => 'm', 'd' => 'd', 'h' => 'h', 'min' => 'i', 's' => 's'];
		$partes = array_values($unidades);
		$string = '';
		foreach($partes as $parte){
			if ( $diff->$parte > 0 ){
				$unidade = array_search($parte, $unidades);
				$string = $string . ' ' . $diff->$parte . "${unidade}";
			}
		}
		return $string;
	}

	$inicio = new DateTime('2011-01-01 15:03:01');
	$fim = new DateTime('2011-01-01 17:33:40');
	$diff = $inicio->diff($fim);

	echo toStringDiff($diff);

	$time = new DateTime('NOW');
	$stringtime = $time->format('Y-m-d\TH:i:s.u');
	echo $stringtime;

 ?>