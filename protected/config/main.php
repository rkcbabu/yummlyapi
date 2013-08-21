<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Data Extraction with Yummly API',
    'theme' => 'abound',
    // preloading 'log' component
    'preload' => array(
        'bootstrap',
        'log',
    ),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'admin',
            'ipFilters' => array('127.0.0.1', '::1'),
            'generatorPaths' => array(
                'application.gii'
            ),
        ),
    ),
    'components' => array(
        'bootstrap' => array(
            'class' => 'ext.bootstrap.components.Bootstrap',
            'responsiveCss' => true,
        ),
        'user' => array(
            'allowAutoLogin' => true,
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName'=>false,
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        'db' => array(
            'connectionString' => 'pgsql:host=localhost;port=5432;dbname=yummlyapi',
            'username' => 'postgres',
            'password' => 'Samsung12',
            'tablePrefix' => '',
            'charset' => 'UTF8',
            'enableProfiling' => true,
            'enableParamLogging' => true,
            //'emulatePrepare' => false,
            'schemaCachingDuration' => 60 * 60 * 24 * 30,
            'queryCacheID' => 'cache',
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
    ),
    'params' => include 'params.php',
);