<?php

namespace SimpleSAML\Module\fullnameparser\Auth\Process;

use SimpleSAML\Auth\ProcessingFilter;
use SimpleSAML\Logger;
use SimpleSAML\Module\fullnameparser\FullNameParser;

/**
 * Authentication processing filter to split full name to first name and last name.
 *
 * Example configuration in the config/config.php
 *
 *    authproc.aa = [
 *       ...
 *       '60' => [
 *            'class' => 'fullnameparser:FullNameParsing',
 *            'fullNameAttribute' => 'common_name', // Optional, defaults to 'displayName'
 *            'firstNameAttribute' => 'first_name', // Optional, defaults to 'givenName'
 *            'lastNameAttribute' => 'last_name',   // Optional, defaults to 'sn'
 *       ],
 *    ],
 *
 * @author nikosev<nikos.ev@hotmail.com>
 * @package SimpleSAMLphp
 */
class FullNameParsing extends ProcessingFilter
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
                Logger::error("[FullNameParsing] configuration error: 'fullNameAttribute' not a string literal");
                throw new Exception(
                    "[FullNameParsing] configuration error: 'fullNameAttribute' not a string literal"
                );
            }
            $this->fullNameAttribute = $config['fullNameAttribute'];
        }

        if (array_key_exists('firstNameAttribute', $config)) {
            if (!is_string($config['firstNameAttribute'])) {
                Logger::error("[FullNameParsing] configuration error: 'firstNameAttribute' not a string literal");
                throw new Exception(
                    "[FullNameParsing] configuration error: 'firstNameAttribute' not a string literal"
                );
            }
            $this->firstNameAttribute = $config['firstNameAttribute'];
        }

        if (array_key_exists('lastNameAttribute', $config)) {
            if (!is_string($config['lastNameAttribute'])) {
                Logger::error("[FullNameParsing] configuration error: 'lastNameAttribute' not a string literal");
                throw new Exception(
                    "[FullNameParsing] configuration error: 'lastNameAttribute' not a string literal"
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

        if (
            !empty($request['Attributes'][$this->fullNameAttribute])
            && empty($request['Attributes'][$this->firstNameAttribute])
            && empty($request['Attributes'][$this->lastNameAttribute])
        ) {
            Logger::info("[FullNameParsing] process: Split full name for the user.");
            $fullName = $request['Attributes'][$this->fullNameAttribute][0];
            Logger::debug(
                "[FullNameParsing] process: input: '" . $this->fullNameAttribute . "', value: '" . $fullName . "'"
            );
            $parser = new FullNameParser();
            $splittedName = $parser->parse_name($fullName);
            if (!empty($splittedName['fname'])) {
                $request['Attributes'][$this->firstNameAttribute] = [$splittedName['fname']];
                Logger::debug(
                    "[FullNameParsing] process: output: '" . $this->firstNameAttribute
                    . "', value: '" . $splittedName['fname'] . "'"
                );
            }
            if (!empty($splittedName['lname'])) {
                $request['Attributes'][$this->lastNameAttribute] = [$splittedName['lname']];
                Logger::debug(
                    "[FullNameParsing] process: output: '" . $this->lastNameAttribute
                    . "', value: '" . $splittedName['lname'] . "'"
                );
            }
        }
    }
}
