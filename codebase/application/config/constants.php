<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


define('NODESERVERURL', "http://uikk8bc8853d.indr4winata.koding.io:8081");

define('SALT_LENGTH', 9);
/* define('FB_APP_ID', '542691795867807');
define('FB_SECRET', '22e77c7b0cd1b764cd8fd52e99604133');

define('CONSUMER_KEY', 'OV9Lla88bjq2eMwSwnpDRz58J');
define('CONSUMER_SECRET', 'mR93O0bnC86sBYQ7paGR33qOkG59yR3ihxsJ7BJWhqxw3ySQiJ');
define('OAUTH_CALLBACK', 'http://127.0.0.1/qwarlocal/login/callback'); */

//online
define('FB_APP_ID', '337581579748226');
define('FB_SECRET', '06d0023853beaec71033ffcaa98e09dd');
define('CONSUMER_KEY', 'h0Hz783428NLgBAs4la5tnBrL');
define('CONSUMER_SECRET', 'Y6SEE1bAc8ZW5LMU0WgF51zgeY0bceL2Deoa7179Wb5y85WGiq');
define('OAUTH_CALLBACK', 'http://indr4winata.koding.io/qwar/login/callback');

/* End of file constants.php */
/* Location: ./application/config/constants.php */