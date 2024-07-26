<?php
//session_destroy();

ini_set('session.cookie_lifetime', 0);
ini_set('session.gc_maxlifetime', 0);
session_start();
date_default_timezone_set("America/Sao_Paulo");
define("TEMPO_SESSAO", 600);


require 'config.php';

require 'vendor/autoload.php';

$core = new Core\Core();
$core->run();



