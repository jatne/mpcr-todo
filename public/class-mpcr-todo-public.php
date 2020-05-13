<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://malok.dev/
 * @since      1.0.0
 *
 * @package    Mpcr_Todo
 * @subpackage Mpcr_Todo/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Mpcr_Todo
 * @subpackage Mpcr_Todo/public
 * @author     Paweł Malok <pawelmalok@gmail.com>
 */
class Mpcr_Todo_Public
{

  /**
   * The ID of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $plugin_name    The ID of this plugin.
   */
  private $plugin_name;

  /**
   * The version of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $version    The current version of this plugin.
   */
  private $version;

  /**
   * Initialize the class and set its properties.
   *
   * @since    1.0.0
   * @param      string    $plugin_name       The name of the plugin.
   * @param      string    $version    The version of this plugin.
   */
  public function __construct($plugin_name, $version)
  {

    $this->plugin_name = $plugin_name;
    $this->version = $version;

    add_shortcode('mpcr-todo', array($this, 'mpcr_shortcode'));
  }

  public function update_mpcr_todo_items()
  {
    $todo_id = $_POST['todo_id'];
    $todo_data = $_POST['todo_data'];

    check_ajax_referer('ajax_post_validation', 'ajaxnonce');

    update_post_meta($todo_id, $this->plugin_name . '_items', $todo_data);
  }

  public function mpcr_shortcode(array $atts)
  {
    if (!array_key_exists('id', $atts)) {
      return null;
    }

    ob_start();
    include 'partials/mpcr-todo-public-display.php';

    return ob_get_clean();
  }

  /**
   * Register the stylesheets for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_styles()
  {

    /**
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in Mpcr_Todo_Loader as all of the hooks are defined
     * in that particular class.
     *
     * The Mpcr_Todo_Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */

    wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/mpcr-todo-public.css', array(), $this->version, 'all');
    wp_enqueue_style($this->plugin_name . '-font', 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap', array(), $this->version, 'all');
  }

  /**
   * Register the JavaScript for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_scripts()
  {

    /**
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in Mpcr_Todo_Loader as all of the hooks are defined
     * in that particular class.
     *
     * The Mpcr_Todo_Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */

    wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/mpcr-todo-public.js', array('jquery'), $this->version, false);

    wp_localize_script($this->plugin_name, 'ajax_object', array(
      'ajaxurl' => admin_url('admin-ajax.php'),
      'ajaxnonce' => wp_create_nonce('ajax_post_validation')
    ));
  }
}
