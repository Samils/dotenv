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
  if (!class_exists('Sammy\Packs\DotEnv\Base')){
  /**
   * @class Base
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
  abstract class Base {
    private $rootDir;
    /**
     * @method void __invoke
     */
    public final function __invoke () {
      $dotEnvFileList = Config::FileList ();

      $backTrace = debug_backtrace ();

      $validTrace = ( boolean ) (
        is_array ($backTrace) &&
        isset ($backTrace [0]) &&
        is_array ($backTrace [0]) &&
        isset ($backTrace [0]['file']) &&
        is_string ($backTrace [0]['file'])
      );

      if ( $validTrace ) {
        $traceDir = dirname ($backTrace [0]['file']);
      }

      $this->rootDir = $this->getRootDir (
        isset ($traceDir) ? $traceDir : ''
      );

      foreach ($dotEnvFileList as $dotEnvFile) {
        $this->readDotEnvFile ($dotEnvFile);
      }

      Config\Setter::endConfig ();
    }
    /**
     * @method void readDotEnvFile
     * Read a dotenv file based in a given
     * dot env file path.
     *
     * @param string $dotEnvFile
     * Dotenv file relative path
     */
    private function readDotEnvFile (string $dotEnvFile) {
      $dotEnvFile = $this->rootDir . $dotEnvFile;
      /**
       * verify if there is a '.env' file
       * inside the application root directory
       * in order using it's declarations inside
       * the application environment scope
       */
      if ( is_file ($dotEnvFile) ) {
        $dotEnvFileContent = file_get_contents ($dotEnvFile);

        $liveSetConfig = new Config\Setter;

        $liveSetConfig (preg_split ('/\n/', $dotEnvFileContent));
      }
    }
    /**
     * @method string getRootDir
     * Get the application root directory
     * absolute path.
     * In a first momment, it will look for a
     * defined constant having a name in the
     * '$dotEnvRootPathsAlternates' array
     * [ declared in the method scope].
     *
     * @param string $defaultDir
     * Default directory absolute path to be assumed
     * if there is not defined none of the
     * '$dotEnvRootPathsAlternates'.
     */
    protected function getRootDir ($defaultDir = '/') {

      if (!is_string ($defaultDir)) {
        $defaultDir = '/';
      }

      $dotEnvRootPathsAlternates = array (
        '__root__',
        '__rootdir__'
      );

      $slashRe = '/(\\\|\/)+$/';
      $definedDotEnvRootPaths = ( boolean ) (
        defined ('DOTENV_ROOT_PATHS') &&
        (is_array (constant ('DOTENV_ROOT_PATHS')) ||
          is_string (constant ('DOTENV_ROOT_PATHS'))
        )
      );

      if ($definedDotEnvRootPaths) {
        if (is_string (DOTENV_ROOT_PATHS)) {
          $dotEnvRootPaths = preg_split ('/\s+/',
            trim (DOTENV_ROOT_PATHS)
          );
        } else {
          $dotEnvRootPaths = DOTENV_ROOT_PATHS;
        }

        $dotEnvRootPathsAlternates = array_merge (
          $dotEnvRootPathsAlternates,
          $dotEnvRootPaths
        );
      }

      foreach ($dotEnvRootPathsAlternates as $alternate) {
        if (defined ($alternate)) {
          $rootDir = constant ($alternate);

          $rootDir = preg_replace ($slashRe, '', $rootDir);

          return $rootDir . DIRECTORY_SEPARATOR;
        }
      }

      $defaultDir = preg_replace ($slashRe, '', $defaultDir);

      return $defaultDir . DIRECTORY_SEPARATOR;
    }
  }}
}
