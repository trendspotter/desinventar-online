<script language="php">
/*
  DesInventar - http://www.desinventar.org
  (c) 1999-2009 Corporacion OSSO
*/

class DIObject {
	var $session = null;
	var $sRegionId  = '';
	// Dynamic Objects Variables
	var $sTableName = 'MyTable';
	var $sPermPrefix = 'OBJECT';
	var $sFieldKeyDef = '';
	var $sFieldDef = '';

	var $oOldField;	
	var $oField;
	var $oFieldType;
	var $conn = null;
	
	public function __construct($prmSession) {
		$this->session = $prmSession;
		$this->q = $prmSession->q;
		$prmSession->sRegionId = $this->q->sRegionId;
		//$this->q = new Query($prmSession->sRegionId);
		$this->setConnection($prmSession->sRegionId);
		$num_args = func_num_args();
		if ($num_args >= 1) {
			$this->oSession = func_get_arg(0);
			if ($num_args >= 3) {
				$this->sFieldKeyDef = func_get_arg(1);
				$this->sFieldDef    = func_get_arg(2);
			}
		}
		$this->oField = array();
		$this->oFieldType=array();
		$this->createFields($this->sFieldKeyDef);
		$this->createFields($this->sFieldDef);
		$this->set('RegionId', $this->session->sRegionId);
		$LangIsoCode = 'eng';
		if ($this->q->sRegionId != 'core') {
			$LangIsoCode = $this->q->getDBInfoValue('LangIsoCode');
		}
		$this->set('LangIsoCode', $LangIsoCode);
		$this->set('RecordUpdate', gmdate('c'));
	} // constructor
	
	public function setConnection($prmDB) {
		if ($prmDB == "core") {
			$this->conn = $this->q->core;
		} else {
			$this->conn = $this->q->dreg;
		}
	}
	
	public function createFields($prmFieldDef) {
		$sFields = split(',', $prmFieldDef);
		foreach ($sFields as $sKey => $sValue) {
			$oItem = split('/', $sValue);
			$sFieldName = $oItem[0];
			$sFieldType = $oItem[1];
			$this->oFieldType[$sFieldName] = $sFieldType;
			if ($sFieldType == "STRING")   { $this->oField[$sFieldName] = "";          }
			if ($sFieldType == "TEXT")     { $this->oField[$sFieldName] = "";          }
			if ($sFieldType == "DATETIME") { $this->oField[$sFieldName] = gmdate('c'); }
			if ($sFieldType == "DATE")     { $this->oField[$sFieldName] = gmdate('Y-m-d'); }
			if ($sFieldType == "INTEGER")  { $this->oField[$sFieldName] = 0;           }
			if ($sFieldType == "DOUBLE")   { $this->oField[$sFieldName] = 0.0;         }
			if ($sFieldType == "BOOLEAN")  { $this->oField[$sFieldName] = true;        }
		}
	} // function
	
	public function get($prmKey) {
		try {
			if ($this->existField($prmKey)) {
				return $this->oField[$prmKey];
			} else {
				return '';
			}
		} catch (Exception $e) {
			showErrorMsg("Error " . $e->getMessage());
		}		
	}
	
	public function getType($prmKey) {
		try {
			return $this->oFieldType[$prmKey];
		} catch (Exception $e) {
			showErrorMsg("Error " . $e->getMessage());
		}		
	}
	
	public function set($prmKey, $prmValue) {
		$iReturn = ERR_DEFAULT_ERROR;
		if (isset($this->oField[$prmKey])) {
			$sValue = $prmValue;
			$sFieldType = $this->oFieldType[$prmKey];
			if ($sFieldType == 'STRING') {
				$sValue = trim($sValue);
			}
			if ($sFieldType == 'BOOLEAN') {
				if ($sValue . "" == "on")  { $sValue = 1; }
				if ($sValue . "" == "off") { $sValue = 0; }
				if ($sValue . "" == "")    { $sValue = 0; }
			}
			if (($sFieldType == 'INTEGER') ||
			    ($sFieldType == 'DOUBLE') ) {
				if ($sValue == "") { $sValue = 0; }
			}
			$this->oField[$prmKey] = $sValue;
			$iReturn = ERR_NO_ERROR;
		}
		return $iReturn;
	}

