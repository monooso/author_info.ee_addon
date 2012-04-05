<?php if ( ! defined('BASEPATH')) exit('Direct script access not allowed');

/**
 * Author Info 'Package' model.
 *
 * @author          Stephen Lewis (http://github.com/experience/)
 * @copyright       Experience Internet
 * @package         Author_info
 * @version         1.0.0
 */

require_once dirname(__FILE__) .'/../config.php';
require_once dirname(__FILE__) .'/../classes/author.php';
require_once dirname(__FILE__) .'/../helpers/EI_number_helper.php';


class Author_info_model extends CI_Model {

  protected $EE;
  protected $_namespace;
  protected $_package_name;
  protected $_package_title;
  protected $_package_version;
  protected $_site_id;


  /* --------------------------------------------------------------
   * PUBLIC METHODS
   * ------------------------------------------------------------ */

  /**
   * Constructor.
   *
   * @access  public
   * @param   string    $package_name       Package name. Used for testing.
   * @param   string    $package_title      Package title. Used for testing.
   * @param   string    $package_version    Package version. Used for testing.
   * @param   string    $namespace          Session namespace. Used for testing.
   * @return  void
   */
  public function __construct($package_name = '', $package_title = '',
    $package_version = '', $namespace = ''
  )
  {
    parent::__construct();

    $this->EE =& get_instance();

    // Load the OmniLogger class.
    if (file_exists(PATH_THIRD .'omnilog/classes/omnilogger.php'))
    {
      include_once PATH_THIRD .'omnilog/classes/omnilogger.php';
    }

    $this->_namespace = $namespace ? strtolower($namespace) : 'experience';

    $this->_package_name = $package_name
      ? strtolower($package_name) : strtolower(AUTHOR_INFO_NAME);

    $this->_package_title = $package_title
      ? $package_title : AUTHOR_INFO_TITLE;

    $this->_package_version = $package_version
      ? $package_version : AUTHOR_INFO_VERSION;

    // Initialise the add-on cache.
    if ( ! array_key_exists($this->_namespace, $this->EE->session->cache))
    {
      $this->EE->session->cache[$this->_namespace] = array();
    }

    if ( ! array_key_exists($this->_package_name,
      $this->EE->session->cache[$this->_namespace]))
    {
      $this->EE->session->cache[$this->_namespace]
        [$this->_package_name] = array();
    }
  }


  /**
   * Returns the author info for the given entry.
   *
   * @access public
   * @param  int|string $entry_id The Channel entry ID.
   * @return FALSE|Author
   */
  public function get_author_info_from_entry_id($entry_id)
  {
    if ( ! valid_int($entry_id, 1))
    {
      return FALSE;
    }

    $select_fields = array(
      'member_groups.can_access_cp',
      'members.email',
      'members.group_id',
      'members.member_id',
      'members.screen_name',
      'members.username'
    );

    $db_author = $this->EE->db
      ->select(implode(', ', $select_fields))
      ->from('members')
      ->join('member_groups', 'member_groups.group_id = members.group_id',
        'inner')
      ->join('channel_titles', 'channel_titles.author_id = members.member_id',
        'inner')
      ->where('channel_titles.entry_id', $entry_id)
      ->limit(1)
      ->get();

    if ( ! $db_author->num_rows())
    {
      return FALSE;
    }

    $author_data = $db_author->row_array();
    $author_data['is_admin'] = ($author_data['can_access_cp'] == 'y');
    unset($author_data['can_access_cp']);

    return new Author($author_data);
  }


  /**
   * Returns the package name.
   *
   * @access  public
   * @return  string
   */
  public function get_package_name()
  {
    return $this->_package_name;
  }


  /**
   * Returns the package theme URL.
   *
   * @access  public
   * @return  string
   */
  public function get_package_theme_url()
  {
    // Much easier as of EE 2.4.0.
    if (defined('URL_THIRD_THEMES'))
    {
      return URL_THIRD_THEMES .$this->get_package_name() .'/';
    }

    // Old school.
    $theme_url = $this->EE->config->item('theme_folder_url');
    $theme_url .= substr($theme_url, -1) == '/'
      ? 'third_party/' : '/third_party/';

    return $theme_url .$this->get_package_name() .'/';
  }


  /**
   * Returns the package title.
   *
   * @access  public
   * @return  string
   */
  public function get_package_title()
  {
    return $this->_package_title;
  }


  /**
   * Returns the package version.
   *
   * @access  public
   * @return  string
   */
  public function get_package_version()
  {
    return $this->_package_version;
  }


  /**
   * Returns the site ID.
   *
   * @access  public
   * @return  int
   */
  public function get_site_id()
  {
    if ( ! $this->_site_id)
    {
      $this->_site_id = (int) $this->EE->config->item('site_id');
    }

    return $this->_site_id;
  }


  /**
   * Logs a message to OmniLog.
   *
   * @access  public
   * @param   string      $message        The log entry message.
   * @param   int         $severity       The log entry 'level'.
   * @return  void
   */
  public function log_message($message, $severity = 1)
  {
    if (class_exists('Omnilog_entry') && class_exists('Omnilogger'))
    {
      switch ($severity)
      {
        case 3:
          $notify = TRUE;
          $type   = Omnilog_entry::ERROR;
          break;

        case 2:
          $notify = FALSE;
          $type   = Omnilog_entry::WARNING;
          break;

        case 1:
        default:
          $notify = FALSE;
          $type   = Omnilog_entry::NOTICE;
          break;
      }

      $omnilog_entry = new Omnilog_entry(array(
        'addon_name'    => 'Author_info',
        'date'          => time(),
        'message'       => $message,
        'notify_admin'  => $notify,
        'type'          => $type
      ));

      Omnilogger::log($omnilog_entry);
    }
  }


  /* --------------------------------------------------------------
   * PRIVATE METHODS
   * ------------------------------------------------------------ */

  /**
   * Returns a references to the package cache. Should be called
   * as follows: $cache =& $this->_get_package_cache();
   *
   * @access  private
   * @return  array
   */
  protected function &_get_package_cache()
  {
    return $this->EE->session->cache[$this->_namespace][$this->_package_name];
  }


}


/* End of file      : author_info_model.php */
/* File location    : third_party/author_info/models/author_info_model.php */