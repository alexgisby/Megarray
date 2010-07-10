<?php

/**
 * Megarray is a PHP class which aims to make dealing with Arrays even simpler and easier than it already is.
 * by tying up common functionality into a single Array class, called Megarray.
 *
 * @package		Megarray
 * @author		Alex Gisby
 * @copyright	(c)2010 Alex Gisby
 * @license		MIT License
 */
	class Megarray implements Countable, Iterator, ArrayAccess
	{
		private $position 			= 0;
		private $next_numeric_idx	= 0;
		private $items 		= array();		// The actual elements.
		private $keys		= array();		// Keys are stored seperately.
		private $original	= array();		// The original, untampered with version.
		private $length 	= 0;
		
		
		/**
		 * Constructor, called when you do 'new Megarray();'
		 *
		 * @param	array 		(optional) Array to use as a base
		 * @return 	Megarray
		 */
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
		
		/**
		 * Factory method, for those who like factory pattern
		 *
		 * @param	array 		(optional) an array to build with as a default
		 * @return 	Megarray	New megarray object
		 */
		public static function factory($arr = false)
		{
			return new Megarray($arr);
		}
		
		/**
		 * Echoing out the array (echo $arr;) will print a debug
		 *
		 * @return 	string	Debug output
		 */
		public function __toString()
		{
			// Mimic print_r's functionality, loop through displaying all the elements;
			return $this->debug(false);
		}
		
		/**
		 * Prints a human readable debug
		 *
		 * @param	bool	If true, debug will echo directly, if false will just return output. Default is true.
		 * @return 	string	Debug output.
		 */
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
		
		/**
		 * Implement countable:
		 */
		public function count()		{		return $this->length;							}
		
		/**
		 * Implement Iterator:
		 */
		public function rewind()	{		$this->position = 0;							}
		public function current()	{		return $this->items[$this->position];			}	
			
		public function key()		
		{		
			return $this->keys[$this->position];
		}
		
		public function next()		{		$this->position ++;								}
		public function valid()		{		return isset($this->items[$this->position]);	}
		
		/**
		 * Implement Array Access:
		 */
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
		
		/**
		 * This function, part of the ArrayAccess interface, does a lot of the magic of Megarray,
		 * allows access to ranges of elements, as well as nth-child elements easily.
		 *
		 * @param	mixed	Offset / range to select.
		 * @return 	mixed	Null if the key can't be found, Megarray object for ranges, or a single element from the array
		 */
		public function offsetGet($offset) 
		{	
			if(is_int($offset))
			{
				// Look up this key in the keys array:
				$keypos = $this->get_key_index($offset);
				if($keypos !== false && isset($this->items[$keypos]))
				{
					return $this->items[$keypos];
				}
			}
			elseif($offset === ':last')
			{
				// Return the last element in the array:
				return $this->items[$this->length - 1];
			}
			elseif(preg_match('/[0-9]+::[0-9]+/', $offset))
			{
				$range = explode('::', $offset);
				$lower = $range[0];
				$upper = $range[1];
				
				// Ranges work on array-position, and not the index! That means if you have mixed keys, they are included in the
				// range!!!
				if($lower <= $upper && isset($this->items[$lower]))
				{
					if($lower == $upper)
					{
						return $this->items[$lower];
					}
					
					$res = new Megarray();
					for($i = $lower; $i <= $upper; $i ++)
					{
						if(isset($this->items[$i]))
						{
							$res[] = $this->items[$i];
						}
						else
						{
							break;
						}
					}
					
					return $res;
				}
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
		
		
		/**
		 * array_search has problems when the values of an array are different types, so we have to do this manually.
		 * Search for a key within the array and return the index or false if it doesn't exist.
		 *
		 * @param 	string 		search
		 * @return 	int|bool	Index of the key, or false
		 */
		private function key_search($search)
		{
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