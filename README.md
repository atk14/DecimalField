DecimalField
============

Field for number with restricted count of digits and decimal places.

DecimalField is ideal for e.g. entering prices.

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

Cleaned values from this field could be: 1.23, 1.2, 4.0... (floats)

Option ```"format_number" => true``` can be used when it is required to get string values from the DecimalField:

    $this->add_field("weight", new DecimalField([
       "label" => "Weight in kg",
       "max_digits" => 6,
       "decimal_places" => 3,
       "format_number" => true,
    ]));

Cleaned values from such field could be: "1.230", "1.200", "4.000"... (string)

Installation
------------

Just use the Composer:

    cd path/to/your/atk14/project/
    composer require atk14/decimal-field

Optionally you can symlink the DecimalField file into your project:

    ln -s ../../vendor/atk14/decimal-field/src/app/fields/decimal_field.php app/fields/decimal_field.php

Testing
-------

    composer update --dev
    cd test
    ../vendor/bin/run_unit_tests

License
-------

DecimalField is free software distributed [under the terms of the MIT license](http://www.opensource.org/licenses/mit-license)

[//]: # ( vim: set ts=2 et: )
