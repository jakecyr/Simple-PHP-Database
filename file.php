<?php
class File{
	private $file;

	function __construct($filePath=null){
		$this->file = $filePath;
	}
	public function read(){
		$handle = fopen($this->file, 'r');
		$fileSize = filesize($this->file);

		if($fileSize == 0){
			return '';
		}

		$data = fread($handle, $fileSize);
		fclose($handle);
		return $data;
	}
	public function create($data=null){
		$handle = fopen($this->file, 'w');
		
		if(!is_null($data)){
			fwrite($handle, $data);
		}

		fclose($handle);
	}
	public function write($data){
		$handle = fopen($this->file, 'w') or die('Cannot open file:  '.$this->file);
		fwrite($handle, $data);
		fclose($handle);
	}
	public function append($data){
		$handle = fopen($this->file, 'a') or die('Cannot open file:  '.$this->file);
		fwrite($handle, "\n" . $data);
		fclose($handle);
	}
	public function delete(){
		unlink($this->file);
	}
}
?>
