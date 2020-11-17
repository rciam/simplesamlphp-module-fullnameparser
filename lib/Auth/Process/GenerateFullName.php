<?php

namespace SimpleSAML\Module\fullnameparser\Auth\Process;

use SimpleSAML\Auth\ProcessingFilter;
use SimpleSAML\Logger;

/**
 * Authentication processing filter to split full name to first name and last name.
 *
 * Example configuration in the config/config.php
 *
 *    authproc.aa = [
 *       ...
 *       '61' => [
 *            'class' => 'fullnameparser:GenerateFullName',
 *            'fullNameAttribute' => 'common_name', // Optional, defaults to 'displayName'
 *            'firstNameAttribute' => 'first_name', // Optional, defaults to 'givenName'
 *            'lastNameAttribute' => 'last_name',   // Optional, defaults to 'sn'
 *       ],
 *    ],
 *
 * @author nikosev<nikos.ev@hotmail.com>
 * @package SimpleSAMLphp
 */

class GenerateFullName extends ProcessingFilter
{

    private $fullNameAttribute = 'displayName';

    private $firstNameAttribute = 'givenName';

    private $lastNameAttribute = 'sn';

    /**
     * Initialize this filter, parse configuration
     *
     * @param array $config Configuration information about this filter.
     * @param mixed $reserved For future use.
     *
     * @throws Exception If the configuration of the filter is wrong.
     */
    public function __construct($config, $reserved)
    {
        parent::__construct($config, $reserved);
        assert('is_array($config)');


        if (array_key_exists('fullNameAttribute', $config)) {
            if (!is_string($config['fullNameAttribute'])) {
                Logger::error(
                    "[GenerateFullName] configuration error: 'fullNameAttribute' not a string literal"
                );
                throw new Exception(
                    "[GenerateFullName] configuration error: 'fullNameAttribute' not a string literal"
                );
            }
            $this->fullNameAttribute = $config['fullNameAttribute'];
        }

        if (array_key_exists('firstNameAttribute', $config)) {
            if (!is_string($config['firstNameAttribute'])) {
                Logger::error(
                    "[GenerateFullName] configuration error: 'firstNameAttribute' not a string literal"
                );
                throw new Exception(
                    "[GenerateFullName] configuration error: 'firstNameAttribute' not a string literal"
                );
            }
            $this->firstNameAttribute = $config['firstNameAttribute'];
        }

        if (array_key_exists('lastNameAttribute', $config)) {
            if (!is_string($config['lastNameAttribute'])) {
                Logger::error(
                    "[GenerateFullName] configuration error: 'lastNameAttribute' not a string literal"
                );
                throw new Exception(
                    "[GenerateFullName] configuration error: 'lastNameAttribute' not a string literal"
                );
            }
            $this->lastNameAttribute = $config['lastNameAttribute'];
        }
    }

    /**
     * Apply filter to rename attributes.
     *
     * @param array &$state The current state.
     */
    public function process(&$state)
    {
        assert(is_array($state));
        assert(array_key_exists('Attributes', $state));

        if (
            empty($state['Attributes'][$this->fullNameAttribute])
            && !empty($state['Attributes'][$this->firstNameAttribute])
            && !empty($state['Attributes'][$this->lastNameAttribute])
        ) {
            Logger::info("[GenerateFullName] process: Create full name for the user.");
            $firstName = $state['Attributes'][$this->firstNameAttribute][0];
            $lastName = $state['Attributes'][$this->lastNameAttribute][0];
            $fullName = [$firstName . " " . $lastName];
            Logger::debug(
                "[GenerateFullName] process: input: '" . $this->firstNameAttribute . "', value: '" . $firstName . "'"
            );
            Logger::debug(
                "[GenerateFullName] process: input: '" . $this->lastNameAttribute . "', value: '" . $lastName . "'"
            );
            Logger::debug(
                "[GenerateFullName] process: output: '" . $this->fullNameAttribute . "', value: '" . $fullName . "'"
            );
            $state['Attributes'][$this->fullNameAttribute] = $fullName;
        }
    }
}
