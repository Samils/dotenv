<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\DotEnv\Config\Setter
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
namespace Sammy\Packs\DotEnv\Config\Setter {
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists('Sammy\Packs\DotEnv\Config\Setter\Bind')){
  /**
   * @trait Bind
   * Base internal trait for the
   * DotEnv\Setter module.
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
  trait Bind {
    /**
     * @method mixed bindValue
     *
     * Bind a dotenv file key value.
     * Generally, load it as valid php data.
     *
     * @param  string $varValue
     * @return unkown
     */
    private static function bindValue ($varValue = '') {
      $varValue = trim ($varValue);
      $re = '/^(true|false|null)$/i';
      # return the core value if
      # it is a numeric string.
      if (is_numeric ($varValue)) {
        return (float)($varValue);
      } elseif (preg_match ($re, $varValue)) {
        return eval ('return ' . $varValue . ';');
      } else {
        $evalValue = json_encode (( string )($varValue));

        if ($varValue = json_decode ($varValue)) {
          return self::_object2array ($varValue);
        }

        return eval ('return ' . $evalValue . ';');
      }
    }

    private static function _object2array ($object) {
      if (!(is_object ($object))) {
        return $object;
      }

      $object = ((array)($object));
      $newObject = [];

      foreach ($object as $key => $value) {
        $newObject [ $key ] = (
          self::_object2array ( $value )
        );
      }

      return is_array ($newObject) ? $newObject : (
        ((array)( $newObject ))
      );
    }
  }}
}
