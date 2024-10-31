<?php
global $aPoll;
$aPoll = get_post_meta($_GET['post'], 'poll-data');
if (isset($aPoll[0]) && !empty($aPoll)) {
	$aPoll = unserialize($aPoll[0]);
}

add_action('wp_head', 'pp_poll_init');
function pp_poll_init() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'poll-js', plugin_dir_url( __FILE__ ).'js/poll.js' );
	wp_enqueue_style( 'poll-css', plugin_dir_url( __FILE__ ).'css/poll.css' );
	wp_enqueue_style( 'poll-css' );
}

add_action('admin_init', 'pp_poll_admin_init');
function pp_poll_admin_init() {
	wp_enqueue_script( 'jquery' );
    	wp_enqueue_script( 'jquery-ui-datepicker' );
	wp_enqueue_script( 'poll-js', plugin_dir_url( __FILE__ ).'js/admin_poll.js' );
    
	wp_enqueue_style( 'poll-css', plugin_dir_url( __FILE__ ).'css/admin_poll.css' );
	wp_enqueue_style( 'poll-css' );
    	wp_enqueue_style( 'jquery-ui', '//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css' );
}

add_action('wp_head', 'pp_poll_p_ajaxurl');
function pp_poll_p_ajaxurl() {

   echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';
}

/**
 * Add Poll custom post type
 */
	add_action( 'init', 'pp_create_poll_post_type' );
	function pp_create_poll_post_type() {
		register_post_type( 'poll',
			[
				'labels' 	=> [
					'name' 			=> __( 'Poll' ),
					'singular_name' => __( 'Poll' )
				],
				'public' 		=> true,
				'has_archive' 	=> true,
			]
		);
	}
/**
 * END Add Poll custom post type
 */


/**
 * Change the post type labels
 */
	function pp_change_post_type_labels() {
		global $wp_post_types;

		// Get the post labels
		$postLabels = $wp_post_types['poll']->labels;
		$postLabels->name = __( 'Polls' );
		$postLabels->singular_name = __( 'Polls' );
		$postLabels->add_new = __( 'Add Poll' );
		$postLabels->add_new_item = __( 'Add new Poll' );
		$postLabels->edit_item = __( 'Edit Poll' );
		$postLabels->new_item = __( 'New Poll' );
		$postLabels->view_item = __( 'View Poll' );
		$postLabels->search_items = __( 'Search Poll' );
		$postLabels->not_found = __( 'No polls found' );
		$postLabels->not_found_in_trash = __( 'No polls found in Trash' );
	}
	add_action( 'init', 'pp_change_post_type_labels' );
/**
 * END Change the post type labels
 */

/**
 * Add custom meta fields type
 */
	function pp_adding_poll_custom_meta_boxes( $post ) {
		add_meta_box( 
			'poll-settings',
			__( 'Poll settings' ),
			'render_poll_settings_meta_boxes',
			'poll',
			'normal',
			'default'
		);

		add_meta_box( 
			'poll-answers',
			__( 'Enter poll answers' ),
			'render_poll_answers_meta_boxes',
			'poll',
			'normal',
			'default'
		);
	}
	add_action( 'add_meta_boxes', 'pp_adding_poll_custom_meta_boxes', 1, 1 );
	add_action( 'save_post', 'pp_save_poll' );
/**
 * END Add custom meta fields type
 */