<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$sessionTimeout = 2*60*60;//2 hours
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'iAnsar',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'10qpalzm',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	),

	// application components
	'preload'=>array('log'),
	'components'=>array(
		'session' => array(
        	'class' => 'CDbHttpSession',
			'connectionID' => 'db',
    		'sessionTableName' => 'session_table',
		),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'class' => 'WebUser',
		),
		'cache' => array(  
			'class' => 'system.caching.CFileCache'  
		),
		'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning, info',
                    'categories'=>'system.*',
                ),
            ),
        ),
		'imagemod' => array(
		    'class' => 'application.extensions.imagemodifier.CImageModifier',
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'caseSensitive'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=iansar',
			'emulatePrepare' => true,
			'username' => 'iansaruser',
			'password' => 'iansar',
			'charset' => 'utf8',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'iansarmail@gmail.com',
		'adminEmailPassword'=>'iansarpwd',
		'upload_path'=>'/uploads/',
		'sessionTimeoutSeconds'=> $sessionTimeout,
		'sqlbkppath'=>dirname(__FILE__)."/../../sqlbkp/bkp_db.sql",
		'imgbkppath'=>dirname(__FILE__)."/../../imgbkp/bkp_img.zip"
	),
);