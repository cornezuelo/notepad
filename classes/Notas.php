<?php
//Notas CLASS
class Notas {	
	public $data;

	public $conn;
	public $error;
	
	//Construct
	public function __construct(&$DBconnection) {				
		$this->conn = $DBconnection;
		$this->clear();
	}
	//Reset positions
	public function resetPositions() {
		$col = $this->getCollection();
		$pos = count($col);
		$aux = [];
		foreach ($col as $k => $v) {
			$obj_aux = new Notas($this->conn);	
			$obj_aux->data['id'] = $v['id'];
			$obj_aux->data['pos'] = $pos;
			$obj_aux->update(); 
			$pos--;
		}
	}
	
	//Move Position
	public function movePosition($pos) {
		$max = mysqli_fetch_assoc(mysqli_query($this->conn, "SELECT max(pos) FROM notas"))['max(pos)'];		
		$prev_pos = $this->data['pos'];
		if ($pos == "up") {			
			$aux = $this->data['pos'] + 1;
			if ($aux > $max) return false;
			$this->data['pos'] = $aux;									
		}
		elseif ($pos == "down") {
			$aux = $this->data['pos'] - 1;		
			if ($aux == -1) return false;
			$this->data['pos'] = $aux;
		}		
		$obj_aux = new Notas($this->conn);		
		$obj_aux->getByPos($aux);		
		$obj_aux->data['pos'] = $prev_pos;
		$obj_aux->update();
		$this->update();
	}

	//clears Object Data
	public function clear() {
		unset($this->data);
		$this->error = 0;
	}

	//Get Object by ID
	public function getByID($strID) {
		$strSQL = "SELECT * FROM notas WHERE id ='".stripslashes(mysqli_real_escape_string($this->conn, $strID))."'";
		$this->getRecord($strSQL);
	}
	
	//Get Object by Position
	public function getByPos($strPos) {
		$strSQL = "SELECT * FROM notas WHERE pos ='".stripslashes(mysqli_real_escape_string($this->conn, $strPos))."'";
		$this->getRecord($strSQL);
	}	
	
	//Get Collection
	public function getCollection() {
		$strSQL = "SELECT * FROM notas ORDER BY pos DESC";
		$resRS = mysqli_query($this->conn, $strSQL);
		if ($resRS) {
				$array = array();
				while ($row = mysqli_fetch_assoc($resRS)) {
					foreach ($row as $k => $v) {
						if ($k == "texto") {
							$v=Encryption::decrypt($v);
						}
						$array[$row['id']][$k] = $v;
					}			
				}							
				return $array;										
		}
		else $this->error =1;
		return false;
	}

	//Get Object Data
	public function getRecord($strSQL) {
		$this->clear();
		$resRS = mysqli_query($this->conn, $strSQL);
		if ($resRS) {
			if (mysqli_num_rows($resRS) == 1) {
				$arrRS = mysqli_fetch_assoc($resRS);
				foreach ($arrRS as $k => $v) {
					if ($k == "texto") $v = Encryption::decrypt($v);
					else $this->data[$k] = $v;
				}				
			}
			else $this->error =1;
		}
		else $this->error =1;
	}

	//Update Object
	public function update() {
		$strSQL = "UPDATE notas SET";
		foreach ($this->data as $k => $v) {
			if ($k == "id") continue;
			elseif ($k == "texto") {
				$v = Encryption::encrypt($v);
			}
			$strSQL .= " ".$k." ='".mysqli_real_escape_string($this->conn, $v)."',";
		}		
		$strSQL = rtrim($strSQL,",");		
		$strSQL .= " WHERE id='".stripslashes(mysqli_real_escape_string($this->conn, $this->data['id']))."'";			
		$resResult = mysqli_query($this->conn, $strSQL);	
	}

	//Insert Object
	public function insert() {		
		(int)$max = mysqli_fetch_assoc(mysqli_query($this->conn, "SELECT max(pos) FROM notas"))['max(pos)'];		
		$this->data['pos'] = $max+1;
		$strSQL = "INSERT INTO notas (id,";
		foreach ($this->data as $k => $v) {
			if ($k == 'id') continue;			
			$strSQL .= ' '.$k.',';
		}
		$strSQL = rtrim($strSQL,',');
		$strSQL .= ") VALUES (NULL,";
		foreach ($this->data as $k => $v) {
			if ($k == "fecha") $v = date('Y-m-d H:i:s');
			elseif ($k == "texto") {
				$v = Encryption::encrypt($v);
			}
			$strSQL .= " '".mysqli_real_escape_string($this->conn,$v)."',";
		}		
		$strSQL = rtrim($strSQL,",");
		$strSQL .= ")";		
		$resRS = mysqli_query($this->conn, $strSQL);				
	}

	//Delete Object
	public function delete() {
		$strSQL = "DELETE FROM notas WHERE id='" . mysqli_real_escape_string($this->conn, $this->data['id']) . "'";
		$resRS = mysqli_query($this->conn, $strSQL);
		$this->clear();
	}
}
?>
