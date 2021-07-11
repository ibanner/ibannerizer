<?php

/**
 * Registers the `exhibition` post type.
 */
function exhibition_init() {
	register_post_type(
		'exhibition',
		[
			'labels'                => [
				'name'                  => __( 'Exhibitions', 'ibn' ),
				'singular_name'         => __( 'Exhibition', 'ibn' ),
				'all_items'             => __( 'All Exhibitions', 'ibn' ),
				'archives'              => __( 'Exhibition Archives', 'ibn' ),
				'attributes'            => __( 'Exhibition Attributes', 'ibn' ),
				'insert_into_item'      => __( 'Insert into Exhibition', 'ibn' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Exhibition', 'ibn' ),
				'featured_image'        => _x( 'Featured Image', 'exhibition', 'ibn' ),
				'set_featured_image'    => _x( 'Set featured image', 'exhibition', 'ibn' ),
				'remove_featured_image' => _x( 'Remove featured image', 'exhibition', 'ibn' ),
				'use_featured_image'    => _x( 'Use as featured image', 'exhibition', 'ibn' ),
				'filter_items_list'     => __( 'Filter Exhibitions list', 'ibn' ),
				'items_list_navigation' => __( 'Exhibitions list navigation', 'ibn' ),
				'items_list'            => __( 'Exhibitions list', 'ibn' ),
				'new_item'              => __( 'New Exhibition', 'ibn' ),
				'add_new'               => __( 'Add New', 'ibn' ),
				'add_new_item'          => __( 'Add New Exhibition', 'ibn' ),
				'edit_item'             => __( 'Edit Exhibition', 'ibn' ),
				'view_item'             => __( 'View Exhibition', 'ibn' ),
				'view_items'            => __( 'View Exhibitions', 'ibn' ),
				'search_items'          => __( 'Search Exhibitions', 'ibn' ),
				'not_found'             => __( 'No Exhibitions found', 'ibn' ),
				'not_found_in_trash'    => __( 'No Exhibitions found in trash', 'ibn' ),
				'parent_item_colon'     => __( 'Parent Exhibition:', 'ibn' ),
				'menu_name'             => __( 'Exhibitions', 'ibn' ),
			],
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => [ 'title', 'editor', 'excerpt', 'page-attributes', 'thumbnail'  ],
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => null,
			'menu_icon'             => 'dashicons-store',
			'show_in_rest'          => true,
			'rest_base'             => 'exhibition',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);

}

add_action( 'init', 'exhibition_init' );

/**
 * Sets the post updated messages for the `exhibition` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `exhibition` post type.
 */
function exhibition_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['exhibition'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Exhibition updated. <a target="_blank" href="%s">View Exhibition</a>', 'ibn' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'ibn' ),
		3  => __( 'Custom field deleted.', 'ibn' ),
		4  => __( 'Exhibition updated.', 'ibn' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Exhibition restored to revision from %s', 'ibn' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Exhibition published. <a href="%s">View Exhibition</a>', 'ibn' ), esc_url( $permalink ) ),
		7  => __( 'Exhibition saved.', 'ibn' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Exhibition submitted. <a target="_blank" href="%s">Preview Exhibition</a>', 'ibn' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Exhibition scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Exhibition</a>', 'ibn' ), date_i18n( __( 'M j, Y @ G:i', 'ibn' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Exhibition draft updated. <a target="_blank" href="%s">Preview Exhibition</a>', 'ibn' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'exhibition_updated_messages' );

/**
 * Sets the bulk post updated messages for the `exhibition` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `exhibition` post type.
 */
function exhibition_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['exhibition'] = [
		/* translators: %s: Number of Exhibitions. */
		'updated'   => _n( '%s Exhibition updated.', '%s Exhibitions updated.', $bulk_counts['updated'], 'ibn' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 Exhibition not updated, somebody is editing it.', 'ibn' ) :
						/* translators: %s: Number of Exhibitions. */
						_n( '%s Exhibition not updated, somebody is editing it.', '%s Exhibitions not updated, somebody is editing them.', $bulk_counts['locked'], 'ibn' ),
		/* translators: %s: Number of Exhibitions. */
		'deleted'   => _n( '%s Exhibition permanently deleted.', '%s Exhibitions permanently deleted.', $bulk_counts['deleted'], 'ibn' ),
		/* translators: %s: Number of Exhibitions. */
		'trashed'   => _n( '%s Exhibition moved to the Trash.', '%s Exhibitions moved to the Trash.', $bulk_counts['trashed'], 'ibn' ),
		/* translators: %s: Number of Exhibitions. */
		'untrashed' => _n( '%s Exhibition restored from the Trash.', '%s Exhibitions restored from the Trash.', $bulk_counts['untrashed'], 'ibn' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'exhibition_bulk_updated_messages', 10, 2 );
