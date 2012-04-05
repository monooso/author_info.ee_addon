<?php if ( ! defined('BASEPATH')) exit('Invalid file request');

/**
 * Author Info plugin tests.
 *
 * @author          Stephen Lewis (http://github.com/experience/)
 * @copyright       Experience Internet
 * @package         Author_info
 */

require_once PATH_THIRD .'author_info/pi.author_info.php';
require_once PATH_THIRD .'author_info/models/author_info_plugin_model.php';

class Test_author_info extends Testee_unit_test_case {

  private $_pi_model;
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

    // Generate the mock model.
    Mock::generate('Author_info_plugin_model',
      get_class($this) .'_mock_plugin_model');

    /**
     * The subject loads the models using $this->EE->load->model().
     * Because the Loader class is mocked, that does nothing, so we
     * can just assign the mock models here.
     */

    $this->EE->author_info_plugin_model = $this->_get_mock('plugin_model');

    $this->_pi_model  = $this->EE->author_info_plugin_model;
    $this->_subject   = new Author_info();
  }


}


/* End of file      : test.pi_author_info.php */
/* File location    : third_party/author_info/tests/test.pi_author_info.php */