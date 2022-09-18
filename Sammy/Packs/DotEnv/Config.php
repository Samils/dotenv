<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\DotEnv
 * - Autoload, application dependencies
 *
 * MIT License
 *
 * Copyright (c) 2020 Ysare
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
namespace Sammy\Packs\DotEnv {
  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists('Sammy\Packs\DotEnv\Config')){
  /**
   * @class Config
   * Base internal class for the
   * DotEnv module.
   * -
   * This is (in the ils environment)
   * an instance of the php module,
   * wich should contain the module
   * core functionalities that should
   * be extended.
   * -
   * For extending the module, just create
   * an 'exts' directory in the module directory
   * and boot it by using the ils directory boot.
   * -
   */
  final class Config {
    /**
     * @var array config
     *
     * A map of whole the environment configurations
     * set.
     *
     */
    private static $config = [];

    /**
     * @method array|void SetEnvironmentConfig
     *
     * Create configuration variables for
     * global using by dotenv module.
     *
     */
    public static function SetEnvironmentConfig ($key = null) {
      $args = func_get_args ();

      if (!(count ($args) >= 1)) {
        return null;
      }

      $value = $args [ -1 + count ($args) ];

      if (is_string ($key)) {
        $key = strtolower ($key);

        $variableIssetAsArray = ( boolean ) (
          isset (self::$config [$key]) &&
          is_array (self::$config [$key])
        );

        if ($variableIssetAsArray) {
          if (!is_array ($value)) {
            $value = [ $value ];
          }

          self::$config [ $key ] = array_full_merge (
            self::$config [ $key ], $value
          );

          return self::$config [ $key ];
        }

        return self::$config [ $key ] = $value;
      } elseif (is_array ($key)) {
        # if '$key' is an array, map each
        # property and value inside it in order
        # declaring an environment variable for
        # them.
        foreach ($key as $varName => $varValue) {
          self::SetEnvironmentConfig ($varName, $varValue);
        }
      }
    }

    /**
     * @method array|void GetEnvironmentConfig
     *
     * Get configuration variables for
     * global using by dotenv module.
     *
     */
    public static function GetEnvironmentConfig ($key = null) {
      $key = strtolower ($key);

      if (isset (self::$config [ $key ])) {
        return self::$config [ $key ];
      }
    }

    public static function Set () {
      $args = func_get_args ();

      return forward_static_call_array (
        [self::class, 'SetEnvironmentConfig'], $args
      );
    }

    public static function Get () {
      $args = func_get_args ();

      return forward_static_call_array (
        [self::class, 'GetEnvironmentConfig'], $args
      );
    }

    public static function FileList () {
      $env = null;
      /**
       * Try getting the current aplication
       * environment from an 'environment'
       * function wich should return a string
       * , and should be the current application
       * environment got from the 'ILS_ENV' constant.
       */
      if (function_exists ('environment')) {
        $env = strtolower (environment ());
      }
      /**
       * A list of alternatives for the .env file
       * inside the project root directory when
       * running and setting the dot-env module up.
       * This list contains whole the supported .env
       * file by priority as declared at ils docs.
       */
      return array (
        '.env',
        '.env.'.$env,
        '.env.local',
        '.env.'.$env.'.local',
      );
    }
  }}
}
