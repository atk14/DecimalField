DecimalField
============

Field for number with restricted count of digits and decimal places.

DecimalField is ideal for e.g. entering pricing.

DecimalField does not provide number localization. It means that dot (".") is only valid separator for the decimal point.

Usage in a ATK14 application
----------------------------

In a form:

    <?php
    // file: app/forms/products/create_new_form.php
    class CreateNewForm extends ApplicationForm {

      function set_up(){
        // ...
        $this->add_field("price", new DecimalField([
          "label" => "Price",
          "max_digits" => 7,
          "decimal_places" => 2,
          "min_value" => 0,
        ]));
        // ...
      }
    }

Cleaned values from this field could be: "1.23", "1.20", "4.00"... (strings)

Option ```"format_number" => false``` can be used when it is required to get floats form the DecimalField:

    $this->add_field("weight", new DecimalField([
       "label" => "Weight in kg",
       "max_digits" => 6,
       "decimal_places" => 3,
       "format_number" => false,
    ]));

Cleaned values from such field could be: 1.23, 1.2, 4... (floats)

Installation
------------

Just use the Composer:

    cd path/to/your/atk14/project/
    composer require atk14/decimal-field dev-master

Optionally you can symlink the DecimalField files into your project:

    ln -s ../../vendor/atk14/decimal-field/src/app/fields/decimal_field.php app/fields/decimal_field.php
    ln -s ../../vendor/atk14/decimal-field/test/tc_decimal_field.php test/fields/tc_decimal_field.php

Testing
-------

At the moment testing is not possible in this project itself. DecimalField is only testable in an ATK14 project:


    cd path/to/your/atk14/project/test/fields/
    ../../scripts/run_unit_tests tc_number_field

It is expected that class TcBase exists in file test/fields/tc_base.php and is descendant of TcAtk14Field. Perfect example of that file is at https://github.com/atk14/Atk14Skelet/blob/master/test/fields/tc_base.php

License
-------

DecimalField is free software distributed [under the terms of the MIT license](http://www.opensource.org/licenses/mit-license)

[//]: # ( vim: set ts=2 et: )
