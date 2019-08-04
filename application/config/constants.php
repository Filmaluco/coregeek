<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

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

defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

//COOKIES TIMES (used for controlling the amount of time cookies stay in a browser)
defined('COOKIE_TIME_ACCESS')               OR define('COOKIE_TIME_ACCESS','3 days'); // user login accepted

//LOGIN CONSTANTS (used for authentication and login only)
defined('LOGIN_SUCCESS')                    OR define('LOGIN_SUCCESS', 0); // user login accepted
defined('LOGIN_ERROR_NON_EXISTENT_USER')    OR define('LOGIN_ERROR_NON_EXISTENT_USER', 1); // user doesn't exist
defined('LOGIN_ERROR_PASSWORD')             OR define('LOGIN_ERROR_PASSWORD', 2); // user password does not match

//AUTHENTICATION (used for control over the authentication result)
defined('AUTHENTICATION_SUCCESS')           OR define('AUTHENTICATION_SUCCESS', 1); // current user is valid
defined('AUTHENTICATION_ERROR')             OR define('AUTHENTICATION_ERROR', 0); // current user is invalid
defined('AUTH_GROUP_ADMIN')                 OR define('AUTH_GROUP_ADMIN', 1); // current user is from the admin group
defined('AUTH_GROUP_WORKER')                OR define('AUTH_GROUP_WORKER', 1); // current user is from the normal func group
defined('AUTH_PERMISSIONS_VIEW_BOOKING')            OR define('AUTH_PERMISSIONS_VIEW_BOOKING', 2); // authentication permission general view
defined('AUTH_PERMISSIONS_ADD_BOOKING')             OR define('AUTH_PERMISSIONS_ADD_BOOKING', 3); // authentication permission general add
defined('AUTH_PERMISSIONS_EDIT_FULL_BOOKING')            OR define('AUTH_PERMISSIONS_EDIT_FULL_BOOKING', 5); // authentication permission general edit
defined('AUTH_PERMISSIONS_EDIT_BASIC_BOOKING')            OR define('AUTH_PERMISSIONS_EDIT_BASIC_BOOKING', 4); // authentication permission general edit

//TOKEN
defined('TOKEN_VALID')                      OR define('TOKEN_VALID', 1); // current token is valid
defined('TOKEN_INVALID')                    OR define('TOKEN_INVALID', 0); // current token is invalid

//LOAD CONSTANTS (used for default loads of the database)
defined('LOAD_LAST_NOTIFICATIONS')          OR define('LOAD_LAST_NOTIFICATIONS', 5); //loads last 5notifications

//BOOKING TYPES AND STATES
defined('BOOKING_STATE_SCHEDULED')                      OR define('BOOKING_STATE_SCHEDULED', 1);
defined('BOOKING_STATE_BOOKED')                         OR define('BOOKING_STATE_BOOKED', 2);
defined('BOOKING_STATE_WAITING_CONFIRMATION')           OR define('BOOKING_STATE_WAITING_CONFIRMATION', 3);
defined('BOOKING_STATE_IN_LAB')                         OR define('BOOKING_STATE_IN_LAB', 4);
defined('BOOKING_STATE_WAITING_PRICE')                  OR define('BOOKING_STATE_WAITING_PRICE', 5);
defined('BOOKING_STATE_WAITING_PRICE_CONFIRMATION')     OR define('BOOKING_STATE_WAITING_PRICE_CONFIRMATION', 6);
defined('BOOKING_STATE_DENIED')                         OR define('BOOKING_STATE_DENIED', 7);
defined('BOOKING_STATE_WAITING_STOCK')                  OR define('BOOKING_STATE_WAITING_STOCK', 8);
defined('BOOKING_STATE_IN_REPAIR')                      OR define('BOOKING_STATE_IN_REPAIR', 9);
defined('BOOKING_STATE_REPAIRED')                       OR define('BOOKING_STATE_REPAIRED', 10);
defined('BOOKING_STATE_NO_REPAIR')                      OR define('BOOKING_STATE_NO_REPAIR', 11);
defined('BOOKING_STATE_REPAIRED_INFORMED')              OR define('BOOKING_STATE_REPAIRED_INFORMED', 12);
defined('BOOKING_STATE_NO_REPAIR_INFORMED')             OR define('BOOKING_STATE_NO_REPAIR_INFORMED', 13);
defined('BOOKING_STATE_WAITING_WITHDRAW')               OR define('BOOKING_STATE_WAITING_WITHDRAW', 14);
defined('BOOKING_STATE_BOOKED_DELIVERED_S')             OR define('BOOKING_STATE_BOOKED_DELIVERED_S', 15);
defined('BOOKING_STATE_BOOKED_DELIVERED_F')             OR define('BOOKING_STATE_BOOKED_DELIVERED_F', 16);
defined('BOOKING_STATE_BOOKED_CANCELED')                OR define('BOOKING_STATE_BOOKED_CANCELED', 17);

defined('BOOKING_TYPE_BUDGET')                          OR define('BOOKING_TYPE_BUDGET', 1);
defined('BOOKING_TYPE_GIVE_BUDGET')                     OR define('BOOKING_TYPE_GIVE_BUDGET', 2);
defined('BOOKING_TYPE_WARRANTY')                        OR define('BOOKING_TYPE_WARRANTY', 3);

