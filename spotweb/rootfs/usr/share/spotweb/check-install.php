<?php

/*
 * Reports whether Spotweb considers its own installation up to date.
 *
 * Spotweb refuses to serve a single page while either of these two versions
 * lags behind the code, which is exactly what Bootstrap::validate() checks
 * before it hands over to the application. Checking the same two here means
 * bin/upgrade-db.php only has to run when it actually has work to do.
 *
 * Exits 0 when the installation is ready, and 1 when it needs upgrading.
 */

require_once '/var/www/spotweb/vendor/autoload.php';

try {
    $bootstrap = new Bootstrap();
    $daoFactory = $bootstrap->getDaoFactory();
    $settings = $bootstrap->getSettings($daoFactory, false);

    $valid = $settings->get('schemaversion') == SPOTDB_SCHEMA_VERSION
        && $settings->get('settingsversion') == SPOTWEB_SETTINGS_VERSION;
} catch (Throwable $exception) {
    // An empty or half-created database lands here, which simply means
    // there is upgrading to do.
    $valid = false;
}

exit($valid ? 0 : 1);
