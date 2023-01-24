<?php

defined('BASEPATH') OR exit('No direct script access allowed');



$config['base_url'] = 'https://development.advs-payment.de/';



$config['index_page'] = '';




$config['uri_protocol']	= 'REQUEST_URI';



$config['url_suffix'] = '';




$config['language']	= 'english';



$config['charset'] = 'UTF-8';




$config['enable_hooks'] = TRUE;



$config['subclass_prefix'] = 'MY_';



$config['composer_autoload'] = FALSE;



$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';



$config['enable_query_strings'] = FALSE;

$config['controller_trigger'] = 'c';

$config['function_trigger'] = 'm';

$config['directory_trigger'] = 'd';



$config['allow_get_array'] = TRUE;



$config['log_threshold'] = 0;



$config['log_path'] = '';




$config['log_file_extension'] = '';



$config['log_file_permissions'] = 0644;



$config['log_date_format'] = 'Y-m-d H:i:s';



$config['error_views_path'] = '';



$config['cache_path'] = '';



$config['cache_query_string'] = FALSE;



$config['encryption_key'] = '';



$config['sess_driver'] = 'files';

$config['sess_cookie_name'] = 'ci_session';

$config['sess_expiration'] = 7200;

$config['sess_save_path'] = NULL;

$config['sess_match_ip'] = FALSE;

$config['sess_time_to_update'] = 300;

$config['sess_regenerate_destroy'] = FALSE;




$config['cookie_prefix']	= '';

$config['cookie_domain']	= '';

$config['cookie_path']		= '/';

$config['cookie_secure']	= FALSE;

$config['cookie_httponly'] 	= FALSE;



/*

|--------------------------------------------------------------------------

| Standardize newlines

|--------------------------------------------------------------------------

|

| Determines whether to standardize newline characters in input data,

| meaning to replace \r\n, \r, \n occurrences with the PHP_EOL value.

|

| WARNING: This feature is DEPRECATED and currently available only

|          for backwards compatibility purposes!

|

*/

$config['standardize_newlines'] = FALSE;



/*

|--------------------------------------------------------------------------

| Global XSS Filtering

|--------------------------------------------------------------------------

|

| Determines whether the XSS filter is always active when GET, POST or

| COOKIE data is encountered

|

| WARNING: This feature is DEPRECATED and currently available only

|          for backwards compatibility purposes!

|

*/

$config['global_xss_filtering'] = FALSE;



/*

|--------------------------------------------------------------------------

| Cross Site Request Forgery

|--------------------------------------------------------------------------

| Enables a CSRF cookie token to be set. When set to TRUE, token will be

| checked on a submitted form. If you are accepting user data, it is strongly

| recommended CSRF protection be enabled.

|

| 'csrf_token_name' = The token name

| 'csrf_cookie_name' = The cookie name

| 'csrf_expire' = The number in seconds the token should expire.

| 'csrf_regenerate' = Regenerate token on every submission

| 'csrf_exclude_uris' = Array of URIs which ignore CSRF checks

*/

$config['csrf_protection'] = FALSE;

$config['csrf_token_name'] = 'csrf_test_name';

$config['csrf_cookie_name'] = 'csrf_cookie_name';

$config['csrf_expire'] = 7200;

$config['csrf_regenerate'] = TRUE;

$config['csrf_exclude_uris'] = array();



/*

|--------------------------------------------------------------------------

| Output Compression

|--------------------------------------------------------------------------

|

| Enables Gzip output compression for faster page loads.  When enabled,

| the output class will test whether your server supports Gzip.

| Even if it does, however, not all browsers support compression

| so enable only if you are reasonably sure your visitors can handle it.

|

| Only used if zlib.output_compression is turned off in your php.ini.

| Please do not use it together with httpd-level output compression.

|

| VERY IMPORTANT:  If you are getting a blank page when compression is enabled it

| means you are prematurely outputting something to your browser. It could

| even be a line of whitespace at the end of one of your scripts.  For

| compression to work, nothing can be sent before the output buffer is called

| by the output class.  Do not 'echo' any values with compression enabled.

|

*/

$config['compress_output'] = FALSE;



/*

|--------------------------------------------------------------------------

| Master Time Reference

|--------------------------------------------------------------------------

|

| Options are 'local' or any PHP supported timezone. This preference tells

| the system whether to use your server's local time as the master 'now'

| reference, or convert it to the configured one timezone. See the 'date

| helper' page of the user guide for information regarding date handling.

|

*/

$config['time_reference'] = 'local';



/*

|--------------------------------------------------------------------------

| Rewrite PHP Short Tags

|--------------------------------------------------------------------------

|

| If your PHP installation does not have short tag support enabled CI

| can rewrite the tags on-the-fly, enabling you to utilize that syntax

| in your view files.  Options are TRUE or FALSE (boolean)

|

| Note: You need to have eval() enabled for this to work.

|

*/

$config['rewrite_short_tags'] = FALSE;



/*

|--------------------------------------------------------------------------

| Reverse Proxy IPs

|--------------------------------------------------------------------------

|

| If your server is behind a reverse proxy, you must whitelist the proxy

| IP addresses from which CodeIgniter should trust headers such as

| HTTP_X_FORWARDED_FOR and HTTP_CLIENT_IP in order to properly identify

| the visitor's IP address.

|

| You can use both an array or a comma-separated list of proxy addresses,

| as well as specifying whole subnets. Here are a few examples:

|

| Comma-separated:	'10.0.1.200,192.168.5.0/24'

| Array:		array('10.0.1.200', '192.168.5.0/24')

*/

$config['proxy_ips'] = '';



// $config['stripepublickey'] = 'pk_test_51LInCICKNkVzs5BegeAi1vhzp1uCP8q3kR6rHevR76BNfLBZp2ZihMzURl8yJPZtVd48zT1D5WMdZsf5ajGxDjSQ00Wyky0eW1';
// $config['stripeseckey'] = 'sk_test_51LInCICKNkVzs5BeActvdJzGndF0ISRDGQBTyDNapus5e9PmHKLI7Y0Qj3dWiJ3tzsOgZnqFAtf9feFPS4UTTbtD00WcBWrgtJ';

$config['stripepublickey'] = 'pk_test_51LQDdeDeQrXI0acIXCvX2m429AWaovMEmXFVN6SBi69rcHq4OdnB8InxYNfopm4iLQPXTzdIqPuIgEcszjSe6tDZ00wFMEe2Rj';
$config['stripeseckey'] = 'sk_test_51LQDdeDeQrXI0acIqfiacZLNcIWL99WxczGaBqViQtcc1FWSc7SEiwH1Sr8OcP7lRYrBEvvWW683hEz6SdDBFMlt00zl06CwYu';
$config['stripewebhookkey'] = 'whsec_QNqvbsGPUL7bt9HErECjD0WYdMsFGaWZ';

// $config['stripepublickey'] = 'pk_live_51LQDdeDeQrXI0acI3SkCP7NHSi3UrYoyDWjoVt3Ztm6gHOIRW95o2rhQ4kEdt3r2kamaP7FHuAxHYcw9Ragr2NCp00lgXUcLVl';
// $config['stripeseckey'] = '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';




function my_load($class) 

{        

    if (strpos($class, 'CI_') !== 0) 

	{            

        if (is_readable(APPPATH . 'core' . DIRECTORY_SEPARATOR . $class . '.php' )) 

		{                

            require_once (APPPATH . 'core' . DIRECTORY_SEPARATOR . $class . '.php');                

        }

    }

}



spl_autoload_register('my_load');
