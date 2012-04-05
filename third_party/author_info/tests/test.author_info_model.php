<?php if ( ! defined('BASEPATH')) exit('Invalid file request');

/**
 * Author Info model tests.
 *
 * @author          Stephen Lewis (http://github.com/experience/)
 * @copyright       Experience Internet
 * @package         Author_info
 */

require_once PATH_THIRD .'author_info/models/author_info_model.php';

class Test_author_info_model extends Testee_unit_test_case {

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

    $this->_subject = new Author_info_model($this->_package_name,
      $this->_package_title, $this->_package_version, $this->_namespace);
  }


  public function test__get_author_info_from_entry_id__fails_with_invalid_entry_id()
  {
    $s = $this->_subject;

    $this->assertIdentical(FALSE, $s->get_author_info_from_entry_id(0));
    $this->assertIdentical(FALSE, $s->get_author_info_from_entry_id('wibble'));
    $this->assertIdentical(FALSE, $s->get_author_info_from_entry_id(array()));
    $this->assertIdentical(FALSE,
      $s->get_author_info_from_entry_id(new StdClass()));
  }


  public function test__get_author_info_from_entry_id__retrieves_author_info_from_database_and_returns_author_object()
  {
    $entry_id   = 10;
    $db_result  = $this->_get_mock('db_query');
    $db_row     = array(
      'can_access_cp' => 'y',
      'email'         => 'steve@apple.com',
      'group_id'      => '1',
      'member_id'     => '123',
      'screen_name'   => 'Steve Jobs',
      'username'      => 'jobsbody'
    );

    $expected_result = new Author(array(
      'email'         => $db_row['email'],
      'group_id'      => $db_row['group_id'],
      'is_admin'      => TRUE,
      'member_id'     => $db_row['member_id'],
      'screen_name'   => $db_row['screen_name'],
      'username'      => $db_row['username']
    ));

    $select_fields = array(
      'member_groups.can_access_cp',
      'members.email',
      'members.group_id',
      'members.member_id',
      'members.screen_name',
      'members.username'
    );

    $this->EE->db->expectOnce('select', array(implode(', ', $select_fields)));
    $this->EE->db->expectOnce('from', array('members'));
    $this->EE->db->expectCallCount('join', 2);

    $this->EE->db->expectAt(0, 'join', array('member_groups',
      'member_groups.group_id = members.group_id', 'inner'));

    $this->EE->db->expectAt(1, 'join', array('channel_titles',
      'channel_titles.author_id = members.member_id', 'inner'));

    $this->EE->db->expectOnce('where',
      array('channel_titles.entry_id', $entry_id));

    $this->EE->db->expectOnce('limit', array(1));
    $this->EE->db->expectOnce('get');

    $this->EE->db->returnsByReference('get', $db_result);
    $db_result->returns('num_rows', 1);
    $db_result->returns('row_array', $db_row);

    $this->assertIdentical($expected_result,
      $this->_subject->get_author_info_from_entry_id($entry_id));
  }


  public function test__get_author_info_from_entry_id__queries_database_and_returns_false_if_info_not_found()
  {
    $entry_id   = 10;
    $db_result  = $this->_get_mock('db_query');

    $this->EE->db->returnsByReference('get', $db_result);
    $db_result->returns('num_rows', 0);
    $db_result->returns('row_array', FALSE);

    $this->assertIdentical(FALSE,
      $this->_subject->get_author_info_from_entry_id($entry_id));
  }


  public function test__get_package_name__returns_correct_package_name_converted_to_lowercase()
  {
    $this->assertIdentical(strtolower($this->_package_name),
      $this->_subject->get_package_name());
  }


  public function test__get_package_theme_url__pre_240_works_with_trailing_slash()
  {
    if (defined('URL_THIRD_THEMES'))
    {
      $this->pass();
      return;
    }

    $package    = strtolower($this->_package_name);
    $theme_url  = 'http://example.com/themes/';
    $full_url   = $theme_url .'third_party/' .$package .'/';

    $this->EE->config->expectOnce('item', array('theme_folder_url'));
    $this->EE->config->setReturnValue('item', $theme_url);

    $this->assertIdentical($full_url, $this->_subject->get_package_theme_url());
  }


  public function test__get_package_theme_url__pre_240_works_without_trailing_slash()
  {
    if (defined('URL_THIRD_THEMES'))
    {
      $this->pass();
      return;
    }

    $package    = strtolower($this->_package_name);
    $theme_url  = 'http://example.com/themes';
    $full_url   = $theme_url .'/third_party/' .$package .'/';

    $this->EE->config->expectOnce('item', array('theme_folder_url'));
    $this->EE->config->setReturnValue('item', $theme_url);

    $this->assertIdentical($full_url, $this->_subject->get_package_theme_url());
  }


  public function test__get_package_title__returns_correct_package_title()
  {
    $this->assertIdentical($this->_package_title,
      $this->_subject->get_package_title());
  }


  public function test__get_package_version__returns_correct_package_version()
  {
    $this->assertIdentical($this->_package_version,
      $this->_subject->get_package_version());
  }


  public function test__get_site_id__returns_site_id_as_integer()
  {
    $site_id = '100';

    $this->EE->config->expectOnce('item', array('site_id'));
    $this->EE->config->setReturnValue('item', $site_id);

    $this->assertIdentical((int) $site_id, $this->_subject->get_site_id());
  }


}


/* End of file      : test.author_info_model.php */
/* File location    : third_party/author_info/tests/test.author_info_model.php */