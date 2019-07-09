<?php
/**
 * Field for number with restricted count of digits and decimal places
 *
 *	$field = new DecimalField(["max_digits" => 5, "decimal_places" => 2]); // accepts all numbers from -999.99 to 999.99 with up to 2 decimal places
 */
class DecimalField extends FloatField {

	function __construct($options = array()){
		$options += array(
			"max_digits" => null,
			"decimal_places" => null,

			"format_number" => true, // whether or not format output value using number_format() function; if it set to false, a float value is returned
		);

		$this->max_digits = $options["max_digits"];
		$this->decimal_places = $options["decimal_places"];
		$this->format_number = $options["format_number"];

		parent::__construct($options);

		$this->update_messages(array(
			"max_digits" => _("Ensure this number has at most %max% digits (it has %digits% including allowed decimal places)."),
			"decimal_places" => _("Ensure this number has at most %max% decimal places (it has %decimal_places%)."),
		));

	}

	function format_initial_data($data){
		return $this->_numberFormat($data);
	}

	function clean($value){
		$value = preg_replace('/\s/','',$value);
		if(!preg_match('/^[+-]?([1-9]\d*)(|\.(\d*))$/',$value,$matches)){
			return parent::clean($value);
		}
		$part1 = $matches[1];
		$decimals = isset($matches[3]) ? $matches[3] : "";
		$decimals = preg_replace('/0+$/','',$decimals);

		$max_digits = $this->max_digits;
		if(!is_null($max_digits)){
			$max_digits = $max_digits - $this->decimal_places;
		}
		if(!is_null($max_digits) && strlen($part1)>$max_digits){
			return array(strtr($this->messages["max_digits"],array("%max%" => $this->max_digits, "%digits%" => strlen($part1) + $this->decimal_places)),null);
		}

		if(isset($this->decimal_places) && strlen($decimals)>$this->decimal_places){
			return array(strtr($this->messages["decimal_places"],array("%max%" => $this->decimal_places, "%decimal_places%" => strlen($decimals))),null);
		}

		list($err,$value) = parent::clean($value);

		$value = $this->_numberFormat($value);

		return array($err,$value);
	}

	protected function _numberFormat($value){
		if($this->format_number && !is_null($value) && !is_null($this->decimal_places)){
			return number_format($value,$this->decimal_places,".","");
		}
		return $value;
	}
}