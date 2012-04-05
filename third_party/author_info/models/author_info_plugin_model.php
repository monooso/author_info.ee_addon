<?php if ( ! defined('BASEPATH')) exit('Direct script access not allowed');

/**
 * Author Info plugin model.
 *
 * @author          Stephen Lewis (http://github.com/experience/)
 * @copyright       Experience Internet
 * @package         Author_info
 */

require_once dirname(__FILE__) .'/author_info_model.php';

class Author_info_plugin_model extends Author_info_model {

  /* --------------------------------------------------------------
  * PUBLIC METHODS
  * ------------------------------------------------------------ */

  /**
   * Constructor.
   *
   * @access  public
   * @param   string  $package_name     Package name. Used for testing.
   * @param   string  $package_title    Package title. Used for testing.
   * @param   string  $package_version  Package version. Used for testing.
   * @param   string  $namespace        Session namespace. Used for testing.
   * @return  void
   */
  public function __construct($package_name = '', $package_title = '',
    $package_version = '', $namespace = ''
  )
  {
    parent::__construct($package_name, $package_title, $package_version,
      $namespace);
  }


}


/* End of file      : author_info_plugin_model.php */
/* File location    : third_party/author_info/models/author_info_plugin_model.php */