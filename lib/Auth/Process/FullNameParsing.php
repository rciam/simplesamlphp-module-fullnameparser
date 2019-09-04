<?php

namespace SimpleSAML\Module\fullnameparser\Auth\Process;

use \Logger;
use \SimpleSAML\Module\fullnameparser\FullNameParser;

/**
 * Authentication processing filter to split full name to first name and last name.
 * 
 * Example configuration in the config/config.php
 *
 *    authproc.aa = array(
 *       ...
 *       '60' => array(
 *            'class' => 'fullnameparser:FullNameParsing',
 *            'fullNameAttribute' => 'common_name', // Optional, defaults to 'displayName'
 *            'firstNameAttribute' => 'first_name', // Optional, defaults to 'givenName'
 *            'lastNameAttribute' => 'last_name',   // Optional, defaults to 'sn'
 *       ),
 *
 * @author nikosev<nikos.ev@hotmail.com>
 * @package SimpleSAMLphp
 */

class FullNameParsing extends \SimpleSAML\Auth\ProcessingFilter
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
                Logger::error("[fullnameparser] Configuration error: 'fullNameAttribute' not a string literal");
                throw new Exception(
                    "fullnameparser configuration error: 'fullNameAttribute' not a string literal"
                );
            }
            $this->fullNameAttribute = $config['fullNameAttribute'];
        }

        if (array_key_exists('firstNameAttribute', $config)) {
            if (!is_string($config['firstNameAttribute'])) {
                Logger::error("[fullnameparser] Configuration error: 'firstNameAttribute' not a string literal");
                throw new Exception(
                    "fullnameparser configuration error: 'firstNameAttribute' not a string literal"
                );
            }
            $this->firstNameAttribute = $config['firstNameAttribute'];
        }

        if (array_key_exists('lastNameAttribute', $config)) {
            if (!is_string($config['lastNameAttribute'])) {
                Logger::error("[fullnameparser] Configuration error: 'lastNameAttribute' not a string literal");
                throw new Exception(
                    "fullnameparser configuration error: 'lastNameAttribute' not a string literal"
                );
            }
            $this->lastNameAttribute = $config['lastNameAttribute'];
        }
    }

    /**
     * Apply filter to rename attributes.
     *
     * @param array &$request The current request.
     */
    public function process(&$request)
    {
        assert(is_array($request));
        assert(array_key_exists('Attributes', $request));

        if (!empty($request['Attributes'][$this->fullNameAttribute]) && empty($request['Attributes'][$this->firstNameAttribute]) && empty($request['Attributes'][$this->lastNameAttribute])) {
            Logger::debug("[fullnameparser] process: input: '" . $this->fullNameAttribute . "', value: '" . $request['Attributes'][$this->fullNameAttribute][0] . "'");
            $parser = new FullNameParser();
            $splittedName = $parser->parse_name($request['Attributes'][$this->fullNameAttribute][0]);
            if (!empty($splittedName['fname'])) {
                $request['Attributes'][$this->firstNameAttribute] = array($splittedName['fname']);
                Logger::debug("[fullnameparser] process: output: '" . $this->firstNameAttribute . "', value: '" . $splittedName['fname'] . "'");
            }
            if (!empty($splittedName['lname'])) {
                $request['Attributes'][$this->lastNameAttribute] = array($splittedName['lname']);
                Logger::debug("[fullnameparser] process: output: '" . $this->lastNameAttribute . "', value: '" . $splittedName['lname'] . "'");
            }
        }
    }
}
