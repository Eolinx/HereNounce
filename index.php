<?php

use Extensions\Helix\HelixConfig;
use Quark\Quark;
use Quark\QuarkConfig;

include __DIR__ . '/loader.php';

use Quark\AuthorizationProviders\Session;

use Quark\DataProviders\MySQL;

use Quark\Extensions\CDN\CDNConfig;
use Quark\Extensions\CDN\Providers\QuarkSelfCDN;

use Models\User;

const APP_DB = 'db';
const APP_SESSION = 'session';

const APP_HELIX = 'helix';

const APP_CDN = 'cdn';

$config = new QuarkConfig(__DIR__ . '/runtime/application.ini');

$config->Localization(__DIR__ . '/localization.ini');

$config->DataProvider(APP_DB, new MySQL());

$config->AuthorizationProvider(APP_SESSION, new Session(APP_DB), new User());

$config->Extension(APP_CDN, new CDNConfig(new QuarkSelfCDN()));

$config->Extension(APP_HELIX, new HelixConfig());

Quark::Run($config);