	public function setFromArray($prmArray) {
		foreach($prmArray as $sKey => $sValue) {
			$this->set($sKey, $sValue);
		}
	}
		
	public function getTableName() {
		return $this->sTableName;
	}
	
	public function getWhereSubQuery() {
		$i = 0;
		$sQuery = "(";
		foreach (split(',', $this->sFieldKeyDef) as $sKey => $sValue) {
			$oItem = split('/', $sValue);
			$sFieldName = $oItem[0];
			$sFieldType = $oItem[1];
			if ($i > 0) { $sQuery .= " AND "; }
			$sQuery .= $sFieldName . "=";
			if (($sFieldType == "STRING"  ) || 
			    ($sFieldType == "TEXT"    ) ||
			    ($sFieldType == "DATETIME") ) {
			    $sQuery .= "'" . $this->oField[$sFieldName] . "'";
			}
			if (($sFieldType == "INTEGER") ||
			    ($sFieldType == "DOUBLE" ) ||
			    ($sFieldType == "BOOLEAN" ) ) {
			    $sQuery .= $this->oField[$sFieldName];
			}
			$i++;
		}
		$sQuery .= ")";
		return $sQuery;
	} // function

	public function getSelectQuery() {
		$sQuery = "SELECT * FROM " . $this->getTableName();
		$sQuery .= " WHERE " . $this->getWhereSubQuery();
		return $sQuery;
	} // function

	public function getDeleteQuery() {
		$sQuery = "DELETE FROM " . $this->getTableName();
		$sQuery .= " WHERE " . $this->getWhereSubQuery();
		return $sQuery;
	} // function
	
	public function getInsertQuery() {
		$i = 0;
		$sQueryFields = "";
		$sQueryValues = "";
		foreach (split(',', $this->sFieldKeyDef) as $sKey => $sValue) {
			$oItem = split('/', $sValue);
			$sFieldName = $oItem[0];
			$sFieldType = $oItem[1];
			if ($i > 0) {
				$sQueryFields .= ",";
				$sQueryValues .= ",";
			}
			$sQueryFields .= $sFieldName;
			if (($sFieldType == "STRING"  ) || 
			    ($sFieldType == "TEXT"    ) ||
			    ($sFieldType == "DATETIME") ) {
			    $sQueryValues .= "'" . $this->oField[$sFieldName] . "'";
			}
			if (($sFieldType == "INTEGER") ||
			    ($sFieldType == "DOUBLE" ) ||
			    ($sFieldType == "BOOLEAN" ) ) {
			    $sQueryValues .= $this->oField[$sFieldName];
			}
			$i++;
		}
		$sQuery = "INSERT INTO " . $this->getTableName() . " (" . $sQueryFields . ") VALUES (" . $sQueryValues . ")";
		return $sQuery;
	} // function

	public function getUpdateQuery() {
		$i = 0;
		
		//2009-07-29 (jhcaiced) Update value in RecordUpdate
		if ($this->existField('RecordUpdate')) {
			$this->set('RecordUpdate', gmdate('c'));
		}
		
		$sQueryFields = "";
		$sQueryValues = "";
		$sQuery = "UPDATE " . $this->getTableName() . " SET ";
		foreach (split(',', $this->sFieldDef) as $sKey => $sValue) {
			$oItem = split('/', $sValue);
			$sFieldName = $oItem[0];
			$sFieldType = $oItem[1];
			if ($i > 0) {
				$sQuery .= ",";
			}
			$sQueryItem = $sFieldName . "=";
			if (($sFieldType == "STRING"  ) || 
			    ($sFieldType == "TEXT"    ) ||
			    ($sFieldType == "DATETIME") ) {
			    $sQueryItem .= "'" . $this->oField[$sFieldName] . "'";
			} elseif (($sFieldType == "INTEGER") ||
			          ($sFieldType == "DOUBLE" ) ||
			          ($sFieldType == "BOOLEAN" ) ) {
			    $sQueryItem .= $this->oField[$sFieldName];
			} else {
				print "Unknown EventType : $sFieldType ($sFieldName)<br>";
			}
			$sQuery .= $sQueryItem;
			$i++;
		}
		$sQuery .= " WHERE " . $this->getWhereSubQuery();
		return $sQuery;
	} // function
	
