<?php

/**
 * Registers the `artist` post type.
 */
function artist_init() {
	register_post_type(
		'artist',
		[
			'labels'                => [
				'name'                  => __( 'Artists', 'ibn' ),
				'singular_name'         => __( 'Artist', 'ibn' ),
				'all_items'             => __( 'All Artists', 'ibn' ),
				'archives'              => __( 'Artist Archives', 'ibn' ),
				'attributes'            => __( 'Artist Attributes', 'ibn' ),
				'insert_into_item'      => __( 'Insert into Artist', 'ibn' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Artist', 'ibn' ),
				'featured_image'        => _x( 'Featured Image', 'artist', 'ibn' ),
				'set_featured_image'    => _x( 'Set featured image', 'artist', 'ibn' ),
				'remove_featured_image' => _x( 'Remove featured image', 'artist', 'ibn' ),
				'use_featured_image'    => _x( 'Use as featured image', 'artist', 'ibn' ),
				'filter_items_list'     => __( 'Filter Artists list', 'ibn' ),
				'items_list_navigation' => __( 'Artists list navigation', 'ibn' ),
				'items_list'            => __( 'Artists list', 'ibn' ),
				'new_item'              => __( 'New Artist', 'ibn' ),
				'add_new'               => __( 'Add New', 'ibn' ),
				'add_new_item'          => __( 'Add New Artist', 'ibn' ),
				'edit_item'             => __( 'Edit Artist', 'ibn' ),
				'view_item'             => __( 'View Artist', 'ibn' ),
				'view_items'            => __( 'View Artists', 'ibn' ),
				'search_items'          => __( 'Search Artists', 'ibn' ),
				'not_found'             => __( 'No Artists found', 'ibn' ),
				'not_found_in_trash'    => __( 'No Artists found in trash', 'ibn' ),
				'parent_item_colon'     => __( 'Parent Artist:', 'ibn' ),
				'menu_name'             => __( 'Artists', 'ibn' ),
			],
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => [ 'title', 'editor', 'excerpt', 'page-attributes', 'thumbnail' ],
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => null,
			'menu_icon'             => 'dashicons-groups',
			'show_in_rest'          => true,
			'rest_base'             => 'artist',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);

}

add_action( 'init', 'artist_init' );

/**
 * Sets the post updated messages for the `artist` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `artist` post type.
 */
function artist_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['artist'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Artist updated. <a target="_blank" href="%s">View Artist</a>', 'ibn' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'ibn' ),
		3  => __( 'Custom field deleted.', 'ibn' ),
		4  => __( 'Artist updated.', 'ibn' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Artist restored to revision from %s', 'ibn' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Artist published. <a href="%s">View Artist</a>', 'ibn' ), esc_url( $permalink ) ),
		7  => __( 'Artist saved.', 'ibn' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Artist submitted. <a target="_blank" href="%s">Preview Artist</a>', 'ibn' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Artist scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Artist</a>', 'ibn' ), date_i18n( __( 'M j, Y @ G:i', 'ibn' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Artist draft updated. <a target="_blank" href="%s">Preview Artist</a>', 'ibn' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'artist_updated_messages' );

/**
 * Sets the bulk post updated messages for the `artist` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `artist` post type.
 */
function artist_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['artist'] = [
		/* translators: %s: Number of Artists. */
		'updated'   => _n( '%s Artist updated.', '%s Artists updated.', $bulk_counts['updated'], 'ibn' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 Artist not updated, somebody is editing it.', 'ibn' ) :
						/* translators: %s: Number of Artists. */
						_n( '%s Artist not updated, somebody is editing it.', '%s Artists not updated, somebody is editing them.', $bulk_counts['locked'], 'ibn' ),
		/* translators: %s: Number of Artists. */
		'deleted'   => _n( '%s Artist permanently deleted.', '%s Artists permanently deleted.', $bulk_counts['deleted'], 'ibn' ),
		/* translators: %s: Number of Artists. */
		'trashed'   => _n( '%s Artist moved to the Trash.', '%s Artists moved to the Trash.', $bulk_counts['trashed'], 'ibn' ),
		/* translators: %s: Number of Artists. */
		'untrashed' => _n( '%s Artist restored from the Trash.', '%s Artists restored from the Trash.', $bulk_counts['untrashed'], 'ibn' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'artist_bulk_updated_messages', 10, 2 );
