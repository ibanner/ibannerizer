<?php

/**
 * Registers the `sandbox` post type.
 */
function sandbox_init() {
	register_post_type(
		'sandbox',
		[
			'labels'                => [
				'name'                  => __( 'Sandboxes', 'ibn' ),
				'singular_name'         => __( 'Sandbox', 'ibn' ),
				'all_items'             => __( 'All Sandboxes', 'ibn' ),
				'archives'              => __( 'Sandbox Archives', 'ibn' ),
				'attributes'            => __( 'Sandbox Attributes', 'ibn' ),
				'insert_into_item'      => __( 'Insert into Sandbox', 'ibn' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Sandbox', 'ibn' ),
				'featured_image'        => _x( 'Featured Image', 'sandbox', 'ibn' ),
				'set_featured_image'    => _x( 'Set featured image', 'sandbox', 'ibn' ),
				'remove_featured_image' => _x( 'Remove featured image', 'sandbox', 'ibn' ),
				'use_featured_image'    => _x( 'Use as featured image', 'sandbox', 'ibn' ),
				'filter_items_list'     => __( 'Filter Sandboxes list', 'ibn' ),
				'items_list_navigation' => __( 'Sandboxes list navigation', 'ibn' ),
				'items_list'            => __( 'Sandboxes list', 'ibn' ),
				'new_item'              => __( 'New Sandbox', 'ibn' ),
				'add_new'               => __( 'Add New', 'ibn' ),
				'add_new_item'          => __( 'Add New Sandbox', 'ibn' ),
				'edit_item'             => __( 'Edit Sandbox', 'ibn' ),
				'view_item'             => __( 'View Sandbox', 'ibn' ),
				'view_items'            => __( 'View Sandboxes', 'ibn' ),
				'search_items'          => __( 'Search Sandboxes', 'ibn' ),
				'not_found'             => __( 'No Sandboxes found', 'ibn' ),
				'not_found_in_trash'    => __( 'No Sandboxes found in trash', 'ibn' ),
				'parent_item_colon'     => __( 'Parent Sandbox:', 'ibn' ),
				'menu_name'             => __( 'Sandboxes', 'ibn' ),
			],
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => [ 'title', 'editor' ],
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => null,
			'menu_icon'             => 'dashicons-welcome-view-site',
			'show_in_rest'          => true,
			'rest_base'             => 'sandbox',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);

}

add_action( 'init', 'sandbox_init' );

/**
 * Sets the post updated messages for the `sandbox` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `sandbox` post type.
 */
function sandbox_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['sandbox'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Sandbox updated. <a target="_blank" href="%s">View Sandbox</a>', 'ibn' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'ibn' ),
		3  => __( 'Custom field deleted.', 'ibn' ),
		4  => __( 'Sandbox updated.', 'ibn' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Sandbox restored to revision from %s', 'ibn' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Sandbox published. <a href="%s">View Sandbox</a>', 'ibn' ), esc_url( $permalink ) ),
		7  => __( 'Sandbox saved.', 'ibn' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Sandbox submitted. <a target="_blank" href="%s">Preview Sandbox</a>', 'ibn' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Sandbox scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Sandbox</a>', 'ibn' ), date_i18n( __( 'M j, Y @ G:i', 'ibn' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Sandbox draft updated. <a target="_blank" href="%s">Preview Sandbox</a>', 'ibn' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'sandbox_updated_messages' );

/**
 * Sets the bulk post updated messages for the `sandbox` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `sandbox` post type.
 */
function sandbox_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['sandbox'] = [
		/* translators: %s: Number of Sandboxes. */
		'updated'   => _n( '%s Sandbox updated.', '%s Sandboxes updated.', $bulk_counts['updated'], 'ibn' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 Sandbox not updated, somebody is editing it.', 'ibn' ) :
						/* translators: %s: Number of Sandboxes. */
						_n( '%s Sandbox not updated, somebody is editing it.', '%s Sandboxes not updated, somebody is editing them.', $bulk_counts['locked'], 'ibn' ),
		/* translators: %s: Number of Sandboxes. */
		'deleted'   => _n( '%s Sandbox permanently deleted.', '%s Sandboxes permanently deleted.', $bulk_counts['deleted'], 'ibn' ),
		/* translators: %s: Number of Sandboxes. */
		'trashed'   => _n( '%s Sandbox moved to the Trash.', '%s Sandboxes moved to the Trash.', $bulk_counts['trashed'], 'ibn' ),
		/* translators: %s: Number of Sandboxes. */
		'untrashed' => _n( '%s Sandbox restored from the Trash.', '%s Sandboxes restored from the Trash.', $bulk_counts['untrashed'], 'ibn' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'sandbox_bulk_updated_messages', 10, 2 );
