<?php

/**
 * Author Info NSM Add-on Updater information.
 *
 * @author          Stephen Lewis (http://github.com/experience/)
 * @copyright       Experience Internet
 * @package         Author Info
 * @version         1.0.1
 */

if ( ! defined('AUTHOR_INFO_NAME'))
{
  define('AUTHOR_INFO_NAME', 'Author_info');
  define('AUTHOR_INFO_TITLE', 'Author Info');
  define('AUTHOR_INFO_VERSION', '1.0.1');
}

$config['name']     = AUTHOR_INFO_NAME;
$config['version']  = AUTHOR_INFO_VERSION;
$config['nsm_addon_updater']['versions_xml']
  = 'http://experienceinternet.co.uk/software/feeds/author-info';

/* End of file      : config.php */
/* File location    : third_party/author_info/config.php */
