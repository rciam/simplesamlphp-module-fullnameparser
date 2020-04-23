# simplesamlphp-module-fullnameparser

A SimpleSAMLphp module for generating givenName, sn and displayName.
This module is using the [PHP-Name-Parser](https://github.com/joshfraser/PHP-Name-Parser) library.

## FullNameParsing

Generates the user's given name and surname based on the available full name information.

### SimpleSAMLphp configuration

The following authproc filter configuration options are supported:

* `fullNameAttribute`: Optional, a string to use as the name of the attribute that holds the user's full name. Defaults to 'displayName'.
* `firstNameAttribute`: Optional, a string to use as the name of the attribute that will hold the user's first name. Defaults to 'givenName'.
* `lastNameAttribute`: Optional, a string to use as the name of the attribute that will hold the user's last name. Defaults to 'sn'.

### Example authproc filter configuration

```php
    authproc = array(
        ...
        30 => array(
            'class' => 'fullnameparser:FullNameParsing',
            'fullNameAttribute' => 'common_name', // Optional, defaults to 'displayName'
            'firstNameAttribute' => 'first_name', // Optional, defaults to 'givenName'
            'lastNameAttribute' => 'last_name',   // Optional, defaults to 'sn'
        ),
```

## GenerateFullName

Generates the user's full name based on the available given name and surname information.

This filter has no effect if the user's given name or surname attribute is missing.

If the full name attribute already exists, then the filter will not modify the existing value. If you instead want to replace the existing attribute, you need to set the `replace` option to `true`.

### SimpleSAMLphp configuration

The following authproc filter configuration options are supported:

* `fullNameAttribute`: Optional, a string to use as the name of the attribute that will hold the user's full name. Defaults to `'displayName'`.
* `firstNameAttribute`: Optional, a string to use as the name of the attribute that holds the user's first name. Defaults to `'givenName'`.
* `lastNameAttribute`: Optional, a string to use as the name of the attribute that holds the user's last name. Defaults to `'sn'`.
* `replace`: Optional, a boolean value to indicate whether to replace the original full name attribute. Defaults to `false`.

### Example authproc filter configuration

```php
    authproc = array(
        ...
        30 => array(
            'class' => 'fullnameparser:GenerateFullName',
            'fullNameAttribute' => 'common_name', // Optional, defaults to 'displayName'
            'firstNameAttribute' => 'first_name', // Optional, defaults to 'givenName'
            'lastNameAttribute' => 'last_name',   // Optional, defaults to 'sn'
            'replace' => true,   // Optional, defaults to false 
        ),
```

## Compatibility matrix

This table matches the module version with the supported SimpleSAMLphp version.

| Module |  SimpleSAMLphp |
|:------:|:--------------:|
| v1.0   | v1.14          |
| v1.1   | v1.14          |
| v1.2   | v1.14          |

## License

Licensed under the Apache 2.0 license, for details see `LICENSE`.

