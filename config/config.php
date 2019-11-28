<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('max_execution_time', '3000');
/** Configuration for: Error reporting */
error_reporting(E_ALL);
ini_set("display_errors", 1);

/* MVC Model*/
require_once 'controller/controlador.php'; // Carrega o arquivo controlador.php
require_once 'lib/adodb/adodb.inc.php'; // Carrega o arquivo controlador.php

unset($CFG); // Ignore this line
//=========================================================================
// 1. DATABASE SETUP
//=========================================================================
$CFG->dbtype    = 'mysqli';
$CFG->dblibrary = 'native';
$CFG->dbhost = '127.0.0.1';//'172.16.13.205' 192.168.69.88; //205 eg 'localhost' or 'db.isp.com' or IP
$CFG->dbname = 'nonio';        // database name, eg moodle
$CFG->dbuser = 'portal'; //'portal'portixmngr;        // your database username
$CFG->dbpass = '';//'portal';ZzMu42#        // your database password
$CFG->dbpersist = 0;
$CFG->dblogerror = 1;           //Regista em log os erros de acesso � base de dados
//=========================================================================
// 1. Backend SETUP
//=========================================================================
$CFG->backend = 'https://pio.intranet.ipc.pt/';
$CFG->backend_timeout = '300';

