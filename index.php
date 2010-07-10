<pre>

<?php

	// Megarray Demo:
	require_once 'Megarray.class.php';
	
	$array = new Megarray();
	$array[0] = 'Hello';
	$array[1] = 'World';
	$array['moo'] = 'Moo';
	
	echo $array;
	
	unset($array[1]);
	
	echo $array;
	
	$array[] = 'After unset';
	
	echo $array;
	
	echo '<br /><br />DEFAULT BEHAVIOUR<br /><br />';
	
	$arr = array();
	$arr[0] = 'Hello';
	$arr[1] = 'World';
	$arr['moo'] = 'Moo';
	unset($arr[1]);
	$arr[] = 'After unset';
	print_r($arr);
	
/*	$array[2] = new Megarray();
//	$array[2][0] = 'New';
	
	$array[] = 'Anotherone';
	
	echo $array;
	
	echo '<br /><br />';
	
	// Overwrite an element:
	$array[2] = 'The object has disappeared!';
	
	echo $array;
	
	// Unset an element:
	unset($array[2]);
	
	echo $array;*/
	
	//echo $array[0] . ' ' . $array[1];
	/*
	foreach($array as $key => $value)
	{
		echo $key . ' = ' . $value . '<br />';
	}*/
	
	/*
	$a = array();
	$a[2] = 'Hello';
	$a['moo'] = 'World';
	$a[] = 'Everyone';
	
	print_r($a);*/

?>

</pre>