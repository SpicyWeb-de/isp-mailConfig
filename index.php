<?php
include('config.php');

function global_exception_handler($exception) {
        die("Exception unhandled:" . $exception->getMessage());
}

set_exception_handler('global_exception_handler');

function autoload($name){
    $name = str_replace('\\', '/', $name);
    $class_path = dirname(__FILE__).'/include/classes/';
    static $class_extension = '.php';
    if(file_exists($class_path . $name . $class_extension))
        require_once($class_path . $name . $class_extension);
}
spl_autoload_register('autoload');

AutoConfig::addFile('autodiscover.xml', 'ConfigOutlook');
AutoConfig::addFile('mail/config-v1.1.xml', 'ConfigMozilla');
AutoConfig::setDefault('autodiscover.xml');

$config = AutoConfig::get($_GET['file']);
$config->response();
?>