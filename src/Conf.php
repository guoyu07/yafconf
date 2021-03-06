<?php

/**
 * Created by PhpStorm.
 * User: Frost Wong <frostwong@gmail.com>
 * Date: 16-7-23
 * Time: 下午11:17
 */

namespace Conf;
use Yaf\Config\Ini;
use SeasLog;

class Conf
{
    public static function get($dottedKey, $defaultValue = null)
    {
        list($filename, $key) = explode('.', $dottedKey, 2);

        if (!defined('CONF_PATH')) {
            if (is_dir(APPLICATION_PATH . '/conf')) {
                define('CONF_PATH', APPLICATION_PATH . '/conf');
            } else if (is_dir(APPLICATION_PATH . '/../conf')) {
                define('CONF_PATH', APPLICATION_PATH . '/../conf');
            } else {
                throw new Exception('No configuration directory is found');
            }
        }

        $filename = CONF_PATH . '/' . $filename . '.ini';
        if (is_file($filename) && is_readable($filename)) {
            $iniConfig = new Ini($filename, APP_ENV);

            if (is_a($iniConfig, 'Yaf\Config\Ini')) {
                $mixedConfig = $iniConfig->get($key);

                if (is_a($mixedConfig, 'Yaf\Config\Ini')) {
                    return $mixedConfig->toArray();
                } else if (is_scalar($mixedConfig)) {
                    return $mixedConfig;
                } else {
                    return $defaultValue;
                }
            } else {
                return $defaultValue;
            }
        } else {
            return $defaultValue;
        }
    }
}
