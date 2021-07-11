<?php

/**
 * Registers the `work` post type.
 */
function work_init() {
	register_post_type(
		'work',
		[
			'labels'                => [
				'name'                  => __( 'Works', 'ibn' ),
				'singular_name'         => __( 'Work', 'ibn' ),
				'all_items'             => __( 'All Works', 'ibn' ),
				'archives'              => __( 'Work Archives', 'ibn' ),
				'attributes'            => __( 'Work Attributes', 'ibn' ),
				'insert_into_item'      => __( 'Insert into Work', 'ibn' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Work', 'ibn' ),
				'featured_image'        => _x( 'Featured Image', 'work', 'ibn' ),
				'set_featured_image'    => _x( 'Set featured image', 'work', 'ibn' ),
				'remove_featured_image' => _x( 'Remove featured image', 'work', 'ibn' ),
				'use_featured_image'    => _x( 'Use as featured image', 'work', 'ibn' ),
				'filter_items_list'     => __( 'Filter Works list', 'ibn' ),
				'items_list_navigation' => __( 'Works list navigation', 'ibn' ),
				'items_list'            => __( 'Works list', 'ibn' ),
				'new_item'              => __( 'New Work', 'ibn' ),
				'add_new'               => __( 'Add New', 'ibn' ),
				'add_new_item'          => __( 'Add New Work', 'ibn' ),
				'edit_item'             => __( 'Edit Work', 'ibn' ),
				'view_item'             => __( 'View Work', 'ibn' ),
				'view_items'            => __( 'View Works', 'ibn' ),
				'search_items'          => __( 'Search Works', 'ibn' ),
				'not_found'             => __( 'No Works found', 'ibn' ),
				'not_found_in_trash'    => __( 'No Works found in trash', 'ibn' ),
				'parent_item_colon'     => __( 'Parent Work:', 'ibn' ),
				'menu_name'             => __( 'Works', 'ibn' ),
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
			'menu_icon'             => 'dashicons-art',
			'show_in_rest'          => true,
			'rest_base'             => 'work',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);

}

add_action( 'init', 'work_init' );

/**
 * Sets the post updated messages for the `work` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `work` post type.
 */
function work_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['work'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Work updated. <a target="_blank" href="%s">View Work</a>', 'ibn' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'ibn' ),
		3  => __( 'Custom field deleted.', 'ibn' ),
		4  => __( 'Work updated.', 'ibn' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Work restored to revision from %s', 'ibn' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Work published. <a href="%s">View Work</a>', 'ibn' ), esc_url( $permalink ) ),
		7  => __( 'Work saved.', 'ibn' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Work submitted. <a target="_blank" href="%s">Preview Work</a>', 'ibn' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Work scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Work</a>', 'ibn' ), date_i18n( __( 'M j, Y @ G:i', 'ibn' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Work draft updated. <a target="_blank" href="%s">Preview Work</a>', 'ibn' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'work_updated_messages' );

/**
 * Sets the bulk post updated messages for the `work` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `work` post type.
 */
function work_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['work'] = [
		/* translators: %s: Number of Works. */
		'updated'   => _n( '%s Work updated.', '%s Works updated.', $bulk_counts['updated'], 'ibn' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 Work not updated, somebody is editing it.', 'ibn' ) :
						/* translators: %s: Number of Works. */
						_n( '%s Work not updated, somebody is editing it.', '%s Works not updated, somebody is editing them.', $bulk_counts['locked'], 'ibn' ),
		/* translators: %s: Number of Works. */
		'deleted'   => _n( '%s Work permanently deleted.', '%s Works permanently deleted.', $bulk_counts['deleted'], 'ibn' ),
		/* translators: %s: Number of Works. */
		'trashed'   => _n( '%s Work moved to the Trash.', '%s Works moved to the Trash.', $bulk_counts['trashed'], 'ibn' ),
		/* translators: %s: Number of Works. */
		'untrashed' => _n( '%s Work restored from the Trash.', '%s Works restored from the Trash.', $bulk_counts['untrashed'], 'ibn' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'work_bulk_updated_messages', 10, 2 );
