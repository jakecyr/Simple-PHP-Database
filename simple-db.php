require "file.php";

class SimpleDb{
	private $dataFile;

	function __construct($dataFile){
		$this->dataFile = new File($dataFile);
		if(!file_exists($dataFile)) $this->dataFile->create();
	}
	function get($searchParams=null, $json=false){
		$data = json_decode($this->dataFile->read());

		if(!is_null($searchParams)){
			$output = array();

			foreach($data as $row){
				foreach($searchParams as $key => $value){
					if(isset($row->{$key})){
						if($row->{$key} == $value){
							array_push($output, $row);
						}
					}
				}
			}

			$data = $output;
		}

		return $json ? json_encode($data) : $data;
	}
	function update($searchParams=null, $updateValues){
		$data = json_decode($this->dataFile->read());

		foreach($data as $row){
			if(!is_null($searchParams)){
				foreach($searchParams as $key => $value){
					if(isset($row->{$key})){
						if($row->{$key} == $value){
							foreach($updateValues as $updateKey => $updateValue){
								$row->{$updateKey} = $updateValue;
							}
						}
					}
				}
			} else{
				foreach($updateValues as $updateKey => $updateValue){
					$row->{$updateKey} = $updateValue;
				}
			}		
		}

		$this->dataFile->write(json_encode($data));
		return $data;
	}
	function delete($searchParams=null){
		$data = json_decode($this->dataFile->read());
		$output = array();

		if(is_null($searchParams)){
			return $this->dataFile->write('[]');
		} else{
			$output = array();

			foreach($data as $row){
				foreach($searchParams as $key => $value){
					$keep = true;

					if(isset($row->{$key})){
						if($row->{$key} == $value){
							$keep = false;
						}
					}

					if($keep){
						array_push($output, $row);
					}
				}
			}

			$this->dataFile->write(json_encode($output));
			return $output;
		}
	}
	function push($object){
		$curData = $this->get();

		if($curData == ''){
			$curData = array();
		}

		array_push($curData, $object);
		$this->dataFile->write(json_encode($curData));
	}
}
