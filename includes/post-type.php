
<?php

if(defined('ABSPATH') || exit);
// Register Custom Post Type: Event

function wp_events_filter_register_post_types() {
    $labels = array(
        'name'                  => _x('Events', 'Post type general name', 'wp-events-filter'),
        'singular_name'         => _x('Event', 'Post type singular name', 'wp-events-filter'),
        'menu_name'             => _x('Events', 'Admin Menu text', 'wp-events-filter'),
        'name_admin_bar'        => _x('Event', 'Add New on Toolbar', 'wp-events-filter'),
        'add_new'               => __('Add New', 'wp-events-filter'),
        'add_new_item'          => __('Add New Event', 'wp-events-filter'),
        'new_item'              => __('New Event', 'wp-events-filter'),
        'edit_item'             => __('Edit Event', 'wp-events-filter'),
        'view_item'             => __('View Event', 'wp-events-filter'),
        'all_items'             => __('All Events', 'wp-events-filter'),
        'search_items'          => __('Search Events', 'wp-events-filter'),
        'parent_item_colon'     => __('Parent Events:', 'wp-events-filter'),
        'not_found'             => __('No events found.', 'wp-events-filter'),
        'not_found_in_trash'    => __('No events found in Trash.', 'wp-events-filter'),
        'featured_image'        => _x('Event Cover Image', 'Overrides the "Featured Image" phrase', 'wp-events-filter'),
        'set_featured_image'    => _x('Set cover image', 'Overrides the "Set featured image" phrase', 'wp-events-filter'),
        'remove_featured_image' => _x('Remove cover image', 'Overrides the "Remove featured image" phrase', 'wp-events-filter'),
        'use_featured_image'    => _x('Use as cover image', 'Overrides the "Use as featured image" phrase', 'wp-events-filter'),
        'archives'              => _x('Event archives', 'The post type archive label used in nav menus', 'wp-events-filter'),
        'insert_into_item'      => _x('Insert into event', 'Overrides the "Insert into post" phrase', 'wp-events-filter'),
        'uploaded_to_this_item' => _x('Uploaded to this event', 'Overrides the "Uploaded to this post" phrase', 'wp-events-filter'),
        'filter_items_list'     => _x('Filter events list', 'Screen reader text for the filter links heading on the post type listing screen', 'wp-events-filter'),
        'items_list_navigation' => _x('Events list navigation', 'Screen reader text for the pagination heading on the post type listing screen', 'wp-events-filter'),
        'items_list'            => _x('Events list', 'Screen reader text for the items list heading on the post type listing screen', 'wp-events-filter'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'event'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-calendar-alt',
        'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
        'show_in_rest'       => true,
    );

    register_post_type('event', $args);

     // Register Event Type Taxonomy
    $type_labels = array(
        'name'                       => _x('Event Types', 'taxonomy general name', 'wp-events-filter'),
        'singular_name'              => _x('Event Type', 'taxonomy singular name', 'wp-events-filter'),
        'search_items'               => __('Search Event Types', 'wp-events-filter'),
        'popular_items'              => __('Popular Event Types', 'wp-events-filter'),
        'all_items'                  => __('All Event Types', 'wp-events-filter'),
        'parent_item'                => __('Parent Event Type', 'wp-events-filter'),
        'parent_item_colon'          => __('Parent Event Type:', 'wp-events-filter'),
        'edit_item'                  => __('Edit Event Type', 'wp-events-filter'),
        'update_item'                => __('Update Event Type', 'wp-events-filter'),
        'add_new_item'               => __('Add New Event Type', 'wp-events-filter'),
        'new_item_name'              => __('New Event Type Name', 'wp-events-filter'),
        'separate_items_with_commas' => __('Separate event types with commas', 'wp-events-filter'),
        'add_or_remove_items'        => __('Add or remove event types', 'wp-events-filter'),
        'choose_from_most_used'      => __('Choose from the most used event types', 'wp-events-filter'),
        'not_found'                  => __('No event types found.', 'wp-events-filter'),
        'menu_name'                  => __('Event Types', 'wp-events-filter'),
    );

    $type_args = array(
        'hierarchical'          => true,
        'labels'                => $type_labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'event-type'),
        'show_in_rest'          => true,
    );

    register_taxonomy('event_type', array('event'), $type_args);

    // Register Event Category Taxonomy
    $category_labels = array(
        'name'                       => _x('Event Categories', 'taxonomy general name', 'wp-events-filter'),
        'singular_name'              => _x('Event Category', 'taxonomy singular name', 'wp-events-filter'),
        'search_items'               => __('Search Event Categories', 'wp-events-filter'),
        'popular_items'              => __('Popular Event Categories', 'wp-events-filter'),
        'all_items'                  => __('All Event Categories', 'wp-events-filter'),
        'parent_item'                => __('Parent Event Category', 'wp-events-filter'),
        'parent_item_colon'          => __('Parent Event Category:', 'wp-events-filter'),
        'edit_item'                  => __('Edit Event Category', 'wp-events-filter'),
        'update_item'                => __('Update Event Category', 'wp-events-filter'),
        'add_new_item'               => __('Add New Event Category', 'wp-events-filter'),
        'new_item_name'              => __('New Event Category Name', 'wp-events-filter'),
        'separate_items_with_commas' => __('Separate event categories with commas', 'wp-events-filter'),
        'add_or_remove_items'        => __('Add or remove event categories', 'wp-events-filter'),
        'choose_from_most_used'      => __('Choose from the most used event categories', 'wp-events-filter'),
        'not_found'                  => __('No event categories found.', 'wp-events-filter'),
        'menu_name'                  => __('Event Categories', 'wp-events-filter'),
    );

    $category_args = array(
        'hierarchical'          => true,
        'labels'                => $category_labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'event-category'),
        'show_in_rest'          => true,
    );

    register_taxonomy('event_category', array('event'), $category_args);

    
}

// Hook into WordPress init action
add_action('init', 'wp_events_filter_register_post_types');
