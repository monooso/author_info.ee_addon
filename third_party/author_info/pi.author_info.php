<?php if ( ! defined('BASEPATH')) exit('Direct script access not allowed');

/**
 * Author Info plugin.
 *
 * @author          Stephen Lewis (http://github.com/experience/)
 * @copyright       Experience Internet
 * @package         Author_info
 */

$plugin_info = array(
  'pi_author'       => 'Stephen Lewis',
  'pi_author_url'   => 'http://experienceinternet.co.uk/',
  'pi_description'  => 'Provides additional information about the author of a Channel entry.',
  'pi_name'         => 'Author Info',
  'pi_usage'        => Author_info::usage(),
  'pi_version'      => '0.1.0'
);

class Author_info {

  private $EE;
  private $_pi_model;

  public $return_data = '';


  /* --------------------------------------------------------------
   * STATIC METHODS
   * ------------------------------------------------------------ */

  /**
   * Plugin usage information.
   *
   * @access  public
   * @return  string
   */
  public static function usage()
  {
    return 'Provides additional information about the author of a Channel
      entry.';
  }



  /* --------------------------------------------------------------
   * PUBLIC METHODS
   * ------------------------------------------------------------ */

  /**
   * Constructor.
   *
   * @access  public
   * @param   string    $content    Field content if used for field formatting.
   * @return  void
   */
  public function __construct($content = '')
  {
    $this->EE =& get_instance();

    $this->EE->load->add_package_path(PATH_THIRD .'author_info/');

    $this->EE->load->model('author_info_plugin_model');
    $this->_pi_model = $this->EE->author_info_plugin_model;
  }


}


/* End of file      : pi.author_info.php */
/* File location    : third_party/author_info/pi.author_info.php */