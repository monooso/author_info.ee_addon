<?php

/**
 * Author datatype.
 *
 * @author          Stephen Lewis (http://github.com/experience/)
 * @copyright       Experience Internet
 * @package         Author_info
 */

require_once dirname(__FILE__) .'/EI_datatype.php';

class Author extends EI_datatype
{

  /* --------------------------------------------------------------
   * PUBLIC METHODS
   * ------------------------------------------------------------ */

  /**
   * Constructor.
   *
   * @access  public
   * @param   array    $props    Associative array of property names and values.
   * @return  void
   */
  public function __construct(Array $props = array())
  {
    parent::__construct($props);
  }


  /**
   * Magic 'setter' method.
   *
   * @access  public
   * @param   string    $prop_name    The property to set.
   * @param   mixed     $prop_value   The new property value.
   * @return  void
   */
  public function __set($prop_name, $prop_value)
  {
    if ( ! $this->_is_valid_property($prop_name))
    {
      return;
    }

    // Validate and set the property value.
    switch ($prop_name)
    {
      case 'group_id':
      case 'member_id':
        $this->_set_int_property($prop_name, $prop_value, 1);
        break;

      case 'is_admin':
        $this->_set_bool_property($prop_name, $prop_value);
        break;

      default:
        $this->_props[$prop_name] = $prop_value;
        break;
    }
  }


  /**
   * Resets the instance properties.
   *
   * @access  public
   * @return  Author_info
   */
  public function reset()
  {
    $this->_props = array(
      'email'       => '',
      'group_id'    => 0,
      'is_admin'    => FALSE,
      'member_id'   => 0,
      'username'    => '',
      'screen_name' => ''
    );

    return $this;
  }


}


/* End of file      : author.php */
/* File location    : third_party/author_info/classes/author.php */