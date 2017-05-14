<?php 
class Table {
	
	private $db;
	private $tablename;
	private $colInfos;
	private $colNames;
	
	function __construct($db, $tablename) {
		$this->db = $db;
		$this->tablename = $tablename;	
		
		$this->colInfos = $this->db->query("SHOW columns FROM ".$this->tablename);
		
		$this->colNames = array();
		foreach($this->colInfos as $c) {
			$this->colNames[] = $c[0];
		}
	}
	
	function displayTable() { 
		$cont = '<div style="overflow-x: auto">';
		$cont.= '<table class="last-results" style="border-collapse: collapse" width="100%">';
		$cont.= '<tr>';
		foreach($this->colNames as $c) { $cont.= '<th>'.$c.'</th>'; }
		$cont.= '</tr>';
			
		foreach($this->db->query("SELECT * FROM ".$this->tablename." ORDER BY id DESC LIMIT 5") as $row) {
			$cont.= '<tr>';
			foreach($this->colNames as $c) {
				$cont.= '<td>'.mb_strimwidth($row[$c], 0, 80, "...").'</td>';
			}
			$cont.= '</tr>';
		}
		$cont.= '</table>';
		$cont.= '</div>';
		echo $cont;
	}
	
	function insert($values) {
		if(abs(count($this->colNames) -1 - count($values)) < 3) {
			
			if(isset($_POST['is_surrogate'])) {
				$_POST['is_surrogate']  = ($_POST['is_surrogate'] == "on") ? 1 : 0;
			}
			
			foreach($values as $k => $v) {
				$values[$k] = $this->db->quote($v);
			}
			
			// Construction de la requete d'insertion
			$query = "INSERT INTO ".$this->tablename." (";
			foreach($this->colNames as $c) {
				if($c != "id") {
					$query .= $c.", ";
				}
			}
			$query = substr($query, 0, -2).") VALUES (";
			foreach($this->colNames as $c) {
				if($c != "id") {
					$query .= $values[$c].", ";
				}
			}
			$query = substr($query, 0, -2).")";
			
			$this->db->exec($query);
		}
	}
}

function getSelectComponent($db, $table) {
	$id = "country_id";
	if($table == "language") $id = "language_id";
	if($table == "series_publication_type") $id = "publication_type_id";
	if($table == "story_type") $id = "type_id";
	
	$cont = '<select name="'.$id.'" id="'.$id.'">';
	foreach($db->query("SELECT * FROM ".$table." ORDER BY name ASC") as $row) { 
		$cont .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
	}
	$cont .= '</select>';
	return $cont;
}
?>