	public function exist() {
		$iReturn = ERR_DEFAULT_ERROR;
		$query = $this->getSelectQuery();
		foreach($this->conn->query($query) as $row) {
			$iReturn = ERR_NO_ERROR;
		} //foreach
		return $iReturn;
	} // function
	
	public function load() {
		$iReturn = ERR_OBJECT_NOT_FOUND;
		$sQuery = $this->getSelectQuery();
		try {
			foreach ($this->conn->query($sQuery) as $row) {
				$sAllFields = $this->sFieldKeyDef . "," . $this->sFieldDef;
				$sFields = split(',', $sAllFields);
				foreach ($sFields as $sKey => $sValue) {
					$oItem = split('/', $sValue);
					$sFieldName = $oItem[0];
					$sFieldType = $oItem[1];
					if (array_key_exists($sFieldName, $row)) {
						$this->set($sFieldName, $row[$sFieldName]);
					} else {
						$this->set($sFieldName, '');
					}
				}
				$iReturn = ERR_NO_ERROR;
			} // foreach
		} catch (Exception $e) {
			showErrorMsg($e->getMessage);
		}
		$this->oOldField = $this->oField;
		return $iReturn;
	} // function load
	
	public function insert($withValidate = true) {
		$iReturn = ERR_NO_ERROR;
		$bValidate = $withValidate;
		if ($withValidate) {
			$iReturn = $this->validateCreate();
			if ($iReturn > 0 ) { 
				$iReturn = $this->validateUpdate();
				$bValidate = false;
			}
		}
		if ($iReturn > 0) {
			$iReturn = $this->create($bValidate);
			if ($iReturn > 0) {
				$iReturn = $this->update($bValidate);
			}
		}
		return $iReturn;
	}

	public function delete($withValidate = true) {
		$iReturn = ERR_NO_ERROR;
		if ($withValidate) {
			$iReturn = validateDelete();
		}
		if ($iReturn > 0) {
			$sQuery = $this->getDeleteQuery();
			if ($result = $this->conn->query($sQuery)) {
				$iReturn = ERR_NO_ERROR;
			}
		}
		return $iReturn;
	} // function

	public function create($withValidate = true) {
		$iReturn = ERR_NO_ERROR;
		if ($withValidate) {
			$iReturn = $this->validateCreate();
		}
		if ($iReturn > 0) {
			$sQuery = $this->getInsertQuery();
			try {
				if ($result = $this->conn->query($sQuery)) {
					$iReturn = ERR_NO_ERROR;
				}
			} catch (PDOException $e) {
				showErrorMsg("Error " . $e->getMessage());
			}
		}
		return $iReturn;
	} // function

	public function update($withValidate = true, $withInsert = false) {
		$iReturn = ERR_NO_ERROR;
		if ($withValidate) {
			$iReturn = $this->validateUpdate();
		}
		if ($iReturn > 0) {
			$sQuery = $this->getUpdateQuery();
			try {
				if ($withInsert == true) {
					if ($this->exists() < 0) {
						$iReturn = $this->create($withValidate);
					}
				}
				if ($result = $this->conn->query($sQuery)) {
					$iReturn = ERR_NO_ERROR;
				}
			} catch (PDOException $e) {
				showErrorMsg("Error " . $e->getMessage());
			}
		}
		if ($iReturn > 0) {
			$this->oOldField = $this->oField;
		}
		return $iReturn;
	} // function

	public function validateCreate() {
		return 1;
	}	
	public function validateUpdate() {
		return 1;
	}
	
	public function validateDelete() {
		return 1;
	}

	public function validateNotNull($curReturn, $ErrCode, $FieldName) {
		$iReturn = $curReturn;
		if ($iReturn > 0) {
			$Value = $this->get($FieldName);
			$FieldType = $this->getType($FieldName);
			if ($FieldType == 'INTEGER') {
				$Value = (int)$Value;
			} else {
				if ($Value == '') {
					$iReturn = $ErrCode;
				}
			}
		}
		return $iReturn;	
	}

