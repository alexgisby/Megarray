<?php

	//
	// Megarray is a PHP class which aims to make dealing with Arrays even simpler and easier than it already is.
	// by tying up common functionality into a single Array class, called Megarray.
	//
	
	class Megarray implements Countable, Iterator, ArrayAccess
	{
		private $position 	= 0;
		private $items 		= array();
		private $length 	= 0;
		
		public function __construct($arr = false)
		{
			
		}
		
		// Implement countable:
		public function count()		{		return $this->length;							}
		
		// Implement Iterator:
		public function rewind()	{		$this->position = 0;							}
		public function current()	{		return $this->items[$this->position];			}		
		public function key()		{		return $this->position;							}
		public function next()		{		$this->position ++;								}
		public function valid()		{		return isset($this->items[$this->position]);	}
		
		// Implement Array Access:
		public function offsetSet($offset, $value)	{	$this->items[$offset] = $value;												}
		public function offsetExists($offset)		{	return isset($this->items[$offset]);										}
		public function offsetUnset($offset)		{	unset($this->items[$offset]);												}
		public function offsetGet($offset)			{	return isset($this->items[$offset])? $this->items[$offset] : null;			}
		
		
	}

?>