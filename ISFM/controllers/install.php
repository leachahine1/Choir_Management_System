<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Install extends CI_Controller {

    /**
     * This controller is using for install this software. 
     *
     * Maps to the following URL
     * 		http://rehearsalple.com/index.php/install
     * 	- or -  
     * 		http://rehearsalple.com/index.php/install/<method_name>
     * 
     * After installing this softwarte this controller deleted automatic.
     * 
     */
    public function index() {
        if ($this->input->post('submit', TRUE)) {
            $host = $this->input->post('hostName', TRUE);
            $username = $this->input->post('userName', TRUE);
            $password = $this->input->post('password', TRUE);
            $dbname = $this->input->post('databaseName', TRUE);
            $baseUrl = $this->input->post('baseUrl', TRUE);

            $dbcontent = '<?php  if ( !defined(\'BASEPATH\')) exit(\'No direct script access allowed\');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the \'Database Connection\'
| page of the User Guide.
|
*/

$active_group = \'default\';
$active_record = TRUE;

$db[\'default\'][\'hostname\'] = \'' . $host . '\';
$db[\'default\'][\'username\'] = \'' . $username . '\';
$db[\'default\'][\'password\'] = \'' . $password . '\';
$db[\'default\'][\'database\'] = \'' . $dbname . '\';
$db[\'default\'][\'dbdriver\'] = \'mysql\';
$db[\'default\'][\'dbprefix\'] = \'\';
$db[\'default\'][\'pconnect\'] = TRUE;
$db[\'default\'][\'db_debug\'] = TRUE;
$db[\'default\'][\'cache_on\'] = FALSE;
$db[\'default\'][\'cachedir\'] = \'\';
$db[\'default\'][\'char_set\'] = \'utf8\';
$db[\'default\'][\'dbcollat\'] = \'utf8_general_ci\';
$db[\'default\'][\'swap_pre\'] = \'\';
$db[\'default\'][\'autoinit\'] = TRUE;
$db[\'default\'][\'stricton\'] = FALSE;


/* End of file database.php */
/* Location: ./application/config/database.php */
';
            $database = fopen(APPPATH . 'config/database.php', "w");
            $file_contents = $dbcontent;
            fwrite($database, $file_contents);
            fclose($database);
            $cofigFileContent = '<?php
if (!defined(\'BASEPATH\')) {
    exit(\'No direct script access allowed\');
}

/*
  |--------------------------------------------------------------------------
  | Base Site URL
  |--------------------------------------------------------------------------
  |
  | URL to your CodeIgniter root. Typically this will be your base URL,
  | WITH a trailing slash:
  |
  |	http://rehearsalple.com/
  |
  | If this is not set then CodeIgniter will guess the protocol, domain and
  | path to your installation.
  |
 */
$config[\'base_url\'] =\'' . $baseUrl . '\';
/*
  |--------------------------------------------------------------------------
  | Index File
  |--------------------------------------------------------------------------
  |
  | Typically this will be your index.php file, unless you\'ve renamed it to
  | something else. If you are using mod_rewrite to remove the page set this
  | variable so that it is blank.
  |
 */
$config[\'index_page\'] = \'index.php\';

/*
  |--------------------------------------------------------------------------
  | URI PROTOCOL
  |--------------------------------------------------------------------------
  |
  | This item determines which server global should be used to retrieve the
  | URI string.  The default setting of \'AUTO\' works for most servers.
  | If your links do not seem to work, try one of the other delicious flavors:
  |
  | \'AUTO\'			Default - auto detects
  | \'PATH_INFO\'		Uses the PATH_INFO
  | \'QUERY_STRING\'	Uses the QUERY_STRING
  | \'REQUEST_URI\'		Uses the REQUEST_URI
  | \'ORIG_PATH_INFO\'	Uses the ORIG_PATH_INFO
  |
 */
$config[\'uri_protocol\'] = \'AUTO\';

/*
  |--------------------------------------------------------------------------
  | URL suffix
  |--------------------------------------------------------------------------
  |
  | This option allows you to add a suffix to all URLs generated by CodeIgniter.
  | For more information please see the user guide:
  |
  | http://codeigniter.com/user_guide/general/urls.html
 */

$config[\'url_suffix\'] = \'\';

/*
  |--------------------------------------------------------------------------
  | Default Language
  |--------------------------------------------------------------------------
  |
  | This determines which set of language files should be used. Make sure
  | there is an available translation if you intend to use something other
  | than english.
  |
 */
$config[\'language\'] = \'english\';

/*
  |--------------------------------------------------------------------------
  | Default Character Set
  |--------------------------------------------------------------------------
  |
  | This determines which character set is used by default in various methods
  | that require a character set to be provided.
  |
 */
$config[\'charset\'] = \'UTF-8\';

/*
  |--------------------------------------------------------------------------
  | Enable/Disable System Hooks
  |--------------------------------------------------------------------------
  |
  | If you would like to use the \'hooks\' feature you must enable it by
  | setting this variable to TRUE (boolean).  See the user guide for details.
  |
 */
$config[\'enable_hooks\'] = FALSE;


/*
  |--------------------------------------------------------------------------
  | Choir Extension Prefix
  |--------------------------------------------------------------------------
  |
  | This item allows you to set the filename/classname prefix when extending
  | native libraries.  For more information please see the user guide:
  |
  | http://codeigniter.com/user_guide/general/core_classes.html
  | http://codeigniter.com/user_guide/general/creating_libraries.html
  |
 */
$config[\'subclass_prefix\'] = \'MY_\';


/*
  |--------------------------------------------------------------------------
  | Allowed URL Characters
  |--------------------------------------------------------------------------
  |
  | This lets you specify with a regular expression which characters are permitted
  | within your URLs.  When someone tries to submit a URL with disallowed
  | characters they will get a warning message.
  |
  | As a security measure you are STRONGLY encouraged to restrict URLs to
  | as few characters as possible.  By default only these are allowed: a-z 0-9~%.:_-
  |
  | Leave blank to allow all characters -- but only if you are insane.
  |
  | DO NOT CHANGE THIS UNLESS YOU FULLY UNDERSTAND THE REPERCUSSIONS!!
  |
 */
$config[\'permitted_uri_chars\'] = \'\#\';


/*
  |--------------------------------------------------------------------------
  | Enable Query Strings
  |--------------------------------------------------------------------------
  |
  | By default CodeIgniter uses search-engine friendly segment based URLs:
  | rehearsalple.com/who/what/where/
  |
  | By default CodeIgniter enables access to the $_GET array.  If for some
  | reason you would like to disable it, set \'allow_get_array\' to FALSE.
  |
  | You can optionally enable standard query string based URLs:
  | rehearsalple.com?who=me&what=something&where=here
  |
  | Options are: TRUE or FALSE (boolean)
  |
  | The other items let you set the query string \'words\' that will
  | invoke your controllers and its functions:
  | rehearsalple.com/index.php?c=controller&m=function
  |
  | Please note that some of the helpers won\'t work as expected when
  | this feature is enabled, since CodeIgniter is designed primarily to
  | use segment based URLs.
  |
 */
$config[\'allow_get_array\'] = TRUE;
$config[\'enable_query_strings\'] = TRUE;
$config[\'controller_trigger\'] = \'module\';
$config[\'function_trigger\'] = \'view\';
$config[\'directory_trigger\'] = \'d\'; // experimental not currently in use

/*
  |--------------------------------------------------------------------------
  | Error Logging Threshold
  |--------------------------------------------------------------------------
  |
  | If you have enabled error logging, you can set an error threshold to
  | determine what gets logged. Threshold options are:
  | You can enable error logging by setting a threshold over zero. The
  | threshold determines what gets logged. Threshold options are:
  |
  |	0 = Disables logging, Error logging TURNED OFF
  |	1 = Error Messages (including PHP errors)
  |	2 = Debug Messages
  |	3 = Informational Messages
  |	4 = All Messages
  |
  | For a live site you\'ll usually only enable Errors (1) to be logged otherwise
  | your log files will fill up very fast.
  |
 */
$config[\'log_threshold\'] = 0;

/*
  |--------------------------------------------------------------------------
  | Error Logging Directory Path
  |--------------------------------------------------------------------------
  |
  | Leave this BLANK unless you would like to set something other than the default
  | application/logs/ folder. Use a full server path with trailing slash.
  |
 */
$config[\'log_path\'] = \'\';

/*
  |--------------------------------------------------------------------------
  | Date Format for Logs
  |--------------------------------------------------------------------------
  |
  | Each item that is logged has an associated date. You can use PHP date
  | codes to set your own date formatting
  |
 */
$config[\'log_date_format\'] = \'Y-m-d H:i:s\';

/*
  |--------------------------------------------------------------------------
  | Cache Directory Path
  |--------------------------------------------------------------------------
  |
  | Leave this BLANK unless you would like to set something other than the default
  | system/cache/ folder.  Use a full server path with trailing slash.
  |
 */
$config[\'cache_path\'] = \'\';

/*
  |--------------------------------------------------------------------------
  | Encryption Key
  |--------------------------------------------------------------------------
  |
  | If you use the Encryption class or the Session class you
  | MUST set an encryption key.  See the user guide for info.
  |
 */
$config[\'encryption_key\'] = \'\$O!m%a)R.F%^&aU243Q\';

/*
  |--------------------------------------------------------------------------
  | Session Variables
  |--------------------------------------------------------------------------
  |
  | \'sess_cookie_name\'		= the name you want for the cookie
  | \'sess_expiration\'			= the number of SECONDS you want the session to last.
  |   by default sessions last 7200 seconds (two hours).  Set to zero for no expiration.
  | \'sess_expire_on_close\'	= Whether to cause the session to expire automatically
  |   when the browser window is closed
  | \'sess_encrypt_cookie\'		= Whether to encrypt the cookie
  | \'sess_use_database\'		= Whether to save the session data to a database
  | \'sess_table_name\'			= The name of the session database table
  | \'sess_match_ip\'			= Whether to match the user\'s IP address when reading the session data
  | \'sess_match_useragent\'	= Whether to match the User Agent when reading the session data
  | \'sess_time_to_update\'		= how many seconds between CI refreshing Session Information
  |
 */
$config[\'sess_cookie_name\'] = \'ci_session\';
$config[\'sess_expiration\'] = 7200;
$config[\'sess_expire_on_close\'] = FALSE;
$config[\'sess_encrypt_cookie\'] = FALSE;
$config[\'sess_use_database\'] = FALSE;
$config[\'sess_table_name\'] = \'ci_sessions\';
$config[\'sess_match_ip\'] = FALSE;
$config[\'sess_match_useragent\'] = TRUE;
$config[\'sess_time_to_update\'] = 300;

/*
  |--------------------------------------------------------------------------
  | Cookie Related Variables
  |--------------------------------------------------------------------------
  |
  | \'cookie_prefix\' = Set a prefix if you need to avoid collisions
  | \'cookie_domain\' = Set to .your-domain.com for site-wide cookies
  | \'cookie_path\'   =  Typically will be a forward slash
  | \'cookie_secure\' =  Cookies will only be set if a secure HTTPS connection exists.
  |
 */
$config[\'cookie_prefix\'] = \'\';
$config[\'cookie_domain\'] = \'\';
$config[\'cookie_path\'] = \'/\';
$config[\'cookie_secure\'] = FALSE;

/*
  |--------------------------------------------------------------------------
  | Global XSS Filtering
  |--------------------------------------------------------------------------
  |
  | Determines whether the XSS filter is always active when GET, POST or
  | COOKIE data is encountered
  |
 */
$config[\'global_xss_filtering\'] = TRUE;

/*
  |--------------------------------------------------------------------------
  | Cross Site Request Forgery
  |--------------------------------------------------------------------------
  | Enables a CSRF cookie token to be set. When set to TRUE, token will be
  | checked on a submitted form. If you are accepting user data, it is strongly
  | recommended CSRF protection be enabled.
  |
  | \'csrf_token_name\' = The token name
  | \'csrf_cookie_name\' = The cookie name
  | \'csrf_expire\' = The number in seconds the token should expire.
 */
$config[\'csrf_protection\'] = TRUE;
$config[\'csrf_token_name\'] = \'csrf_test_name\';
$config[\'csrf_cookie_name\'] = \'csrf_cookie_name\';
$config[\'csrf_expire\'] = 7200;

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
  | VERY IMPORTANT:  If you are getting a blank page when compression is enabled it
  | means you are prematurely outputting something to your browser. It could
  | even be a line of whitespace at the end of one of your scripts.  For
  | compression to work, nothing can be sent before the output buffer is called
  | by the output class.  Do not \'echo\' any values with compression enabled.
  |
 */
$config[\'compress_output\'] = FALSE;

/*
  |--------------------------------------------------------------------------
  | Master Time Reference
  |--------------------------------------------------------------------------
  |
  | Options are \'local\' or \'gmt\'.  This pref tells the system whether to use
  | your server\'s local time as the master \'now\' reference, or convert it to
  | GMT.  See the \'date helper\' page of the user guide for information
  | regarding date handling.
  |
 */
$config[\'time_reference\'] = \'local\';


/*
  |--------------------------------------------------------------------------
  | Rewrite PHP Short Tags
  |--------------------------------------------------------------------------
  |
  | If your PHP installation does not have short tag support enabled CI
  | can rewrite the tags on-the-fly, enabling you to utilize that syntax
  | in your view files.  Options are TRUE or FALSE (boolean)
  |
 */
$config[\'rewrite_short_tags\'] = FALSE;


/*
  |--------------------------------------------------------------------------
  | Reverse Proxy IPs
  |--------------------------------------------------------------------------
  |
  | If your server is behind a reverse proxy, you must whitelist the proxy IP
  | addresses from which CodeIgniter should trust the HTTP_X_FORWARDED_FOR
  | header in order to properly identify the visitor\'s IP address.
  | Comma-delimited, e.g. \'10.0.1.200,10.0.1.201\'
  |
 */
$config[\'proxy_ips\'] = \'\';


/* End of file config.php */
/* Location: ./application/config/config.php */';
            
            $cofigFile = fopen(APPPATH . 'config/config.php', 'w');
            $file_contents = $cofigFileContent;
            fwrite($cofigFile, $file_contents);
            fclose($cofigFile);

            $routesContent = '<?php

if (!defined(\'BASEPATH\')) {
    exit(\'No direct script access allowed\');
}
/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	rehearsalple.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |	$route[\'default_controller\'] = \'welcome\';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above rehearsalple, the "welcome" class
  | would be loaded.
  |
  |	$route[\'404_override\'] = \'errors/page_missing\';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */

$route[\'default_controller\'] = "auth";
$route[\'404_override\'] = \'\';


/* End of file routes.php */
/* Location: ./application/config/routes.php */';
            
            $routhFile = fopen(APPPATH . 'config/routes.php', 'w');
            $file_contents = $routesContent;
            fwrite($routhFile, $file_contents);
            fclose($routhFile);
            
            $testText = 'This is test';
            $rFile = fopen(APPPATH . 'third_party/MX/test.php', 'w');
            $file_contents = $testText;
            fwrite($rFile, $file_contents);
            fclose($rFile);
            
//            redirect('install/makeDb');
        } else {
            $this->load->view('install');
        }
    }

    public function makeDb() {

        $this->db->query('CREATE TABLE IF NOT EXISTS `account_title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_title` varchar(100) NOT NULL,
  `category` varchar(20) NOT NULL,
  `description` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `add_rehearsal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rehearsal_title` varchar(100) NOT NULL,
  `start_date` varchar(30) NOT NULL,
  `Choir_title` varchar(50) NOT NULL,
  `total_time` varchar(10) NOT NULL,
  `publish` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');


        $this->db->query('CREATE TABLE IF NOT EXISTS `resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resources_title` varchar(100) NOT NULL,
  `authore` varchar(150) NOT NULL,
  `category` varchar(100) NOT NULL,
  `edition` varchar(100) NOT NULL,
  `resources_amount` varchar(20) NOT NULL,
  `description` varchar(300) NOT NULL,
  `date` date NOT NULL,
  `pages` int(11) NOT NULL,
  `uploderTitle` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `resources_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_creator` varchar(100) NOT NULL,
  `category_title` varchar(100) NOT NULL,
  `section_trainer_category` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `resources_amount` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');


        $this->db->query('CREATE TABLE IF NOT EXISTS `resources_in_out` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_id` int(11) NOT NULL,
  `Choir_member_id` varchar(100) NOT NULL,
  `out_date` varchar(100) NOT NULL,
  `in_date` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `Choir_member_fine` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');


        $this->db->query('CREATE TABLE IF NOT EXISTS `Choir` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Choir_title` varchar(50) NOT NULL,
  `Choir_group` varchar(150) NOT NULL,
  `section` varchar(100) NOT NULL,
  `section_Choir_member_capacity` varchar(5) NOT NULL,
  `ChoirCode` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `Choir_routine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Choir_title` varchar(50) NOT NULL,
  `section` varchar(100) NOT NULL,
  `day_title` varchar(50) NOT NULL,
  `song` varchar(300) NOT NULL,
  `song_section_leader` varchar(200) NOT NULL,
  `start_time` varchar(30) NOT NULL,
  `end_time` varchar(30) NOT NULL,
  `room_number` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');


        $this->db->query('CREATE TABLE IF NOT EXISTS `Choir_Choir_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `Choir_member_info_id` int(11) NOT NULL,
  `roll_number` int(11) DEFAULT NULL,
  `Choir_member_id` varchar(100) NOT NULL,
  `Choir_title` varchar(50) NOT NULL,
  `section` varchar(150) NOT NULL,
  `Choir_member_title` varchar(100) NOT NULL,
  `attendance_percentices_daily` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');


        $this->db->query('CREATE TABLE IF NOT EXISTS `Choir_song` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Choir_title` varchar(100) NOT NULL,
  `song_title` varchar(100) NOT NULL,
  `group` varchar(100) NOT NULL,
  `song_section_leader` varchar(100) NOT NULL,
  `edition` varchar(100) NOT NULL,
  `writer_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `clas_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Choir_id` int(11) NOT NULL,
  `Choir_title` varchar(50) NOT NULL,
  `Choir_member_amount` int(11) NOT NULL,
  `attendance_percentices_daily` int(11) NOT NULL,
  `attend_percentise_yearly` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');


        $this->db->query('CREATE TABLE IF NOT EXISTS `configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logo` varchar(150) NOT NULL,
  `time_zone` varchar(150) NOT NULL,
  `school_name` varchar(150) NOT NULL,
  `starting_year` varchar(50) NOT NULL,
  `headmaster_name` varchar(150) NOT NULL,
  `address` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `currenct` varchar(50) NOT NULL,
  `country` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `config_week_day` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day_name` varchar(20) NOT NULL,
  `status` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `daily_attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(50) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `Choir_member_id` varchar(150) NOT NULL,
  `Choir_title` varchar(30) NOT NULL,
  `section` varchar(100) NOT NULL,
  `days_amount` varchar(20) NOT NULL,
  `roll_no` int(11) NOT NULL,
  `present_or_absent` varchar(2) NOT NULL,
  `Choir_member_title` varchar(100) NOT NULL,
  `Choir_amount_monthly` int(11) NOT NULL,
  `Choir_amount_yearly` int(11) NOT NULL,
  `attend_amount_monthly` int(11) NOT NULL,
  `attend_amount_yearly` int(11) NOT NULL,
  `percentise_month` int(11) NOT NULL,
  `percentise_year` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `employe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `father_name` varchar(150) NOT NULL,
  `mother_name` varchar(150) NOT NULL,
  `birth_date` varchar(100) NOT NULL,
  `sex` varchar(50) NOT NULL,
  `present_address` varchar(150) NOT NULL,
  `permanent_address` varchar(150) NOT NULL,
  `job_title_post` varchar(100) NOT NULL,
  `working_hour` varchar(20) NOT NULL,
  `salary_amount` varchar(100) NOT NULL,
  `educational_qualifation_1` varchar(300) NOT NULL,
  `educational_qualifation_2` varchar(300) NOT NULL,
  `educational_qualifation_3` varchar(300) NOT NULL,
  `educational_qualifation_4` varchar(300) NOT NULL,
  `educational_qualifation_5` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `rehearsal_attendanc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `Choir_member_id` varchar(20) NOT NULL,
  `Choir_member_title` varchar(100) NOT NULL,
  `Choir` varchar(50) NOT NULL,
  `roll_no` varchar(11) NOT NULL,
  `section` varchar(100) NOT NULL,
  `rehearsal_title` varchar(150) NOT NULL,
  `rehearsal_song` varchar(100) NOT NULL,
  `attendance` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `rehearsal_grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grade_name` varchar(30) NOT NULL,
  `point` varchar(4) NOT NULL,
  `number_form` varchar(5) NOT NULL,
  `number_to` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `rehearsal_routine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rehearsal_id` int(11) NOT NULL,
  `rehearsal_date` varchar(30) NOT NULL,
  `rehearsal_song` varchar(100) NOT NULL,
  `song_code` varchar(15) NOT NULL,
  `rome_number` varchar(10) NOT NULL,
  `start_time` varchar(10) NOT NULL,
  `end_time` varchar(30) NOT NULL,
  `rehearsal_shift` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `expense` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(100) NOT NULL,
  `dr_cr` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(300) NOT NULL,
  `account_life_time` int(11) NOT NULL,
  `coreAmount` int(11) NOT NULL,
  `totalAmount` int(11) NOT NULL,
  `totalExpance` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `final_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Choir` varchar(100) NOT NULL,
  `section` varchar(100) NOT NULL,
  `rehearsal_title` varchar(100) NOT NULL,
  `Choir_member_id` varchar(20) NOT NULL,
  `Choir_member_name` varchar(100) NOT NULL,
  `total_mark` varchar(100) NOT NULL,
  `final_grade` varchar(10) NOT NULL,
  `maride_list` varchar(150) NOT NULL,
  `status` varchar(150) NOT NULL,
  `point` varchar(11) NOT NULL,
  `fail_amount` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;');

        $this->db->query("INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User'),
(3, 'Choir_member', 'This user is Choir_member''s groups member.'),
(4, 'section_leader', 'This user is section_leader''s groups member.'),
(5, 'section_trainers', 'This user is section_trainer''s groups member.'),
(6, 'accountant', 'This user is accountent''s groups member.');");

        $this->db->query('CREATE TABLE IF NOT EXISTS `income` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Choir_title` varchar(100) NOT NULL,
  `Choir_member_Id` varchar(100) NOT NULL,
  `Choir_member_name` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `dr_cr` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `account_life_time` varchar(100) NOT NULL,
  `coreAmount` int(11) NOT NULL,
  `totalAmount` int(11) NOT NULL,
  `totalIncom` int(11) NOT NULL,
  `slip_number` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `read_unread` int(1) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `notice_board` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(11) NOT NULL,
  `sender` varchar(50) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `notice` varchar(1000) NOT NULL,
  `receiver` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `section_trainers_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `section` int(11) NOT NULL,
  `Choir_member_Choir` varchar(50) NOT NULL,
  `section_trainers_name` varchar(100) NOT NULL,
  `level` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `result_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Choir_title` varchar(100) NOT NULL,
  `rehearsal_title` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  `publish` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `result_shit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rehearsal_title` varchar(100) NOT NULL,
  `rehearsal_id` int(11) NOT NULL,
  `Choir_title` varchar(100) NOT NULL,
  `section` varchar(100) NOT NULL,
  `Choir_member_name` varchar(100) NOT NULL,
  `Choir_member_id` varchar(100) NOT NULL,
  `rehearsal_song` varchar(100) NOT NULL,
  `mark` varchar(10) NOT NULL,
  `point` varchar(5) NOT NULL,
  `grade` varchar(5) NOT NULL,
  `roll_number` int(11) NOT NULL,
  `result` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `result_submition_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Choir` varchar(100) NOT NULL,
  `section` varchar(100) NOT NULL,
  `rehearsal_title` varchar(150) NOT NULL,
  `date` varchar(50) NOT NULL,
  `song` varchar(100) NOT NULL,
  `submited` varchar(50) NOT NULL,
  `section_leader` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `Choir_member_fee_slip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL,
  `Choir_title` varchar(100) NOT NULL,
  `Choir_member_id` varchar(100) NOT NULL,
  `Choir_member_name` varchar(100) NOT NULL,
  `slip_number` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `Choir_member_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `Choir_member_id` varchar(20) NOT NULL,
  `roll_number` varchar(11) NOT NULL,
  `Choir_member_nam` varchar(100) NOT NULL,
  `Choir` varchar(50) NOT NULL,
  `section` varchar(100) NOT NULL,
  `farther_name` varchar(150) NOT NULL,
  `mother_name` varchar(150) NOT NULL,
  `birth_date` varchar(100) NOT NULL,
  `sex` varchar(30) NOT NULL,
  `present_address` varchar(300) NOT NULL,
  `permanent_address` varchar(300) NOT NULL,
  `father_occupation` varchar(150) NOT NULL,
  `Choir_member_photo` varchar(200) NOT NULL,
  `last_Choir_certificate` varchar(20) NOT NULL,
  `t_c` varchar(20) NOT NULL,
  `academic_transcription` varchar(20) NOT NULL,
  `national_birth_certificate` varchar(20) NOT NULL,
  `testimonial` varchar(20) NOT NULL,
  `documents_info` varchar(500) NOT NULL,
  `date` varchar(50) NOT NULL,
  `father_incom_range` varchar(100) NOT NULL,
  `mother_occupation` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `songs_mark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rehearsal_title` varchar(100) NOT NULL,
  `Choir` varchar(100) NOT NULL,
  `section` varchar(100) NOT NULL,
  `song` varchar(100) NOT NULL,
  `Choir_member_id` varchar(20) NOT NULL,
  `Choir_member_name` varchar(100) NOT NULL,
  `roll_number` int(11) NOT NULL,
  `mark` int(11) NOT NULL,
  `grade` varchar(30) NOT NULL,
  `statud` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `suggestion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Choir` varchar(20) NOT NULL,
  `song` varchar(100) NOT NULL,
  `section_leader` varchar(150) NOT NULL,
  `suggestions` varchar(2500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `section_leaders_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(30) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `farther_name` varchar(150) NOT NULL,
  `mother_name` varchar(150) NOT NULL,
  `birth_date` varchar(150) NOT NULL,
  `sex` varchar(30) NOT NULL,
  `present_address` varchar(300) NOT NULL,
  `permanent_address` varchar(300) NOT NULL,
  `song` varchar(150) NOT NULL,
  `position` varchar(150) NOT NULL,
  `working_hour` varchar(50) NOT NULL,
  `educational_qualification_1` varchar(500) NOT NULL,
  `educational_qualification_2` varchar(500) NOT NULL,
  `educational_qualification_3` varchar(500) NOT NULL,
  `educational_qualification_4` varchar(500) NOT NULL,
  `educational_qualification_5` varchar(500) NOT NULL,
  `cv` varchar(30) NOT NULL,
  `educational_certificat` varchar(30) NOT NULL,
  `exprieance_certificatte` varchar(30) NOT NULL,
  `files_info` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `transport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rout_title` varchar(200) NOT NULL,
  `start_end` varchar(300) NOT NULL,
  `vicles_amount` varchar(20) NOT NULL,
  `descriptions` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $this->db->query('CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `short_description` varchar(200) NOT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `profile_image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;');

        $this->db->query("INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `short_description`, `company`, `phone`, `profile_image`) VALUES
(1, '127.0.0.1', 'admin', '$2y$08\$c0ZwM2naXaNhrNxXU.T4GO2pxSqNqRma3RcwYPPpLGJ2LpflziC.m', '', 'admin@admin.com', '', 'HBj4C30st5pOHbjpHojzGu4667ad49e75655b131', 1420113369, NULL, 1268889823, 1424006940, 1, 'admin', 'test', '0', 'ADMIN', '0', '[000124].jpg');");

        $this->db->query("CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;");

        $this->db->query("INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2);");

        $this->db->query("ALTER TABLE `users_groups`
        ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
        ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;");

        echo '<h1>Your system is ready for using. Thank you.</h1>';
    }

    public function test() {
        $host = $this->input->post('hostName', TRUE);
        $username = $this->input->post('userName', TRUE);
        $password = $this->input->post('password', TRUE);
        $dbname = $this->input->post('databaseName', TRUE);
        $baseUrl = $this->input->post('baseUrl', TRUE);

        $a = array(
            '1' => $host,
            '2' => $username,
            '3' => $password,
            '4' => $dbname,
            '5' => $baseUrl
        );

        echo '<pre>';
        print_r($baseUrl);
        echo '</pre>';
    }

}