	public function getIdWhereQuery() {
		$sQuery = '(';
		$i = 0;
		$sFields = split(',', $this->sFieldKeyDef);
		foreach ($sFields as $sKey => $sValue) {
			$oItem = split('/', $sValue);
			$sFieldName = $oItem[0];
			$sFieldType = $oItem[1];
			$quote2 = "'";
			if ($sFieldType == 'INTEGER')  { $quote2 = ""; }
			if ($i > 0) { 
				$sQuery .= ' AND ';
			}
			$sQuery .= $sFieldName . "=" . $quote2 . $this->get($sFieldName) . $quote2;
			$i++;
		} // foreach
		$sQuery .= ')';
		return $sQuery;
	}


	public function validatePrimaryKey($curReturn, $ErrCode) {
		$iReturn = $curReturn;
		if ($iReturn > 0) {
			$quote1 = "'";
			$sQuery = "SELECT * FROM " . $this->getTableName() . " WHERE " . $this->getIdWhereQuery();
			foreach($this->conn->query($sQuery) as $row) {
				$iReturn = $ErrCode;
			}
		}
		return $iReturn;	
	}
	
	public function existField($prmField) {
		return array_key_exists($prmField, $this->oField);
	}
	
	public function validateUnique($curReturn, $ErrCode, $prmFieldName) {
		$iReturn = $curReturn;
		if ($iReturn > 0) {
			$quote1 = "'";
			if ($this->getType($prmFieldName) == 'INTEGER') { $quote1 = ""; }
			$sQuery = "SELECT * FROM " . $this->getTableName() . " WHERE " . 
				$prmFieldName . "=" . $quote1 . $this->get($prmFieldName) . $quote1;
			// Validate is LangIsoCode is defined and Modify the query when needed
			if ($this->existField('LangIsoCode')) {
				$sQuery .= " AND LangIsoCode='" . $this->get('LangIsoCode') . "'";
			}
			foreach($this->conn->query($sQuery) as $row) {
				// Check if it's me !!
				$bFound = true;
				$i = 0;
				$sFields = split(',', $this->sFieldKeyDef);
				foreach ($sFields as $sKey => $sValue) {
					if ($bFound) {
						$oItem = split('/', $sValue);
						$sFieldName = $oItem[0];
						$sFieldType = $oItem[1];
						$bFound = $row[$sFieldName] == $this->get($sFieldName);
						$i++;
					}
				} // foreach
				if ($bFound) {
					$iReturn = ERR_NO_ERROR;
				} else {
					$iReturn = $ErrCode;
				}
			}
		}
		return $iReturn;	
	}
	
	public function validateRef($curReturn, $ErrCode, $prmFieldName, $TableName, $FieldDst) {
		$iReturn = $curReturn;
		if ($iReturn > 0) {
			$quote = "'";
			if ($this->getType($prmFieldName) == 'INTEGER') {
				$quote = "";
			}
			$sQuery = "SELECT " . $FieldDst . " FROM " . $TableName . " WHERE " . $FieldDst . "=" . $quote . $this->get($prmFieldName) . $quote;
			$iReturn = $ErrCode;
			foreach($this->conn->query($sQuery) as $row) {
				$iReturn = ERR_NO_ERROR;
			}
		}
		return $iReturn;
	}

	public static function padNumber($iNumber, $iLen) {
		$sNumber = "" . $iNumber;
		while (strlen($sNumber) < $iLen) {
			$sNumber = "0" . $sNumber;
		}
		return $sNumber;
	} // function
	
	public function getFieldList() {
		$i = 0;
		$Value = '';
		foreach(array_keys($this->oField) as $Field) {
			if ($i>0) { $Value .= ','; }
			$Value .= $Field;
			$i++;
		}
		return $Value;
	}

	public function importFromCSV($cols, $values) {
		$iReturn = ERR_NO_ERROR;
		$oReturn = array();
		$oReturn['Status'] = $iReturn;
		$oReturn['Error'] = array();
		$oReturn['Warning'] = array();
		return $oReturn;
	}
} // class

</script>
