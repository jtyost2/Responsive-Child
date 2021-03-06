<?php
class ResponsiveChildThemeCustomOptions {

	/**
	 * [$instance description]
	 * @var [type]
	 */
	static $instance;

	/**
	 * [__construct description]
	 */
	public function __construct() {
		self::$instance = $this;
		add_action('init', array($this, 'init'));
	}

	/**
	 * [init description]
	 * @return [type] [description]
	 */
	public function init() {
		//add your actions to the constructor!
		add_action( 'admin_init', array($this, 'theme_options_init') );
		add_action( 'admin_menu', array($this, 'theme_options_add_page') );
	}

	public function theme_options_add_page() {
		add_theme_page(
			__( 'Responsive Child Theme Options', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ),
			__( 'Responsive Child Theme Options', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ),
			'edit_theme_options',
			RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS,
			array($this, 'theme_options_do_page')
		);
	}

	public function theme_options_init(){
		register_setting(
			RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_FIELD,
			RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS,
			array($this, 'theme_options_validate')
		);
	}

	public function theme_options_do_page() {
		global $select_options, $radio_options;

		if ( ! isset( $_REQUEST['settings-updated'] ) ) {
			$_REQUEST['settings-updated'] = FALSE;
		}
		?>

		<div class="wrap">
			<?php screen_icon(); echo "<h2>" . wp_get_theme() . __( ' Theme Options', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ) . "</h2>"; ?>

			<?php if ( FALSE !== $_REQUEST['settings-updated'] ) : ?>
			<div class="updated fade"><p><strong><?php _e( 'Options saved', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></strong></p></div>
			<?php endif; ?>

			<form method="post" action="options.php">
				<?php settings_fields( RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_FIELD ); ?>
				<?php $options = get_option( RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS ); ?>
				<h2><?php _e( 'Social Media Settings', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></h2>
				<table class="form-table">
					<tr valign="top"><th scope="row"><?php _e( 'Bit.ly Username', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></th>
						<td>
							<input id="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[bitly_username]" class="regular-text" type="text" name="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[bitly_username]" value="<?php esc_attr_e( $options['bitly_username'] ); ?>" />
							<label class="description" for="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[bitly_username]"><?php _e( 'Enter your <a href="http://bit.ly/a/your_api_key" target="_blank" title="Get your Bit.ly Username">Bit.ly Username</a>', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></label>
						</td>
					</tr>

					<tr valign="top"><th scope="row"><?php _e( 'Bit.ly API Key', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></th>
						<td>
							<input id="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[bitly_api_key]" class="regular-text" type="text" name="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[bitly_api_key]" value="<?php esc_attr_e( $options['bitly_api_key'] ); ?>" />
							<label class="description" for="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[bitly_api_key]"><?php _e( 'Enter your <a href="http://bit.ly/a/your_api_key" target="_blank" title="Get your Bit.ly API Key">Bit.ly API Key</a>', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></label>
						</td>
					</tr>

					<tr valign="top"><th scope="row"><?php _e( 'Open ID Server URL and Provider', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></th>
						<td>
							<input id="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[open_id_server]" class="regular-text" type="text" name="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[open_id_server]" value="<?php esc_attr_e( $options['open_id_server'] ); ?>" />
							<label class="description" for="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[open_id_server]"><?php _e( 'Enter in your OpenID Server URL, to use your site\'s url as a delegate server. For example if using MyOpenId, enter in http://www.myopenid.com/server/. More info here: <a href="http://openid.net/specs/openid-authentication-1_1.html#delegating_authentication" target="_blank" title="OpenID Delegate Server">http://openid.net/specs/openid-authentication-1_1.html#delegating_authentication</a>', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></label>
						</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e( 'OpenID Delegate URL and Local ID)', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></th>
						<td>
							<input id="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[open_id_delegate]" class="regular-text" type="text" name="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[open_id_delegate]" value="<?php esc_attr_e( $options['open_id_delegate'] ); ?>" />
							<label class="description" for="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[open_id_delegate]"><?php _e( 'Enter in your OpenID Delegate Url, to use your site\'s url as a delegate server. For example if using MyOpenId, enter in http://{username}.myopenid.com/. More info here: <a href="http://openid.net/specs/openid-authentication-1_1.html#delegating_authentication" target="_blank" title="OpenID Delegate Server">http://openid.net/specs/openid-authentication-1_1.html#delegating_authentication</a>', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></label>
						</td>
					</tr>

				</table>

				<h2><?php _e( 'Meta Settings', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></h2>
				<table class="form-table">
					<tr valign="top"><th scope="row"><?php _e( 'Open Search Local URL', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></th>
						<td>
							<input id="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[open_search]" class="regular-text" type="text" name="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[open_search]" value="<?php esc_attr_e( $options['open_search'] ); ?>" />
							<label class="description" for="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[open_search]"><?php _e( 'Enter in the url for your Open Search XML file. More info here: <a href="http://www.opensearch.org/Home" target="_blank" title="Open Search Home Page">http://www.opensearch.org/Home</a>', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></label>
						</td>
					<tr valign="top"><th scope="row"><?php _e( 'Apple Touch Icon - 57x57', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></th>
						<td>
							<input id="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[apple_touch_icon_iphone_non_retina]" class="regular-checkbox" type="checkbox" name="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[apple_touch_icon_iphone_non_retina]" value="1" <?php if($options['apple_touch_icon_iphone_non_retina'] == TRUE): ?> checked <?php endif; ?> />
							<label class="description" for="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[apple_touch_icon_iphone_non_retina]"><?php _e( 'Turn on the Apple Touch icon (Should be 57x57 pixels, in the webroot directory and named apple-touch-icon-57x57-precomposed.png). Sized for the iPhone Non-Retina Screen.', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></label>
						</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e( 'Apple Touch Icon - 72x72', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></th>
						<td>
							<input id="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[apple_touch_icon_ipad_mini_non_retina_ios_6]" class="regular-checkbox" type="checkbox" name="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[apple_touch_icon_ipad_mini_non_retina_ios_6]" value="1" <?php if($options['apple_touch_icon_ipad_mini_non_retina_ios_7'] == TRUE): ?> checked <?php endif; ?> />
							<label class="description" for="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[apple_touch_icon_ipad_mini_non_retina_ios_6]"><?php _e( 'Turn on the Apple Touch icon (Should be 72x72 pixels, in the webroot directory and named apple-touch-icon-72x72-precomposed.png). For the iPad mini and the first- and second-generation iPad (@1× display) on iOS ≤ 6', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></label>
						</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e( 'Apple Touch Icon - 76x76', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></th>
						<td>
							<input id="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[apple_touch_icon_ipad_mini_non_retina_ios_7]" class="regular-checkbox" type="checkbox" name="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[apple_touch_icon_ipad_mini_non_retina_ios_7]" value="1" <?php if($options['apple_touch_icon_ipad_mini_non_retina_ios_7'] == TRUE): ?> checked <?php endif; ?> />
							<label class="description" for="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[apple_touch_icon_ipad_mini_non_retina_ios_7]"><?php _e( 'Turn on the Apple Touch icon (Should be 76x76 pixels, in the webroot directory and named apple-touch-icon-76x76-precomposed.png). Sized For the iPad mini and the first- and second-generation iPad (@1× display) on iOS ≥ 7.', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></label>
						</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e( 'Apple Touch Icon - 114x114', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></th>
						<td>
							<input id="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[apple_touch_icon_iphone_retina]" class="regular-checkbox" type="checkbox" name="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[apple_touch_icon_iphone_retina]" value="1" <?php if($options['apple_touch_icon_iphone_retina'] == TRUE): ?> checked <?php endif; ?> />
							<label class="description" for="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[apple_touch_icon_iphone_retina]"><?php _e( 'Turn on the Apple Touch icon (Should be 114x114 pixels, in the webroot directory and named apple-touch-icon-114x114-precomposed.png). Sized for the iPhone Retina Screen.', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></label>
						</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e( 'Apple Touch Icon - 144x144', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></th>
						<td>
							<input id="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[apple_touch_icon_ipad_retina]" class="regular-checkbox" type="checkbox" name="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[apple_touch_icon_ipad_retina]" value="1" <?php if($options['apple_touch_icon_ipad_retina'] == TRUE): ?> checked <?php endif; ?> />
							<label class="description" for="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[apple_touch_icon_ipad_retina]"><?php _e( 'Turn on the Apple Touch icon (Should be 144x144 pixels, in the webroot directory and named apple-touch-icon-144x144-precomposed.png). For iPad with @2× display running iOS ≤ 6', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></label>
						</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e( 'Apple Touch Icon - 152x152', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></th>
						<td>
							<input id="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[apple_touch_icon_ipad_retina_ios7]" class="regular-checkbox" type="checkbox" name="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[apple_touch_icon_ipad_retina_ios7]" value="1" <?php if($options['apple_touch_icon_ipad_retina_ios7'] == TRUE): ?> checked <?php endif; ?> />
							<label class="description" for="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[apple_touch_icon_ipad_retina_ios7]"><?php _e( 'Turn on the Apple Touch icon (Should be 152x152 pixels, in the webroot directory and named apple-touch-icon-152x152-precomposed.png). For iPad with @2× display running iOS ≥ 7', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></label>
						</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e( 'Apple Touch Icon - 180x180', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></th>
						<td>
							<input id="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[apple_touch_icon_iphone_plus_3x_screen]" class="regular-checkbox" type="checkbox" name="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[apple_touch_icon_iphone_plus_3x_screen]" value="1" <?php if($options['apple_touch_icon_iphone_plus_3x_screen'] == TRUE): ?> checked <?php endif; ?> />
							<label class="description" for="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[apple_touch_icon_iphone_plus_3x_screen]"><?php _e( 'Turn on the Apple Touch icon (Should be 144x144 pixels, in the webroot directory and named apple-touch-icon-180x180-precomposed.png). For iPhone 6 Plus with @3× display', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></label>
						</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e( 'Chrome on Android - 192x192', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></th>
						<td>
							<input id="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[chrome_on_android]" class="regular-checkbox" type="checkbox" name="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[chrome_on_android]" value="1" <?php if($options['chrome_on_android'] == TRUE): ?> checked <?php endif; ?> />
							<label class="description" for="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[chrome_on_android]"><?php _e( 'Turn on the Chrome on Android icon (Should be 192x192 pixels, in the webroot directory and named touch-icon-192x192.png). Sized for Chrome Browsers in Android.', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></label>
						</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e( 'Fall Back Apple Touch Icon', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></th>
						<td>
							<input id="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[generic_apple_touch_icon]" class="regular-checkbox" type="checkbox" name="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[generic_apple_touch_icon]" value="1" <?php if($options['generic_apple_touch_icon'] == TRUE): ?> checked <?php endif; ?> />
							<label class="description" for="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[generic_apple_touch_icon]"><?php _e( 'Turn on the Generic Apple Touch Icon (Should be 192x192 pixels, in the webroot directory and named apple-touch-icon-precomposed.png). Fall back for iOS devices.', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></label>
						</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e( 'Additional Meta Tags', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></th>
						<td>
							<textarea id="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[additional_meta_tags]" class="large-text" rows="5" name="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[additional_meta_tags]"><?php if(isset($options['additional_meta_tags'])): echo $options['additional_meta_tags']; endif; ?></textarea>
							<label class="description" for="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[additional_meta_tags]"><?php _e( 'Enter in additional meta tags desired to be included on every page.', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></label>
						</td>
						</td>
					</tr>
				</table>

				<h2><?php _e( 'Reading/Writing Settings', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></h2>
				<table class="form-table">
					<tr valign="top"><th scope="row"><?php _e( 'Disable Comments', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></th>
						<td>
							<input id="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[comments_disabled]" class="regular-checkbox" type="checkbox" name="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[comments_disabled]" value="1" <?php if($options['comments_disabled'] == TRUE): ?> checked <?php endif; ?> />
							<label class="description" for="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[comments_disabled]"><?php _e( 'Hide the comment section on posts.', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></label>
						</td>
					</tr>
				</table>

				<h2><?php _e( 'Other Settings', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></h2>
				<table class="form-table">
					<tr valign="top"><th scope="row"><?php _e( 'Censored Website Bar', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></th>
						<td>
							<input id="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[censored_bar]" class="regular-checkbox" type="checkbox" name="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[censored_bar]" value="1" <?php if($options['censored_bar'] == TRUE): ?> checked <?php endif; ?> />
							<label class="description" for="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[censored_bar]"><?php _e( 'Turn on the <a href="http://americancensorship.org/" title="American Censorship Day">Censored Website Bar</a>', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></label>
						</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e( 'Internet Defense League Notification Bar', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></th>
						<td>
							<input id="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[internet_defense_league]" class="regular-checkbox" type="checkbox" name="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[internet_defense_league]" value="1" <?php if($options['internet_defense_league'] == TRUE): ?> checked <?php endif; ?> />
							<label class="description" for="<?php echo RESPONSIVE_CHILD_TEMPLATE_THEME_SETTINGS_OPTIONS; ?>[internet_defense_league]"><?php _e( 'Turn on the <a href="http://internetdefenseleague.org/" title="Internet Defense League Notification Bar">Internet Defense League Notification Bar</a>', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?></label>
						</td>
					</tr>
				</table>

				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e( 'Save Options', RESPONSIVE_CHILD_TEMPLATE_THEME_LANG_FILE ); ?>" />
				</p>
			</form>
		</div>
		<?php
	}

	/**
	 * theme_options_validate - validates input array
	 *
	 * @param  array  $input input array of values from the admin page options
	 * @return [type]        [description]
	 */
	public function theme_options_validate( $input = array()) {

		//Sanitize Input Text
		if(is_array($input) && array_key_exists('bitly_username', $input)){
			$input['bitly_username'] = wp_filter_nohtml_kses( $input['bitly_username'] );
		}
		if(is_array($input) && array_key_exists('bitly_api_key', $input)){
			$input['bitly_api_key'] = wp_filter_nohtml_kses( $input['bitly_api_key'] );
		}
		if(is_array($input) && array_key_exists('open_id_server', $input)){
			$input['open_id_server'] = wp_filter_nohtml_kses( $input['open_id_server'] );
		}
		if(is_array($input) && array_key_exists('open_id_delegate', $input)){
			$input['open_id_delegate'] = wp_filter_nohtml_kses( $input['open_id_delegate'] );
		}
		if(is_array($input) && array_key_exists('additional_meta_tags', $input)){
			$input['additional_meta_tags'] = $input['additional_meta_tags'];
		}

		if ( ! isset( $input['censored_bar'] ) ) {
			$input['censored_bar'] = null;
		}
		$input['censored_bar'] = ( $input['censored_bar'] == 1 ? 1 : 0 );

		if ( ! isset( $input['comments_disabled'] ) ) {
			$input['comments_disabled'] = null;
		}
		$input['comments_disabled'] = ( $input['comments_disabled'] == 1 ? 1 : 0 );

		if ( ! isset( $input['internet_defense_league'] ) ) {
			$input['internet_defense_league'] = null;
		}
		$input['internet_defense_league'] = ( $input['internet_defense_league'] == 1 ? 1 : 0 );

		if ( ! isset( $input['apple_touch_icon_iphone_non_retina'] ) ) {
			$input['apple_touch_icon_iphone_non_retina'] = null;
		}
		$input['apple_touch_icon_iphone_non_retina'] = ( $input['apple_touch_icon_iphone_non_retina'] == 1 ? 1 : 0 );

		if ( ! isset( $input['apple_touch_icon_iphone_retina'] ) ) {
			$input['apple_touch_icon_iphone_retina'] = null;
		}
		$input['apple_touch_icon_iphone_retina'] = ( $input['apple_touch_icon_iphone_retina'] == 1 ? 1 : 0 );

		if ( ! isset( $input['apple_touch_icon_ipad_mini_non_retina_ios_6'] ) ) {
			$input['apple_touch_icon_ipad_mini_non_retina_ios_6'] = null;
		}
		$input['apple_touch_icon_ipad_mini_non_retina_ios_6'] = ( $input['apple_touch_icon_ipad_mini_non_retina_ios_6'] == 1 ? 1 : 0 );

		if ( ! isset( $input['apple_touch_icon_ipad_mini_non_retina_ios_7'] ) ) {
			$input['apple_touch_icon_ipad_mini_non_retina_ios_7'] = null;
		}
		$input['apple_touch_icon_ipad_mini_non_retina_ios_7'] = ( $input['apple_touch_icon_ipad_mini_non_retina_ios_7'] == 1 ? 1 : 0 );

		if ( ! isset( $input['apple_touch_icon_ipad_retina'] ) ) {
			$input['apple_touch_icon_ipad_retina'] = null;
		}
		$input['apple_touch_icon_ipad_retina'] = ( $input['apple_touch_icon_ipad_retina'] == 1 ? 1 : 0 );

		if ( ! isset( $input['apple_touch_icon_ipad_retina_ios7'] ) ) {
			$input['apple_touch_icon_ipad_retina_ios7'] = null;
		}
		$input['apple_touch_icon_ipad_retina_ios7'] = ( $input['apple_touch_icon_ipad_retina_ios7'] == 1 ? 1 : 0 );

		if ( ! isset( $input['apple_touch_icon_iphone_plus_3x_screen'] ) ) {
			$input['apple_touch_icon_iphone_plus_3x_screen'] = null;
		}
		$input['apple_touch_icon_iphone_plus_3x_screen'] = ( $input['apple_touch_icon_iphone_plus_3x_screen'] == 1 ? 1 : 0 );

		if ( ! isset( $input['chrome_on_android'] ) ) {
			$input['chrome_on_android'] = null;
		}
		$input['chrome_on_android'] = ( $input['chrome_on_android'] == 1 ? 1 : 0 );

		if ( ! isset( $input['generic_apple_touch_icon'] ) ) {
			$input['generic_apple_touch_icon'] = null;
		}
		$input['generic_apple_touch_icon'] = ( $input['generic_apple_touch_icon'] == 1 ? 1 : 0 );

		if ( ! isset( $input['open_search'] ) ) {
			$input['open_search'] = null;
		}
		$input['open_search'] = wp_filter_post_kses( $input['open_search'] );

		/*
		// Our checkbox value is either 0 or 1
		if ( ! isset( $input['option1'] ) )
			$input['option1'] = null;
		$input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );

		// Say our text option must be safe text with no HTML tags
		$input['sometext'] = wp_filter_nohtml_kses( $input['sometext'] );

		// Our select option must actually be in our array of select options
		if ( ! array_key_exists( $input['selectinput'], $select_options ) )
			$input['selectinput'] = null;

		// Our radio option must actually be in our array of radio options
		if ( ! isset( $input['radioinput'] ) )
			$input['radioinput'] = null;
		if ( ! array_key_exists( $input['radioinput'], $radio_options ) )
			$input['radioinput'] = null;

		// Say our textarea option must be safe text with the allowed tags for posts
		$input['sometextarea'] = wp_filter_post_kses( $input['sometextarea'] );
		*/

		return $input;
	}

}
