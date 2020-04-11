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
    authproc = [
        ...
        30 => [
            'class' => 'fullnameparser:FullNameParsing',
            'fullNameAttribute' => 'common_name', // Optional, defaults to 'displayName'
            'firstNameAttribute' => 'first_name', // Optional, defaults to 'givenName'
            'lastNameAttribute' => 'last_name',   // Optional, defaults to 'sn'
        ],
```

## GenerateFullName

Generates the user's full name based on the available given name and surname information.

### SimpleSAMLphp configuration

The following authproc filter configuration options are supported:

* `fullNameAttribute`: Optional, a string to use as the name of the attribute that holds the user's full name. Defaults to 'displayName'.
* `firstNameAttribute`: Optional, a string to use as the name of the attribute that will hold the user's first name. Defaults to 'givenName'.
* `lastNameAttribute`: Optional, a string to use as the name of the attribute that will hold the user's last name. Defaults to 'sn'.

### Example authproc filter configuration

```php
    authproc = [
        ...
        30 => [
            'class' => 'fullnameparser:GenerateFullName',
            'fullNameAttribute' => 'common_name', // Optional, defaults to 'displayName'
            'firstNameAttribute' => 'first_name', // Optional, defaults to 'givenName'
            'lastNameAttribute' => 'last_name',   // Optional, defaults to 'sn'
        ],
    ],
```

## Compatibility matrix

This table matches the module version with the supported SimpleSAMLphp version.

| Module |  SimpleSAMLphp |
|:------:|:--------------:|
| v1.0   | v1.14          |
| v1.1   | v1.14          |
| v2.0   | v1.15          |
| v3.0   | v1.17          |

## License

Licensed under the Apache 2.0 license, for details see `LICENSE`.

