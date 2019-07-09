<?php
class TcDecimalField extends TcBase {

	function test(){
		$lang = "en";
		Atk14Locale::Initialize($lang);

		$this->field = new DecimalField(array("max_digits" => 7, "decimal_places" => 4));

		$number = $this->assertValid("123.4567");
		$this->assertTrue("123.4567"===$number);

		$number = $this->assertValid("-123.4567");
		$this->assertTrue("-123.4567"===$number);

		$number = $this->assertValid("123");
		$this->assertTrue("123.0000"===$number);

		$number = $this->assertValid("-123.4");
		$this->assertTrue("-123.4000"===$number);

		$number = $this->assertValid("-123.450000");
		$this->assertTrue("-123.4500"===$number);

		$msg = $this->assertInvalid("");
		$this->assertEquals("This field is required.",$msg);

		$msg = $this->assertInvalid("12345");
		$this->assertEquals("Ensure this number has at most 3 digits in integer-part (it has 5).",$msg);

		$msg = $this->assertInvalid("1234.567");
		$this->assertEquals("Ensure this number has at most 3 digits in integer-part (it has 4).",$msg);

		$msg = $this->assertInvalid("1.45678");
		$this->assertEquals("Ensure this number has at most 4 decimal places (it has 5).",$msg);

		// -- disabling format_number option
		$this->field = new DecimalField(array("max_digits" => 5, "decimal_places" => 2, "format_number" => false));

		$number = $this->assertValid("123.40");
		$this->assertTrue(123.4===$number); // a float is returned
	}
}
