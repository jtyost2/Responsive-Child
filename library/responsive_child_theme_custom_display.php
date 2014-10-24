<?php
class ResponsiveChildThemeCustomDisplay {

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
		//Add Filters
		add_filter('wp_head', array($this, 'add_to_head'));
		add_filter('wp_sidebar', array($this, 'add_to_sidebar'));
		add_filter('wp_footer', array($this, 'add_to_footer'));
		add_filter('wp_get_shortlink', array($this, 'return_short_url'));
		add_filter('user_contactmethods', array($this, 'extra_contact_info'));

		//Remove Actions
		remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );

		//Add Actions
		add_action('publish_post', array($this, 'add_on_publish'));
		add_action('publish_link_post', array($this, 'add_on_publish'));

		//Register Scripts
		wp_register_script(
			'responsive.child.internet_defense_league.min',
			RESPONSIVE_CHILD_TEMPLATE_URI . "/js/internet_defense_league.min.js",
			array('jquery')
		);
	}

	/**
	 * add_my_open_id_information function.
	 *
	 * @access public
	 * @return void
	 */
	public function add_my_open_id_information(){
		if(
			isset($this->ThemeOptions['open_id_server'])
			&& !is_null($this->ThemeOptions['open_id_server'])
			&& ($this->ThemeOptions['open_id_server'] != '')
			&& isset($this->ThemeOptions['open_id_delegate'])
			&& !is_null($this->ThemeOptions['open_id_delegate'])
			&& ($this->ThemeOptions['open_id_delegate'] != '')
		):
			?>
			<link rel="openid2.provider" href="<?php echo $this->ThemeOptions['open_id_server']; ?>" />
			<link rel="openid2.local_id" href="<?php echo $this->ThemeOptions['open_id_delegate']; ?>" />
			<!--
			<link rel="openid.server" href="<?php echo $this->ThemeOptions['open_id_server']; ?>" />
			<link rel="openid.delegate" href="<?php echo $this->ThemeOptions['open_id_delegate']; ?>" />
			-->
			<?php
		else:
		endif;
	}

	/**
	 * add_meta_tags function.
	 *
	 * @access public
	 * @return void
	 */
	public function add_meta_tags(){
		global $post;

		if(is_single()){
			?>
			<meta name="description" content="<?php echo $post->post_excerpt; ?>" />
			<meta name="revised" content="<?php echo $post->post_modified_gmt; ?>" />
			<meta name="author" content="<?php echo self::get_author_complete_name($post->post_author); ?>" />
			<meta name="keywords" content="<?php echo self::get_post_tags($post->ID); ?>" />
			<meta property="og:title" content="<?php echo $post->post_title; ?>" />
			<meta property="og:url" content="<?php echo get_permalink($post->ID); ?>" />
			<?php
		} else if(is_front_page()) {
			?>
			<meta name="description" content="<?php echo get_option('blogdescription', "Just another WordPress Blog."); ?>" />
			<?php
		} else if(is_page()) {

		} else {

		}
		?>
		<meta property="og:site_name" content="<?php echo get_option('blogname'); ?>" />
		<meta property="og:type" content="blog" />
		<?php echo self::get_meta_tags(); ?>
		<?php
	}

	/**
	 * get_post_tags function.
	 *
	 * @access public
	 * @param mixed $post_ID (default: null)
	 * @return void
	 */
	function get_post_tags($post_ID = null){
		$tags = wp_get_post_tags($post_ID);
		$tags_string = null;
		foreach($tags as $tag){
			$tags_string = $tags_string.$tag->name.", ";
		}
		$tags_string = rtrim($tags_string, ', ');
		return $tags_string;
	}

	/**
	 * insert_short_url function.
	 *
	 * @access public
	 * @return void
	 */
	function insert_short_url(){
		global $post;
		if(is_single()){
			$shortURL = self::return_short_url();
			?>
			<link rel="shortlink" href="<?php echo $shortURL; ?>" />
			<?php
		}
	}

	/**
	 * get_author_complete_name function.
	 *
	 * @access public
	 * @param mixed $author_ID (default: null)
	 * @return void
	 */
	public function get_author_complete_name($author_ID = null){
		$author_info = get_userdata($author_ID);
		$author_name = $author_info->display_name;
		return $author_name;
	}

	/**
	 * get_iphone_non_retina_icon function.
	 *
	 * @access public
	 * @return void
	 */
	public function get_iphone_non_retina_icon() {
		return $this->ThemeOptions['apple_touch_icon_iphone_non_retina'];
	}

	/**
	 * get_iphone_retina_icon function.
	 *
	 * @access public
	 * @return void
	 */
	public function get_iphone_retina_icon() {
		return $this->ThemeOptions['apple_touch_icon_iphone_retina'];
	}

	/**
	 * get_meta_tags - return the additional_meta_tags from the ThemeOptions if set
	 *
	 * @return [type] [description]
	 */
	public function get_meta_tags() {
		if(array_key_exists('additional_meta_tags', $this->ThemeOptions)) {
			return $this->ThemeOptions['additional_meta_tags'];
		} else {
			return NULL;
		}
	}

	/**
	 * get_ipad_retina_icon function.
	 *
	 * @access public
	 * @return boolean
	 */
	public function get_icon($iconValue) {
		if(array_key_exists($iconValue, $this->ThemeOptions)) {
			return $this->ThemeOptions[$iconValue];
		} else {
			return false;
		}
	}


	/**
	 * get the chrome on android icon
	 *
	 * @return boolean
	 */
	public function get_chrome_on_android_icon() {
		return $this->ThemeOptions['chrome_on_android'];
	}

	/**
	 * [internet_defense_league_status description]
	 * @return [type] [description]
	 */
	public function internet_defense_league_status() {
		return $this->ThemeOptions['internet_defense_league'];
	}

	/**
	 * create_short_url function.
	 *
	 * Creates a Short Url for the Post
	 *
	 * @access private
	 * @param mixed $post_ID (default: null)
	 * @return void
	 */
	public function create_short_url($post_ID = null){
		$longURL = home_url().'?p='.$post_ID;

		$shortURL = null;
		if( self::is_bitly_information_set() ) {
			$shortURL = self::get_bitly_url($longURL, $this->ThemeOptions['bitly_username'], $this->ThemeOptions['bitly_api_key']);
		} else {
			$shortURL = $longURL;
		}

		// adding the short URL to a custom field called bitlyURL
		update_post_meta($post_ID, 'bitlyURL', $shortURL);
	}

	/**
	 * is_bitly_information_set function.
	 *
	 * Return if the Bit.ly Information is set
	 *
	 * @access private
	 * @return void
	 */
	function is_bitly_information_set(){

		return (
			isset($this->ThemeOptions['bitly_username'])
			&& isset($this->ThemeOptions['bitly_api_key'])
			&& !empty($this->ThemeOptions['bitly_username'])
			&& !empty($this->ThemeOptions['bitly_api_key'])
			&& ($this->ThemeOptions['bitly_username'] != '')
			&& ($this->ThemeOptions['bitly_api_key'] != '')
		);
	}

	/**
	 * get_bitly_url function.
	 *
	 * Generate the Bitly Short URL
	 *
	 * @access private
	 * @param mixed $longURL
	 * @param mixed $login
	 * @param mixed $apikey
	 * @return void
	 */
	function get_bitly_url($longURL, $login, $apikey){

		// This is the API call to fetch the shortened URL
		$apiurl = 'http://api.bit.ly/v3/shorten?longUrl='.urlencode($longURL).'&login='.$login.'&apiKey='.$apikey.'&format=json';

		// Use cURL to return from the API
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_URL, $apiurl);
		$results = json_decode(curl_exec($curl));
		curl_close($curl);

		$shortURL =  $results->data->url;
		return $shortURL;
	}

	/**
	 * extra_contact_info function.
	 *
	 * Set Extra Contact Information
	 *
	 * @access public
	 * @param mixed $contactmethods
	 * @return void
	 */
	function extra_contact_info($contactmethods) {
		unset($contactmethods['aim']);
		unset($contactmethods['yim']);
		unset($contactmethods['jabber']);
		$contactmethods['facebook'] = 'Facebook';
		$contactmethods['twitter'] = 'Twitter';
		$contactmethods['linkedin'] = 'LinkedIn';
		$contactmethods['appdotnet'] = 'App.net';
		return $contactmethods;
	}

	/**
	 * return_short_url function.
	 *
	 * @access public
	 * @return void
	 */
	function return_short_url() {
		global $post;
		$shortURL = get_post_meta($post->ID, 'bitlyURL', true);
		if(isset($shortURL) && !empty($shortURL)) {
			 return $shortURL;
		} else {
			return home_url().'?p='.$post->ID;
		}
	}

	/**
	 * return_short_url function.
	 *
	 * @access public
	 * @return void
	 */
	function return_quickie_link() {
		global $post;
		$quickLink = get_post_meta($post->ID, 'quickLink', true);
		if(isset($quickLink) && !empty($quickLink)) {
			 return $quickLink;
		} else {
			return NULL;
		}
	}

	/**
	 * return_short_link function.
	 *
	 * @access public
	 * @return void
	 */
	function return_short_link(){
		$shortURL = self::return_short_url();
		global $post;
		$shortLink = '<a rel="shortlink" title="'.$shortURL.'" href="'.$shortURL.'">'.$shortURL.'</a>';
		return $shortLink;
	}

	/**
	 * add_favicons function.
	 *
	 * @access public
	 * @return void
	 */
	public function add_favicons(){
		?>
		<link rel="shortcut icon" href="<?php echo home_url(); ?>/favicon.ico" />
		<link type="image/x-icon" rel="icon" href="<?php echo home_url(); ?>/favicon.ico" />
		<?php if(self::get_icon("apple_touch_icon_iphone_non_retina")): ?>
			<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo home_url(); ?>/apple-touch-icon-57x57-precomposed.png" />
		<?php endif; ?>
		<?php if(self::get_icon("apple_touch_icon_ipad_mini_non_retina_ios_6")): ?>
			<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo home_url(); ?>/apple-touch-icon-72x72-precomposed.png" />
		<?php endif; ?>
		<?php if(self::get_icon("apple_touch_icon_ipad_mini_non_retina_ios_7")): ?>
			<link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php echo home_url(); ?>/apple-touch-icon-76x76-precomposed.png">
		<?php endif; ?>
		<?php if(self::get_icon("apple_touch_icon_iphone_retina")): ?>
			<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo home_url(); ?>/apple-touch-icon-114x114-precomposed.png" />
		<?php endif; ?>
		<?php if(self::get_icon("apple_touch_icon_ipad_retina")): ?>
			<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo home_url(); ?>/apple-touch-icon-144x144-precomposed.png" />
		<?php endif; ?>
		<?php if(self::get_icon("apple_touch_icon_ipad_retina_ios7")): ?>
			<link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo home_url(); ?>/apple-touch-icon-152x152-precomposed.png" />
		<?php endif; ?>
		<?php if(self::get_icon("apple_touch_icon_iphone_plus_3x_screen")): ?>
			<link rel="apple-touch-icon-precomposed" sizes="180x180" href="<?php echo home_url(); ?>/apple-touch-icon-180x180-precomposed.png" />
		<?php endif; ?>
		<?php if(self::get_icon("chrome_on_android")): ?>
			<link rel="icon" sizes="192x192" href="<?php echo home_url(); ?>/touch-icon-192x192.png">
		<?php endif; ?>
		<?php
	}

	/**
	 * [add_scripts description]
	 */
	function add_scripts() {
		if(self::internet_defense_league_status()):
			wp_enqueue_script('responsive.child.internet_defense_league.min');
		endif;
	}

	/**
	 * censored_bar function.
	 *
	 * @access public
	 * @return void
	 */
	function censored_bar(){
		if($this->ThemeOptions['censored_bar'] == TRUE){
			?><a style="width:50%;height:77px;vertical-align:middle;text-align:center;background-color:#000;position:absolute;z-index:5555;top:0px;left:0px;background-image:url(http://americancensorship.org/images/stop-censorship-small.png);background-position:center center;background-repeat:no-repeat;margin:0 25%;" href="http://americancensorship.org"></a><?php
		}
	}

	public function comments_status() {
		if(array_key_exists('comments_disabled', $this->ThemeOptions) && $this->ThemeOptions['comments_disabled']) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	/**
	 * add_to_head function.
	 *
	 * @access public
	 * @return void
	 */
	public function add_to_head(){
		self::add_my_open_id_information();
		self::insert_short_url();
		self::add_favicons();
		self::add_meta_tags();
		self::add_scripts();
	}

	/**
	 * add_to_sidebar function.
	 *
	 * @access public
	 * @return void
	 */
	public function add_to_sidebar(){
	}

	/**
	 * add_to_footer function.
	 *
	 * @access public
	 * @return void
	 */
	public function add_to_footer(){
		self::censored_bar();
	}

	/**
	 * add_on_publish function.
	 *
	 * @access public
	 * @param mixed $post_ID
	 * @return void
	 */
	function add_on_publish($post_ID) {
		self::create_short_url($post_ID);
	}

	protected function _get_theme_options() {
		$options = get_option(RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS);
		if(!$options) {
			return array();
		}
		return $options;
	}

}