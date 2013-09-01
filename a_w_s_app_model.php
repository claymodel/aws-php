<?php
class AWSAppModel extends AppModel {
	
	/**
	 * Validation for bucket names
	 * 
	 * @param 	array	$check
	 * @return	bool
	 */
	public function isValidBucketName ($check=array()) {
		
		$bucket = array_shift($check);
		
		if (
			($bucket === null || $bucket === false) ||                  // Must not be null or false
			preg_match('/[^(a-z0-9\-\.)]/', $bucket) ||                 // Must be in the lowercase Roman alphabet, period or hyphen
			!preg_match('/^([a-z]|\d)/', $bucket) ||                    // Must start with a number or letter
			!(strlen($bucket) >= 3 && strlen($bucket) <= 63) ||         // Must be between 3 and 63 characters long
			(strpos($bucket, '..') !== false) ||                        // Bucket names cannot contain two, adjacent periods
			(strpos($bucket, '-.') !== false) ||                        // Bucket names cannot contain dashes next to periods
			(strpos($bucket, '.-') !== false) ||                        // Bucket names cannot contain dashes next to periods
			preg_match('/(-|\.)$/', $bucket) ||                         // Bucket names should not end with a dash or period
			preg_match('/^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$/', $bucket)    // Must not be formatted as an IP address
		) {
			return false;
		}
		
		return true;
		
	}
	
	/**
	 * beforeSave
	 *
	 * @param 	array	$options
	 * @return 	bool
	 */
	public function beforeSave ($options=array()) {
		
		$this->_tmp_schema = $this->_schema;
		foreach ($this->_tmp_schema as $field => $properties) {
			if (!empty($properties['type']) && in_array($properties['type'], array('date', 'datetime'))) {
				unset($this->_tmp_schema[$field]);
			}
		}
		
		return true;
		
	}
	
	/**
	 * afterSave
	 *
	 * @param 	bool	$created
	 * @return 	bool
	 */
	public function afterSave ($created=false) {
		
		if (isset($this->_tmp_schema)) {
			$this->_schema = $this->_tmp_schema;
		}
		
		return true;
		
	}
	
}
?>
