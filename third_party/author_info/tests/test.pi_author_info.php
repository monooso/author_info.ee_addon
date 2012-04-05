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
  }


  public function test__default_tag__retrieves_entry_id_parameter()
  {
    $entry_id = FALSE;    // Ensures we go no further.
    $tmpl = $this->EE->TMPL;

    $tmpl->expectOnce('fetch_param', array('entry_id'));
    $tmpl->returns('fetch_param', $entry_id, array('entry_id'));

    $subject = new Author_info();
  }


  public function test__default_tag__returns_no_results_if_no_entry_id_parameter()
  {
    $no_results = 'No results.';
    $tmpl       = $this->EE->TMPL;

    $this->_pi_model->expectNever('get_author_info_from_entry_id');

    $tmpl->returns('fetch_param', FALSE, array('entry_id'));
    $tmpl->returns('no_results', $no_results);

    $subject = new Author_info();
    $this->assertIdentical($no_results, $subject->return_data);
  }


  public function test__default_tag__returns_no_results_if_model_returns_false()
  {
    $entry_id   = '10';
    $no_results = 'No results.';
    $tmpl       = $this->EE->TMPL;

    $tmpl->returns('fetch_param', $entry_id, array('entry_id'));
    $tmpl->returns('no_results', $no_results);

    $this->_pi_model->expectOnce('get_author_info_from_entry_id',
      array($entry_id));

    $this->_pi_model->returns('get_author_info_from_entry_id', FALSE);

    $subject = new Author_info();
    $this->assertIdentical($no_results, $subject->return_data);
  }


  public function test__default_tag__retrieves_member_data_and_parses_tagadata()
  {
    $author = new Author(array(
      'email'       => 'bill@microsoft.com',
      'group_id'    => 10,
      'is_admin'    => FALSE,
      'member_id'   => 123,
      'screen_name' => 'Bill Gates',
      'username'    => 'bill.i.am'
    ));

    $entry_id   = '10';
    $parsed     = '<p>Parsed tagdata</p>';
    $tagdata    = '<p>Example tagdata.</p>';
    $tmpl       = $this->EE->TMPL;

    // Retrieve the entry ID parameter.
    $tmpl->returns('fetch_param', $entry_id, array('entry_id'));

    // Retrieve the member info.
    $this->_pi_model->expectOnce('get_author_info_from_entry_id',
      array($entry_id));

    $this->_pi_model->returns('get_author_info_from_entry_id', $author);

    // Retrieve and parse the tagdata.
    $tmpl->tagdata = $tagdata;    // Still no getter.
    $template_data = $author->to_array('author:');

    $tmpl->expectOnce('parse_variables_row', array($tagdata, $template_data));
    $tmpl->returns('parse_variables_row', $parsed);

    $subject = new Author_info();
    $this->assertIdentical($parsed, $subject->return_data);
  }


}


/* End of file      : test.pi_author_info.php */
/* File location    : third_party/author_info/tests/test.pi_author_info.php */