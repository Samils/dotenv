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
  use Sammy\Packs\IncludeAll;

  $autoloadFile = __DIR__ . '/vendor/autoload.php';

  if (is_file ($autoloadFile)) {
    include_once $autoloadFile;
  }

  $includeAll = new IncludeAll;

  $includeAll->includeAll ('./src/helpers');
}
