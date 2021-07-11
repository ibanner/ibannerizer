<?php

/**
 * Registers the `vroom` post type.
 */
function vroom_init() {
	register_post_type(
		'vroom',
		[
			'labels'                => [
				'name'                  => __( 'Viewing Rooms', 'ibn' ),
				'singular_name'         => __( 'Viewing Room', 'ibn' ),
				'all_items'             => __( 'All Viewing Rooms', 'ibn' ),
				'archives'              => __( 'Viewing Room Archives', 'ibn' ),
				'attributes'            => __( 'Viewing Room Attributes', 'ibn' ),
				'insert_into_item'      => __( 'Insert into Viewing Room', 'ibn' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Viewing Room', 'ibn' ),
				'featured_image'        => _x( 'Featured Image', 'vroom', 'ibn' ),
				'set_featured_image'    => _x( 'Set featured image', 'vroom', 'ibn' ),
				'remove_featured_image' => _x( 'Remove featured image', 'vroom', 'ibn' ),
				'use_featured_image'    => _x( 'Use as featured image', 'vroom', 'ibn' ),
				'filter_items_list'     => __( 'Filter Viewing Rooms list', 'ibn' ),
				'items_list_navigation' => __( 'Viewing Rooms list navigation', 'ibn' ),
				'items_list'            => __( 'Viewing Rooms list', 'ibn' ),
				'new_item'              => __( 'New Viewing Room', 'ibn' ),
				'add_new'               => __( 'Add New', 'ibn' ),
				'add_new_item'          => __( 'Add New Viewing Room', 'ibn' ),
				'edit_item'             => __( 'Edit Viewing Room', 'ibn' ),
				'view_item'             => __( 'View Viewing Room', 'ibn' ),
				'view_items'            => __( 'View Viewing Rooms', 'ibn' ),
				'search_items'          => __( 'Search Viewing Rooms', 'ibn' ),
				'not_found'             => __( 'No Viewing Rooms found', 'ibn' ),
				'not_found_in_trash'    => __( 'No Viewing Rooms found in trash', 'ibn' ),
				'parent_item_colon'     => __( 'Parent Viewing Room:', 'ibn' ),
				'menu_name'             => __( 'Viewing Rooms', 'ibn' ),
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
			'menu_icon'             => 'dashicons-welcome-view-site',
			'show_in_rest'          => true,
			'rest_base'             => 'vroom',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);

}

add_action( 'init', 'vroom_init' );

/**
 * Sets the post updated messages for the `vroom` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `vroom` post type.
 */
function vroom_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['vroom'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Viewing Room updated. <a target="_blank" href="%s">View Viewing Room</a>', 'ibn' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'ibn' ),
		3  => __( 'Custom field deleted.', 'ibn' ),
		4  => __( 'Viewing Room updated.', 'ibn' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Viewing Room restored to revision from %s', 'ibn' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Viewing Room published. <a href="%s">View Viewing Room</a>', 'ibn' ), esc_url( $permalink ) ),
		7  => __( 'Viewing Room saved.', 'ibn' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Viewing Room submitted. <a target="_blank" href="%s">Preview Viewing Room</a>', 'ibn' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Viewing Room scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Viewing Room</a>', 'ibn' ), date_i18n( __( 'M j, Y @ G:i', 'ibn' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Viewing Room draft updated. <a target="_blank" href="%s">Preview Viewing Room</a>', 'ibn' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'vroom_updated_messages' );

/**
 * Sets the bulk post updated messages for the `vroom` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `vroom` post type.
 */
function vroom_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['vroom'] = [
		/* translators: %s: Number of Viewing Rooms. */
		'updated'   => _n( '%s Viewing Room updated.', '%s Viewing Rooms updated.', $bulk_counts['updated'], 'ibn' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 Viewing Room not updated, somebody is editing it.', 'ibn' ) :
						/* translators: %s: Number of Viewing Rooms. */
						_n( '%s Viewing Room not updated, somebody is editing it.', '%s Viewing Rooms not updated, somebody is editing them.', $bulk_counts['locked'], 'ibn' ),
		/* translators: %s: Number of Viewing Rooms. */
		'deleted'   => _n( '%s Viewing Room permanently deleted.', '%s Viewing Rooms permanently deleted.', $bulk_counts['deleted'], 'ibn' ),
		/* translators: %s: Number of Viewing Rooms. */
		'trashed'   => _n( '%s Viewing Room moved to the Trash.', '%s Viewing Rooms moved to the Trash.', $bulk_counts['trashed'], 'ibn' ),
		/* translators: %s: Number of Viewing Rooms. */
		'untrashed' => _n( '%s Viewing Room restored from the Trash.', '%s Viewing Rooms restored from the Trash.', $bulk_counts['untrashed'], 'ibn' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'vroom_bulk_updated_messages', 10, 2 );
