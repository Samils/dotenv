<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @namespace Sammy\Packs\DotEnv
 * - Autoload, application dependencies
 */
namespace Sammy\Packs\DotEnv {
  $autoloadFile = __DIR__ . '/vendor/autoload.php';

  if (is_file ($autoloadFile)) {
    include_once $autoloadFile;
  }

  $includeAll = requires ('include-all');

  $includeAll->includeAll ('./src/helpers');
}
