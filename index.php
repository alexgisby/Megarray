<pre><?php

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
	$result = $array[':last'];	// Select the last element in the array:
	echo $result;
	
	echo '<h1>Mixed Keys</h1>';
	
	$array = Megarray::factory(array('elem1', 'idx1' => 'string indexed element', 'Normal element again'));
	echo '<h2>Starting array</h2>';
	echo $array;
	
	echo '<h2>Select all 0::2</h2>';
	$result = $array['0::2'];		// Select elements 0 through to 2
	echo $result;
	
	echo '<h2>Select from second element to the twelfth (non-existant) element</h2>';
	$result = $array['1::12'];		// Select from element 1 to 12 (non existent)
	echo $result;
	
	echo '<h2>Using the END parameter</h2>';
	$result = $array['0::END'];		// Select from the start to the end of the array
	echo $result;
	
	echo '<h2>Grab an element by its array position :child(3)</h2>';
	echo '<p>Important to remember that this function is 1 indexed, not zero indexed</p>';
	$result = $array[':child(3)'];		// Selects the third element of the array, regardless of index or key type:
	echo $result;
	
	echo '<h2>Grab a child element that doesn\'t exist</h2>';
	$result = $array[':child(12)'];		// Selects the twelfth element which doesn't exist.
	var_dump($result);
	
	echo '<h2>Select certain elements of the array :elements(0,2)</h2>';
	echo '<p>This is zero indexed</p>';
	$result = $array[':elements(0,2)'];	// Select elements 0 and 2 from the array (1st and third elements). Zero indexed.
	echo $result;
	
	echo '<h2>Nasty, malformed :elements(0,2,) selector</h2>';
	$result = $array[':elements(0,2,)'];	// Malformed elements selector? Not a problem!
	echo $result;
	
	echo '<h2>Testing As Array</h2>';
	var_dump($array->as_array());
	
	echo '<h1>Sorting Tests</h1>';
	
	$array = new Megarray(array(2, 5, 6, 1, 2));
	
	echo '<h2>Sort ascending</h2>';
	$array->sort_asc();
	echo $array;
	
	echo '<h2>Sort Descending</h2>';
	$array->sort_desc();
	echo $array;
	
	

?>
</pre>