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

    // Validate the property value.
    $valid_value = FALSE;

    switch ($prop_name)
    {
      case 'group_id':
        if (valid_int($prop_value, 1))
        {
          $valid_value  = TRUE;
          $prop_value   = intval($prop_value);
        }
        break;

      case 'is_admin':
        if (is_bool($prop_value))
        {
          $valid_value = TRUE;
        }
        break;

      default:
        $valid_value = TRUE;
        break;
    }

    if ($valid_value)
    {
      $this->_props[$prop_name] = $prop_value;
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
      'group_id'    => 0,
      'username'    => '',
      'screen_name' => '',
      'email'       => '',
      'is_admin'    => FALSE
    );

    return $this;
  }


  /**
   * Returns the instance as an associative array.
   *
   * @access public
   * @param  string $prefix Optional key prefix.
   * @return array
   */
  public function to_array($prefix = '')
  {
    $prefix = ($prefix && is_string($prefix))
      ? rtrim($prefix, ':') .':'
      : '';

    $return = array();

    foreach ($this->_props AS $key => $val)
    {
      $return[$prefix .$key] = $val;
    }

    return $return;
  }


}


/* End of file      : author.php */
/* File location    : third_party/author_info/classes/author.php */