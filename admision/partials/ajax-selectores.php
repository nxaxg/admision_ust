<?php
header("X-Validate: WP-AJAX"); 
 $crm = new idaCRM();
if (isset($_REQUEST['funcion']) && $_REQUEST['funcion'] && method_exists($crm, $_REQUEST['funcion'])) {
    $crm->{$_REQUEST['funcion']}($_REQUEST);
    exit();
} else {
    die('Not Allowed');
}
?>
