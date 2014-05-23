<?php

/***************************************************************
*  Copyright notice
*  
*  (c) 2010 Chi Hoang (info@chihoang.de)
*  All rights reserved
*
***************************************************************/

require_once("pat.php");

define("NUMBER_OF_LETTERS_IN_ALPHABET","26");				//number of letters in the alphabet
define("MAX_KEY_BITS","128");								//if you change the key type you need to change this to 
															//the number of bits in that type or if you use a machine 
															//that is not 32 bit
define("EMPTY_NODE","0");									//like null
define("START_BIT_COUNT","0");								//starts the key splitting level (check the zero bit for 1 or 0 first)
define("END_OF_STRING","\0");
define("PAD", decbin(128));

//you could have an instruction of the letter that is represented by 1, so the max number of bits
//the plus one is for the end of string, just in case we really do have all e's		
define("MAX_STRING_FOR_KEY", MAX_KEY_BITS+1);

///////////////////////////////////////////////////////////////////////////////////////////
//PURPOSE::: the data that is associated with a key, you can store anything in this 
//:::::::::: class that you want to link to your search key
//:::::::::: 
//:::::::::: 
//:::::::::: 
//NOTES::::: use polymorphism and make your own class or just edit this one....
//:::::::::: 
//:::::::::: 
///////////////////////////////////////////////////////////////////////////////////////////
class PayloadC extends PatriciaTrieCSub
{
	var $payload;
	
	public function __construct($string) {
		$this->payload = $string;
	}
	
	public function fetch() {
		echo $this->payload;
	}
	
	public function error() {
		echo "Not Found!";
	}
};

///////////////////////////////////////////////////////////////////////////////////////////
//PURPOSE::: every node in the tree is a collection of either left and right links
//:::::::::: or the payload and key. the key has to be stored to check that the text is
//:::::::::: correct, if you want a mud deal where you could type the letter t for 
//:::::::::: tell, then you do not need to store the key and could take the full check out
//:::::::::: of the code
//:::::::::: 
//:::::::::: 
//NOTES::::: a node will either store links to nodes or the payload
//:::::::::: 
//:::::::::: 
///////////////////////////////////////////////////////////////////////////////////////////
class PatriciaNodeC 
{
	var $payload;
	var $key;
		//remember if we are a leaf or not
	var $is_leaf;
		//we are either internal or a leaf (we can overlap the data to save space)
	var $left;
	var $right;
			
		//if payload is given, then create a leaf
	public function __construct ($_payload=null, $_key=null) { 
		
		if  ($_payload == null && $_key == null) {
			$this->left = EMPTY_NODE; 
			$this->right = EMPTY_NODE; 
			$this->is_leaf = false; 
		} else {
			$this->payload = $_payload; 
			$this->key = $_key; 
			$this->is_leaf = true; 
		}
	}
	
	public function __unset($name) {
		echo "$name";
	}
}

///////////////////////////////////////////////////////////////////////////////////////////
//PURPOSE::: to store strings of text and associate that text with a container class. 
//:::::::::: 
//:::::::::: 
//:::::::::: 
//:::::::::: 
//NOTES::::: odd numbers are on the right
//:::::::::: even on the left
//:::::::::: and so on... (2, 4, 8) multiples of 2 break it down
///////////////////////////////////////////////////////////////////////////////////////////
class PatriciaTrieC extends PayloadC
{
			//the root node of the PAT trie
		var $head;
		
		function IsBitOn ($_key, $_bp) { 
			//~ echo "k:".decbin($_key).">>".$_bp."\n";
			return (($_key >>= $_bp) & 1); 
		}
		
		public function __construct()	{ 
			$this->head = new PatriciaNodeC();
		}

		public function Insert ($_key) {
			return ($this->insertSub ($this->head, new payloadC($_key), $this->BuildKey ($_key), START_BIT_COUNT) != EMPTY_NODE);
		}
		//***********************************************************************************

		//***********************************************************************************
		public function Search ($_key) {
			return $this->searchSub ($this->head, $this->BuildKey ($_key), START_BIT_COUNT); 
		}
		
		//***********************************************************************************

		//***********************************************************************************
		public function Remove ($_key)
		{	return $this->removeSub($this->head, $this->BuildKey ($_key), START_BIT_COUNT); }
		//***********************************************************************************

		//***********************************************************************************
		
		public function Clear ()
		{ $this->clear ($head); $this->head = EMPTY_NODE; }
		//***********************************************************************************
		
		public function varDump () {
			var_dump($this);
		}
}
?>