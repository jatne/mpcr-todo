<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://malok.dev/
 * @since      1.0.0
 *
 * @package    Mpcr_Todo
 * @subpackage Mpcr_Todo/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mpcr_Todo
 * @subpackage Mpcr_Todo/admin
 * @author     Paweł Malok <pawelmalok@gmail.com>
 */
class Mpcr_Todo_Admin
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
   * @param      string    $plugin_name       The name of this plugin.
   * @param      string    $version    The version of this plugin.
   */
  public function __construct($plugin_name, $version)
  {

    $this->plugin_name = $plugin_name;
    $this->version = $version;

    add_action('init', array($this, 'register_cpt'));
    add_action('add_meta_boxes_mpcr_todo', array($this, 'setup_cpt_meta_box'));
    add_action('save_post_mpcr_todo', array($this, 'save_cpt_meta_box_data'));

    add_filter('manage_mpcr_todo_posts_columns', array($this, 'shortcode_cpt_column'));
    add_action('manage_mpcr_todo_posts_custom_column', array($this, 'fill_shortcode_cpt_column'), 10, 2);
  }

  /**
   * CPT for To-Do's
   *
   */
  public function register_cpt()
  {
    $cptArgs = [
      'label' => 'MPCR To-Do',
      'labels' => [
        'name' => 'MPCR To-Do',
        'singular_name' => 'MPCR To-Do',
        'add_new' => __('Dodaj listę', 'mpcr-todo'),
        'add_new_item' => __('Dodaj nową listę', 'mpcr-todo'),
        'edit_item' => __('Edytuj listę', 'mpcr-todo'),
        'new_item' => __('Nowa lista', 'mpcr-todo'),
        'view_item' => __('Zobacz listę', 'mpcr-todo'),
        'search_items' => __('Szukaj listy', 'mpcr-todo'),
        'not_found' => __('Nie znaleziono', 'mpcr-todo'),
        'not_found_in_trash' => __('Nie znaleziono w koszu', 'mpcr-todo'),
      ],
      'menu_name' => 'MPCR To-Do',
      'name_admin_bar' => 'MPCR To-Do',
      'menu_icon' => 'dashicons-editor-ul',
      'public' => true,
      'description' => __('MPCR To-Do', 'mpcr-todo'),
      'exclude_from_search' => true,
      'publicly_queryable' => false,
      'rewrite' => false,
      'show_ui' => true,
      'show_in_menu' => true,
      'supports' => ['title']
    ];

    register_post_type('mpcr_todo', $cptArgs);
  }

  public function setup_cpt_meta_box()
  {
    add_meta_box('cpt_data_meta_box', 'MPCR To-Do', [$this, 'cpt_data_meta_box'], 'mpcr_todo', 'normal', 'high');
  }

  public function cpt_data_meta_box($post)
  {
    include 'partials/mpcr-todo-cpt-meta-box.php';
  }

  public function save_cpt_meta_box_data($post_id)
  {
    $mpcrDataValues = $_POST['mpcr'];

    if (!isset($_POST[$this->plugin_name . '_list_meta_box_nonce'])) {
      return;
    }

    if (!wp_verify_nonce($_POST[$this->plugin_name . '_list_meta_box_nonce'], $this->plugin_name . '_list_meta_box')) {
      return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
    }

    if (!current_user_can('edit_post', $post_id)) {
      return;
    }

    if (!isset($mpcrDataValues)) {
      return;
    }

    update_post_meta($post_id, $this->plugin_name . '_items', json_encode($mpcrDataValues, JSON_UNESCAPED_UNICODE));
  }

  public function shortcode_cpt_column($columns)
  {
    unset($columns['date']);
    $columns['shortcode'] = 'Shortcode';
    $columns['date'] = 'Data';

    return $columns;
  }

  public function fill_shortcode_cpt_column($column, $post_id)
  {
    echo '<code>[mpcr-todo id="' . $post_id . '"]</code>';
  }

  /**
   * Register the stylesheets for the admin area.
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
    global $post_type;

    if ($post_type === 'mpcr_todo') {
      wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/mpcr-todo-admin.css', array(), $this->version, 'all');
    }
  }

  /**
   * Register the JavaScript for the admin area.
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

    global $post_type;

    if ($post_type === 'mpcr_todo') {
      wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/mpcr-todo-admin.js', array(), $this->version, true);
    }
  }
}
