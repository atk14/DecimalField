<?php
class TcDecimalField extends TcBase {

	function test(){
		$this->field = new DecimalField(array("max_digits" => 7, "decimal_places" => 4));

		$number = $this->assertValid("123.4567");
		$this->assertTrue(123.4567===$number);

		$number = $this->assertValid("-123.4567");
		$this->assertTrue(-123.4567===$number);

		$number = $this->assertValid("123");
		$this->assertTrue(123.0===$number);

		$number = $this->assertValid("-123.4");
		$this->assertTrue(-123.4000===$number);

		$number = $this->assertValid("-123.450000");
		$this->assertTrue(-123.45===$number);

		$msg = $this->assertInvalid("");
		$this->assertEquals("This field is required.",$msg);

		$msg = $this->assertInvalid("12345");
		$this->assertEquals("Ensure this number has at most 3 digits in integer-part (it has 5).",$msg);

		$msg = $this->assertInvalid("1234.567");
		$this->assertEquals("Ensure this number has at most 3 digits in integer-part (it has 4).",$msg);

		$msg = $this->assertInvalid("1.45678");
		$this->assertEquals("Ensure this number has at most 4 decimal places (it has 5).",$msg);

		$number = $this->assertValid("0.12");
		$this->assertTrue(0.12===$number);

		$number = $this->assertValid("+0.13");
		$this->assertTrue(0.13===$number);

		$number = $this->assertValid("-0.14");
		$this->assertTrue(-0.14===$number);

		$number = $this->assertValid("0");
		$this->assertTrue(0.0===$number);

		$number = $this->assertValid("0.00");
		$this->assertTrue(0.0===$number);

		// spaces are removed automatically
		$this->field = new DecimalField(array("max_digits" => 7, "decimal_places" => 3));

		$number = $this->assertValid("1 234.567");
		$this->assertTrue(1234.567===$number);

		$nbsp = html_entity_decode("&nbsp;");
		$number = $this->assertValid("1{$nbsp}234.567");
		$this->assertTrue(1234.567===$number);

		// -- enabling format_number option
		$this->field = new DecimalField(array("max_digits" => 6, "decimal_places" => 3, "format_number" => true));

		$number = $this->assertValid("123");
		$this->assertTrue("123.000"===$number);

		$number = $this->assertValid("123.40");
		$this->assertTrue("123.400"===$number);

		$number = $this->assertValid("0.12");
		$this->assertTrue("0.120"===$number);

		$number = $this->assertValid("+0.13");
		$this->assertTrue("0.130"===$number);

		$number = $this->assertValid("-0.14");
		$this->assertTrue("-0.140"===$number);

		$number = $this->assertValid("0");
		$this->assertTrue("0.000"===$number);

		$number = $this->assertValid("0.00");
		$this->assertTrue("0.000"===$number);

		// -- formatting initial value
		$field = new DecimalField(array("max_digits" => 6, "decimal_places" => 3, "initial" => 12.3));
		$this->assertTrue("12.123"===$field->format_initial_data(12.123));
		$this->assertTrue("12.1"===$field->format_initial_data(12.1));
		$this->assertTrue("12.0"===$field->format_initial_data(12));
		$this->assertTrue("-12.0"===$field->format_initial_data(-12));
		$this->assertTrue(""===$field->format_initial_data(""));
		$this->assertTrue(""===$field->format_initial_data(null));
		$this->assertTrue("nonsence"===$field->format_initial_data("nonsence"));
		$this->assertTrue(" nonsence "===$field->format_initial_data(" nonsence "));
	}
}
