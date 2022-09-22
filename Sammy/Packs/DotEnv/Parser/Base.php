<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @namespace Sammy\Packs\DotEnv\Parser
 * - Autoload, application dependencies
 */
namespace Sammy\Packs\DotEnv\Parser {
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   */
  if (!trait_exists('Sammy\Packs\DotEnv\Parser\Base')){
  /**
   * @trait Base
   * Base internal trait for the
   * DotEnv\Parser module.
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
  trait Base {
    /**
     * [parse()]
     * @param  array  $dotEnvDatas
     * @return array
     */
    public function parse ($dotEnvDatas = []) {
      if (!(is_array($dotEnvDatas) && $dotEnvDatas))
        return;

      $dotEnvDatasCount = count ($dotEnvDatas);
      $dotEnvDatasParsedDatas = array ();

      for ($i = 0; $i < $dotEnvDatasCount; $i++) {
        $line = (trim($dotEnvDatas[$i]));
        $re = '/^([^=]+)\s*=?/';

        if (empty($line) || preg_match ('/^#/', trim($line))) {
          continue;
        }

        $varNameMatch = preg_match ($re, $line, $varNameCore);

        if ($varNameMatch) {
          $varName = trim (preg_replace('/(\s*=\s*)$/', '',
            $varNameCore[ 0 ]
          ));

          $dotEnvDatasParsedDatas [$varName] = (
            preg_replace ($re, '',  $line)
          );
        }
      }

      return $dotEnvDatasParsedDatas;
    }
  }}
}
