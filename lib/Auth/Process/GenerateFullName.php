<?php

namespace SimpleSAML\Module\fullnameparser\Auth\Process;

use SimpleSAML\Auth\ProcessingFilter;
use SimpleSAML\Logger;

/**
 * Authentication processing filter for generating full name attribute based on
 * available first name and last name attributes.
 *
 * Example configuration:
 *
 *    authproc = [
 *       ...
 *       '61' => [
 *            'class' => 'fullnameparser:GenerateFullName',
 *            'fullNameAttribute' => 'common_name', // Optional, defaults to 'displayName'
 *            'firstNameAttribute' => 'first_name', // Optional, defaults to 'givenName'
 *            'lastNameAttribute' => 'last_name',   // Optional, defaults to 'sn'
 *            'replace' => true,   // Optional, defaults to false
 *       ],
 *    ],
 *
 * @author nikosev<nikos.ev@hotmail.com>
 * @author Nicolas Liampotis <nliam@grnet.gr>
 * @package SimpleSAMLphp
 */

class GenerateFullName extends ProcessingFilter
{

    private $fullNameAttribute = 'displayName';

    private $firstNameAttribute = 'givenName';

    private $lastNameAttribute = 'sn';

    private $replace = false;

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

        if (array_key_exists('replace', $config)) {
            if (!is_bool($config['replace'])) {
                Logger::error("[GenerateFullName] Configuration error: 'replace' not a boolean");
                throw new Exception(
                    "GenerateFullName configuration error: 'replace' not a boolean value"
                );
            }
            $this->replace = $config['replace'];
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

        // Nothing to do if either firstName or lastName attribute is missing
        if (
            empty($state['Attributes'][$this->firstNameAttribute])
            || empty($state['Attributes'][$this->lastNameAttribute])
        ) {
            Logger::debug(
                "[GenerateFullName] process: Cannot generate " . $this->fullNameAttribute . " attribute"
            );
            return;
        }

        // Nothing to do if fullName attribute already exists and replace is set to false
        if (
            !empty($state['Attributes'][$this->fullNameAttribute])
            && !$this->replace
        ) {
            Logger::debug(
                "[GenerateFullName] process: Cannot replace existing " . $this->fullNameAttribute . " attribute"
            );
            return;
        }

        Logger::debug(
            "[GenerateFullName] process: input: '" . $this->firstNameAttribute . "', value: '"
            . $state['Attributes'][$this->firstNameAttribute][0] . "'"
        );
        Logger::debug(
            "[GenerateFullName] process: input: '" . $this->lastNameAttribute . "', value: '"
            . $state['Attributes'][$this->lastNameAttribute][0] . "'"
        );
        $state['Attributes'][$this->fullNameAttribute] = array($state['Attributes'][$this->firstNameAttribute][0]
        . " " . $state['Attributes'][$this->lastNameAttribute][0]);
        Logger::debug(
            "[GenerateFullName] process: output: '" . $this->fullNameAttribute . "', value: '"
            . $state['Attributes'][$this->fullNameAttribute][0] . "'"
        );
    }
}
