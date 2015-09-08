<?php
class Log {
	private $filename;
	
	public function __construct($filename) {
		$this->filename = $filename;
	}
	
	public function write($message) {
		$file = DIR_LOGS . $this->filename;
		
		$handle = fopen($file, 'a+'); 
		
		fwrite($handle, date('Y-m-d G:i:s') . ' - ' . print_r($message, true)  . "\n");
			
		fclose($handle); 
	}
    
    public function log_paypal($message) {
		$file = DIR_LOGS . 'log_paypal.txt';
        
		$handle = fopen($file, 'a+'); 
		
		fwrite($handle, date('Y-m-d G:i:s') . ' - ' . print_r($message, true)  . "\n");
			
		fclose($handle); 
	}
    
}
?>