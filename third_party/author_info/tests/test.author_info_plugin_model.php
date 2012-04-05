<?php if ( ! defined('BASEPATH')) exit('Invalid file request');

/**
 * Author Info plugin model tests.
 *
 * @author          Stephen Lewis (http://github.com/experience/)
 * @copyright       Experience Internet
 * @package         Author_info
 */

require_once PATH_THIRD .'author_info/models/author_info_plugin_model.php';

class Test_author_info_plugin_model extends Testee_unit_test_case {

  private $_namespace;
  private $_package_name;
  private $_package_title;
  private $_package_version;
  private $_subject;


  /* --------------------------------------------------------------
   * PUBLIC METHODS
   * ------------------------------------------------------------ */

  /**
   * Constructor.
   *
   * @access  public
   * @return  void
   */
  public function setUp()
  {
    parent::setUp();

    $this->_namespace       = 'com.google';
    $this->_package_name    = 'Example_package';
    $this->_package_title   = 'Example Package';
    $this->_package_version = '1.0.0';

    $this->_subject = new Author_info_plugin_model($this->_package_name,
      $this->_package_title, $this->_package_version, $this->_namespace);
  }


}


/* End of file      : test.author_info_plugin_model.php */
/* File location    : third_party/author_info/tests/test.author_info_plugin_model.php */