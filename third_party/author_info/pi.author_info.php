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
  'pi_description'  => 'Provides additional information about the author of a'
                        .' Channel entry.',
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
    return <<<USAGE
## Overview
Author Info provides additional information about the author of a Channel entry.
It is intended for use within a standard {exp:channel:entries} tag, or
equivalent.

## Example Usage

    {exp:channel:entries channel='example'}
      {exp:author_info entry_id='{entry_id}'}
      {if no_results}<p>Unable to find the author info.</p>{/if}

      <dl>
        <dt>Author Email</dt>
        <dd>{author:email}</dd>

        <dt>Author Group ID</dt>
        <dd>{author:group_id}</dd>

        <dt>Author Is Admin?</dt>
        <dd>{if author:is_admin}Big Cheese{if:else}Little Minion{/if}</dd>

        <dt>Author Member ID</dt>
        <dd>{author:member_id}</dd>

        <dt>Author Screen Name</dt>
        <dd>{author:screen_name}</dd>

        <dt>Author Username</dt>
        <dd>{author:username}</dd>
      </dl>
      {/exp:author_info}
    {/exp:channel:entries}

## Parameters
The Author Info tag accepts a single mandatory parameter, `entry_id`.

## Single Variables
The following single variables are available for use within the Author Info tag
pair.

`author:email`
: The Member's email address.

`author:group_id`
: The Member's Member Group ID.

`author:is_admin`
: `TRUE` if the Member has Control Panel access, `FALSE` otherwise.

`author:member_id`
: The Member's ID.

`author:screen_name`
: The Member's Screen Name.

`author:username`
: The Member's Username.

USAGE;
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

    // Retrieve the entry ID.
    if ( ! $entry_id = $this->EE->TMPL->fetch_param('entry_id')
      OR ! $author = $this->_pi_model->get_author_info_from_entry_id($entry_id)
    )
    {
      // Abandon all hope.
      return;
    }

    // Parse the tagdata.
    $this->return_data = $this->EE->TMPL->parse_variables_row(
      $this->EE->TMPL->tagdata, $author->to_array('author:'));
  }


}


/* End of file      : pi.author_info.php */
/* File location    : third_party/author_info/pi.author_info.php */