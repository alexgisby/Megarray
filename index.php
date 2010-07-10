<pre>

<?php

	// Megarray Demo:
	require_once 'Megarray.class.php';
	
	$array = Megarray::factory(array('elem1', 'elem2', 'elem3', 'elem4'));
	echo '<h1>Starting Array</h1>';
	echo $array;
	
	echo '<h1>Range Selects</h1>';
	
	echo '<h2>First three elements 0::2</h2>';
	$result = $array['0::2'];	// Grab the first three elements.
	echo $result;
	
	echo '<h2>Second and third elements: 1::2</h2>';
	$result = $array['1::2'];	// Grab the second and third elements.
	echo $result;
	
	echo '<h2>Range from valid to out-of-bounds 0::12</h2>';
	$result = $array['0::12'];	// Grab a range, but the upper is out of bounds.
	echo $result;
	
	echo '<h2>Out of bounds range 12::13</h2>';
	$result = $array['12::13'];	// Out of bounds.
	var_dump($result);

	echo '<h2>Select 1::1 range</h2>';	
	$result = $array['1::1'];	// Select a single element with ranges.
	echo $result;
	
	echo '<h2>Bad Range</h2>';
	$result = $array['12::1'];	// Bad range.
	var_dump($result);
	
	// More fancy selects:
	echo '<h2>Selecting with :last</h2>';
	$result = $array[':last'];
	echo $result;
	
	echo '<h1>Mixed Keys</h1>';
	
	$array = Megarray::factory(array('elem1', 'idx1' => 'string indexed element', 'Normal element again'));
	echo '<h2>Starting array</h2>';
	echo $array;
	
	echo '<h2>Select all 0::2</h2>';
	$result = $array['0::2'];
	echo $result;
	
	echo '<h2>Select from second element to the twelfth (non-existant) element</h2>';
	$result = $array['1::12'];
	echo $result;
	
	echo '<h2>Using the END parameter</h2>';
	$result = $array['0::END'];
	echo $result;
	
/*	$array = new Megarray();
	$array[0] = 'Hello';
	$array[1] = 'World';
	$array['moo'] = 'Moo';
	
	echo $array;
	
	unset($array[1]);
	
	echo $array;
	
	$array[] = 'After unset';
	
	echo $array;
	
	$factoried = Megarray::factory(array('elem1', 'elem2', 'elem3'));
	echo $factoried;
	
	echo '<br /><br />DEFAULT BEHAVIOUR<br /><br />';
	
	$arr = array();
	$arr[0] = 'Hello';
	$arr[1] = 'World';
	$arr['moo'] = 'Moo';
	unset($arr[1]);
	$arr[] = 'After unset';
	print_r($arr);*/
	
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