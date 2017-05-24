<?php 
class Table {
	
	private $db;
	private $tablename;
	private $colInfos;
	private $colNames;
	private $colTypes;
	private $colLength;
	
	function __construct($db, $tablename) {
		$this->db = $db;
		$this->tablename = $tablename;	
		
		$this->colInfos = $this->db->query("SHOW columns FROM ".$this->tablename);
		
		$this->colNames = array();
		$this->colTypes = array();
		
		foreach($this->colInfos as $c) {
			$exploded = explode("(", $c['Type']);
			$this->colNames[] = $c[0];
			$this->colTypes[$c[0]] = $exploded[0];
			$this->colLength[$c[0]] = substr( (count($exploded) > 1) ? $exploded[1] : "", 0, -1);
		}
	}
	
	function displayTable() { 
		$cont = '<div align="center" style="font-weight:bold; font-size: 15px; margin-bottom: 5px">The 5 last records</div>';
		$cont.= '<div style="overflow-x: auto">';
		$cont.= '<table class="last-results" style="border-collapse: collapse;" width="100%">';
		$cont.= '<tr>';
		foreach($this->colNames as $c) { $cont.= '<th>'.$c.'</th>'; }
		$cont.= '<th></th>';
		$cont.= '</tr>';
			
		foreach($this->db->query("SELECT * FROM ".$this->tablename." ORDER BY id DESC LIMIT 5") as $row) {
			$cont.= '<tr>';
			foreach($this->colNames as $c) {
				$cont.= '<td>'.mb_strimwidth($row[$c], 0, 80, "...").'</td>';
			}
			$cont.= '<td align="center" width="24px"><img class="delete" src="img/delete.png" table="'.$this->tablename.'" idx="'.$row['id'].'" /></td>';
			$cont.= '</tr>';
		}
		$cont.= '<tr><td colspan="'.(count($this->colNames)+1).'"><a href="?p=search&table='.$this->tablename.'"><div class="search-del">Search record to delete in this table</div></a></td></tr>';
		$cont.= '</table>';
		$cont.= '</div>';
		echo $cont;
	}
	
	function displayForm() {
		$form = "";
		foreach($this->colNames as $c) {
			if($c == 'id') continue;
			
			$dataType = $this->colTypes[$c];
			
			$label = str_replace('id', 'ID', str_replace('_', ' ', $c));
			$placeholder = "";
			
			if($dataType == "year") {
				$placeholder = date('Y');
			} else if($dataType == "date") {
				$placeholder = date('Y-m-d');
			} else {
				$placeholder = $dataType;
			}
			
			$form.= '<tr>'
					.'<td><label for="'.$c.'">'.$label.'</label></td><td>';
			
			$advanced_fields = array('country_id', 'language_id', 'publication_type_id', 'type_id');
			
			if(!in_array($c, $advanced_fields)) {
				switch($dataType) {
					case "text":
						$form.= '<textarea id="'.$c.'" name="'.$c.'" placeholder="text"></textarea>';
					break;
					
					default:
						$form.= '<input type="text" id="'.$c.'" name="'.$c.'" maxlength="'.$this->colLength[$c].'" placeholder="'.$placeholder.'"  />';
					break;
				}
			} else {
				$t = "";
				if($c == "country_id") $t = "country";
				else if($c == "language_id") $t = "language";
				else if($c == "publication_type_id") $t = "series_publication_type";
				else if($c == "type_id") $t = "story_type";
				
				$form .= getSelectComponent($this->db, $t);
			}
			
			$form.= '</td></tr>';
		}
		echo $form;
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