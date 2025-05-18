<?php
/**
 * Plugin Name: Event Filter
 * Author: Theo
 * Author URI: https://visibleone.com
 * Description: A plugin to filter events by category and type.
 * Version: 1.0
 * textdomain: wp-events-filter
 */

if( ! defined( 'ABSPATH' ) ) {
   exit; // Exit if accessed directly.
}

define('WP_EVENTS_FILTER_VERSION', '1.0');
define('WP_EVENTS_FILTER_DIR', plugin_dir_path(__FILE__));
define('WP_EVENTS_FILTER_URL', plugin_dir_url(__FILE__));

require_once WP_EVENTS_FILTER_DIR . 'includes/post-type.php';
 
class WP_Events_Filter{
   public function __construct(){
      add_action('rest_api_init', [$this, 'register_rest_routes']);
      add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
      add_shortcode('events_filter', [$this, 'event_filter_render_shortcode']);
      
   }
   public function register_rest_routes(){
      register_rest_route('events/v1', '/filter', [
         'methods' => 'GET',
         'callback' => [$this, 'get_events'],
         'permission_callback' => '__return_true',
      ]);
   }
   public function get_events($request){
      $search = sanitize_text_field($request->get_param('search'));
      $event_types = $request->get_param('event_type');
      $event_categories = $request->get_param('event_category');
      $sort = sanitize_text_field($request->get_param('sort'));
      $per_page = absint($request->get_param('per_page')) ?: 6;
      $page = absint($request->get_param('page')) ?: 1;

      if(is_array($event_types)){
         $event_types = array_map('sanitize_text_field', $event_types);
      }

      if(is_array($event_categories)){
         $event_categories = array_map('sanitize_text_field', $event_categories);
      }

      if(!in_array($per_page, array(6,12,24))){
         $per_page = 6;
      }

      $args = array(
         'post_type' => 'event',
         'post_status' => 'publish',
         'posts_per_page' => $per_page,
         'paged' => $page,
      );

      if(!empty($search)){
         $args['s'] = $search;
      }

      $tax_query = array();
      if(!empty($event_types)){
         $tax_query[] = array(
            'taxonomy' => 'event_type',
            'field' => 'slug',
            'terms' => $event_types,
            'operator' => 'IN',
         );
      }

      if(!empty($event_categories)){
         $tax_query[] = array(
            'taxonomy' => 'event_category',
            'field' => 'slug',
            'terms' => $event_categories,
            'operator' => 'IN',
         );
      }

      if(count($tax_query) > 1){
         $tax_query['relation'] = 'AND';
      }

      if(!empty($tax_query)){
         $args['tax_query'] = $tax_query;
      }

      if($sort == 'newest'){
         $args['orderby'] = 'date';
         $args['order'] = 'DESC';
      } elseif($sort == 'oldest'){
         $args['orderby'] = 'date';
         $args['order'] = 'ASC';
      }

      $query = new WP_Query($args);

      $events = array();
      $response = array();

      if($query->have_posts()){
         while($query->have_posts()){
            $query->the_post();
           
            $event_types = wp_get_post_terms(get_the_ID(), 'event_type', array('fields' => 'all'));
            $types = array();
            foreach($event_types as $type){
               $types[] = array(
                  'id' => $type->term_id,
                  'name' => $type->name,
                  'slug' => $type->slug,
               );
            }

            $event_categories = wp_get_post_terms(get_the_ID(), 'event_category', array('fields' => 'all'));
            $categories = array();
            foreach($event_categories as $category){
               $categories[] = array(
                  'id' => $category->term_id,
                  'name' => $category->name,
                  'slug' => $category->slug,
               );
            }

            $thumbnail_id = get_post_thumbnail_id(get_the_ID());
            $thumbnail_url = '';
            $thumbnail_alt = '';
            
            if($thumbnail_id){
               $thumbnail_url = wp_get_attachment_image_url($thumbnail_id, 'full');
               $thumbnail_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true); 
            }

            $events[] = array(
               'id' => get_the_ID(),
               'title' => get_the_title(),
               'permalink' => get_the_permalink(),
               'excerpt' => get_the_excerpt(),
               'date' => get_the_date(),
               'thumbnail' => array(
                  'url' => $thumbnail_url,
                  'alt' => $thumbnail_alt,
               ),
               'types' => $types,
               'categories' => $categories,
            );

         }
         wp_reset_postdata();
      }  

      $response = array(
         'events' => $events,
         'total' => $query->found_posts,
         'total_pages' => $query->max_num_pages,
         'pages' => $query->max_num_pages,
         'current_page' => $page,
      );

      return rest_ensure_response($response);

   }

   public function enqueue_scripts(){
      wp_enqueue_style('events-filter', WP_EVENTS_FILTER_URL . 'assets/style.css', [], '1.0');
      wp_enqueue_script('events-filter', plugin_dir_url(__FILE__) . 'assets/script.js', array('jquery'), '1.0', true);
      wp_localize_script('events-filter', 'wpEventsFilter', [
         'apiUrl' => rest_url('events/v1/filter'),
         'nonce' => wp_create_nonce('wp_rest'),
      ]);
      wp_localize_script('events-filter', 'route', [
        'pluginUrl' => plugin_dir_url(__FILE__) . 'public/'
      ]);
   }

   public function event_filter_render_shortcode($atts){
      $atts = shortcode_atts([
         'per_page' => 6,
      ], $atts, 'events_filter');

      $event_types = get_terms([
         'taxonomy' => 'event_type',
         'hide_empty' => false,
      ]);

      $event_categories = get_terms([
         'taxonomy' => 'event_category',
         'hide_empty' => false,
      ]);

      ob_start();
      include WP_EVENTS_FILTER_DIR . 'templates/events-filter.php';
      return ob_get_clean();
   }
}
new WP_Events_Filter();

register_activation_hook( __FILE__, 'wp_evetns_filter_activate' );
function wp_evetns_filter_activate() {
   $dirs = array(
      WP_EVENTS_FILTER_DIR . 'assets',
      WP_EVENTS_FILTER_DIR . 'includes',
      WP_EVENTS_FILTER_DIR . 'templates',
   );
   foreach ( $dirs as $dir ) {
      if ( ! file_exists( $dir ) ) {
         mkdir( $dir, 0755, true );
      }
   }
   flush_rewrite_rules();
}

register_deactivation_hook( __FILE__, 'wp_evetns_filter_deactivate' );
function wp_evetns_filter_deactivate() {
   flush_rewrite_rules();
}  

?>