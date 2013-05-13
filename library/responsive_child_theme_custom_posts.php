<?php
class ResponsiveChildThemeCustomPosts {

	/**
	 * [$instance description]
	 * @var [type]
	 */
	static $instance;

	public $ThemeOptions = NULL;

	/**
	 * [__construct description]
	 */
	public function __construct() {
		self::$instance = $this;
		$this->ThemeOptions = self::_get_theme_options();
		add_action('init', array($this, 'init'));
	}

	/**
	 * [init description]
	 * @return [type] [description]
	 */
	public function init() {

		register_post_type( 'link_post',
			array(
				'labels' => array(
					'name' => __( 'Quick Links', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ),
					'singular_name' => __( 'Quick Link', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE )
				),
				'public' => TRUE,
				'has_archive' => TRUE,
				'menu_position' => 5,
				'supports' => array(
					'title',
					'editor',
					'trackbacks',
					'revisions',
				),
				'register_meta_box_cb' => array($this, 'add_quick_links_metabox'),
				'taxonomies' => array(
					'category',
					'post_tag'
				),
			)
		);

		//Add Action
		add_action('add_meta_boxes', array($this, 'add_quick_links_metabox'));
		add_action('save_post', array($this, 'save_quick_links_metaboxes'), 1, 2); // save the custom fields

		//Add Filters
		add_filter('the_permalink_rss', array(&$this, 'quick_link_permalink_rss'));
	}

	public function quick_link_permalink_rss($content) {
		$postId = self::_return_post_id();
		$link = get_post_meta($postId, '_link', true);
		$content = null;
		if(is_feed()) {
			if($link !== '') {
				$content = $link;
			} else {
				$content = get_permalink($postId);
			}
		}
		return $content;
	}

	public function add_quick_links_metabox() {
		add_meta_box('responsive_child_quick_links', 'Quick Link URL', array($this, 'add_quick_links_metabox_callback'), 'link_post', 'normal', 'default');
	}

	public function add_quick_links_metabox_callback() {
		global $post;
		?>
		<input type="hidden" name="quick_links_noncename" id="quick_links_noncename" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ); ?>" />
		<input type="text" name="_link" value="<?php echo get_post_meta($post->ID, '_link', true); ?>" class="widefat" />
		<?php
	}

	public function save_quick_links_metaboxes($post_id, $post) {
		if ( "link_post" != $_POST['post_type'] ) {
        return;
    }

		if ( !wp_verify_nonce( $_REQUEST['quick_links_noncename'], plugin_basename(__FILE__) )) {
			return $post->ID;
		}

		// Is the user allowed to edit the post or page?
		if ( !current_user_can( 'edit_post', $post->ID )) {
			return $post->ID;
		}

		$quickLinksMetaData = array();
		// OK, we're authenticated: we need to find and save the data
		// We'll put it into an array to make it easier to loop though.
		if(is_array($_REQUEST) && array_key_exists('_link', $_REQUEST)){
			$quickLinksMetaData['_link'] = wp_filter_nohtml_kses( $_REQUEST['_link'] );
		}

		// Add values of $events_meta as custom fields

		foreach ($quickLinksMetaData as $key => $value) { // Cycle through the $events_meta array!
			if( $post->post_type == 'revision' ) return; // Don't store custom data twice
			$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
			if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
				update_post_meta($post->ID, $key, $value);
			} else { // If the custom field doesn't have a value
				add_post_meta($post->ID, $key, $value);
			}
			if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
		}
	}

	protected function _return_post_id() {
		global $wp_query;
		$postId = $wp_query->post->ID;
		return $postId;
	}

	protected function _get_theme_options() {
		$options = get_option(RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS);
		if(!$options) {
			return array();
		}
		return $options;
	}

}