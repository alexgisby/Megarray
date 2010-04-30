<?php

	//
	// Megarray is a PHP class which aims to make dealing with Arrays even simpler and easier than it already is.
	// by tying up common functionality into a single Array class, called Megarray.
	//
	
	class Megarray implements Countable, Iterator, ArrayAccess
	{
		private $position 			= 0;
		private $next_numeric_idx	= 0;
		private $items 		= array();		// The actual elements.
		private $keys		= array();		// Keys are stored seperately.
		private $original	= array();		// The original, untampered with version.
		private $length 	= 0;
		
		public function __construct($arr = false)
		{
			if(is_array($arr))
			{
				foreach($arr as $key => $value)
				{
					$this->keys[] 	= $key;
					$this->items[]	= $value;
				}
				$this->original = $arr;
				$this->length = count($arr);
			}
		}
		
		public function __toString()
		{
			// Mimic print_r's functionality, loop through displaying all the elements;
			return $this->debug(false);
		}
		
		public function debug($echo = true)
		{
			// Prints a human readable version of the array:
			$output	= 'Megarray Debug' . "\n";
			$output .= '==============' . "\n";
			$output .= 'Length: ' . $this->length . "\n";
			$output .= '---- Elements ----' . "\n";
			$output .= print_r($this->original, true);
			
			// Echo if the flag is set:
			if($echo){		echo $output;		}
			return $output;
		}
		
		// Implement countable:
		public function count()		{		return $this->length;							}
		
		// Implement Iterator:
		public function rewind()	{		$this->position = 0;							}
		public function current()	{		return $this->items[$this->position];			}	
			
		public function key()		
		{		
			return $this->keys[$this->position];
		}
		
		public function next()		{		$this->position ++;								}
		public function valid()		{		return isset($this->items[$this->position]);	}
		
		// Implement Array Access:
		public function offsetSet($offset, $value)	
		{	
			if($this->key_exists($offset))
			{
				// Key already exists so we're overwriting. Don't change length or anything.
				$keypos = $this->get_key_index($offset);
				unset($this->items[$keypos]);			// Be tidy, don't leak memory.
				$this->items[$keypos] 		= $value;
				$this->original[$offset]	= $value;
			}
			else
			{
				if($offset === null)
				{
					// Auto-assign it the next position in the array:
					$this->keys[] = $this->next_numeric_idx;
					$this->original[$this->next_numeric_idx] = $value;
					$this->next_numeric_idx ++;
				}
				else
				{
					if(is_numeric($offset))
					{
						// For numerics, we need to update the next_array_idx:
						$this->next_numeric_idx = $offset + 1;
					}
					
					$this->keys[] 	= $offset;
					$this->original[$offset] = $value;
				}
				
				$this->items[]	= $value;
				$this->length ++;
			}
		}
		
		public function offsetGet($offset) 
		{	
			// Look up this key in the keys array:
			$keypos = $this->get_key_index($offset);
			if($keypos !== false && isset($this->items[$keypos]))
			{
				return $this->items[$keypos];
			}
			
			return null;
		}
		
		public function offsetExists($offset)
		{
			return $this->key_exists($offset);	
		}
		
		public function offsetUnset($offset)		
		{	
			$keypos = $this->get_key_index($offset);
			unset($this->items[$keypos]);
			unset($this->keys[$keypos]);
			unset($this->original[$offset]);
			$this->length --;
		}
		
		
		private function key_search($search)
		{
			// array_search has problems when the values of an array are different types, so we have to do this
			// manually.
			foreach($this->keys as $idx => $key)
			{
				if($search === $key)
				{
					return $idx;
				}
			}
			
			return false;
		}
		
		private function get_key_index($search_key)
		{
			return $this->key_search($search_key);
		}
		
		
		public function key_exists($search_key)
		{
			return (bool) $this->key_search($search_key);
		}
		
		
	}

?>