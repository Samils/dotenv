<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\DotEnv\Config
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
namespace Sammy\Packs\DotEnv\Config {
  use Sammy\Packs\DotEnv\Config;
  use Sammy\Packs\DotEnv\Parser;
  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists('Sammy\Packs\DotEnv\Config\Setter')){
  /**
   * @class Setter
   * Base internal class for the
   * DotEnv\Config module.
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
  class Setter {
    use Setter\Base;
    use Setter\Bind;

    /**
     * [Config description]
     */
    private static function Config () {
      $arr = array_merge ($_ENV, self::$envVars);

      Config::SetEnvironmentConfig ('ENV', $arr);
      # Define the 'ENV' constant
      # as an array containg the
      # environment variables used
      # by the current system.
      defined ('ENV') or define ('ENV', $arr);

      $_ENV = array_merge ($_ENV, $arr);
    }

    private static $done = false;
    /**
     * [__construct description]
     * @param array $args
     */
    public function __construct ($args = []) {
    }
    /**
     * [__invoke description]
     * @param  array  $dotEnvDatas
     * @return [type]
     */
    public function __invoke (array $dotEnvDatas = []) {
      if (!(is_array($dotEnvDatas) && $dotEnvDatas)) {
        return;
      }

      $parser = new Parser;

      self::Define ($parser->parse ($dotEnvDatas));
    }

    public static function endConfig () {
      return self::$done ? true : self::Config ();
    }
  }}
}
