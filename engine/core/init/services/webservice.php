<?php
//Class Webservice
$ws = new \core\router\Webservice();

//Status do Webservice
define('WE_WS_ACTIVE', $ws->WSActive());
//Define Router Webservice
define('WE_WS_ROUTE', $ws->WSRouter());
//Autenticação do webservice
define('WE_WS_AUTH', $ws->WSAuth());
//Codificação padrão
define('WE_WS_ENCODE', $ws->WSEncode());


// End of file webservice.php
// Location: ./engine/core/init/services/webservice.php