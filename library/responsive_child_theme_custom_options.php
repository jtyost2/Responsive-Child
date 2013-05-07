<?php
class ResponsiveChildThemeCustomOptions {

	/**
	 * [$instance description]
	 * @var [type]
	 */
	static $instance;

	/**
	 * [$ProjectDB description]
	 * @var [type]
	 */
	public $ProjectDB = null;

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
			__( 'Responsive Child Theme Options', 'responsive_child' ),
			__( 'Responsive Child Theme Options', 'responsive_child' ),
			'edit_theme_options',
			'responsive_child_theme_options',
			array($this, 'theme_options_do_page')
		);
	}

	public function theme_options_init(){
		register_setting(
			'responsive_child_options',
			'responsive_child_theme_options',
			array($this, 'theme_options_validate')
		);
	}

	public function theme_options_do_page() {
		global $select_options, $radio_options;

		if ( ! isset( $_REQUEST['updated'] ) )
			$_REQUEST['updated'] = false;

		?>
		<div class="wrap">
			<?php screen_icon(); echo "<h2>" . wp_get_theme() . __( ' Theme Options', 'responsive_child' ) . "</h2>"; ?>

			<?php if ( false !== $_REQUEST['updated'] ) : ?>
			<div class="updated fade"><p><strong><?php _e( 'Options saved', 'responsive_child' ); ?></strong></p></div>
			<?php endif; ?>

			<form method="post" action="options.php">
				<?php settings_fields( 'responsive_child_options' ); ?>
				<?php $options = get_option( 'responsive_child_theme_options' ); ?>
				<h2><?php _e( 'Social Media Settings', 'responsive_child' ); ?></h2>
				<table class="form-table">
					<tr valign="top"><th scope="row"><?php _e( 'Bit.ly Username', 'responsive_child' ); ?></th>
						<td>
							<input id="responsive_child_theme_options[bitly_username]" class="regular-text" type="text" name="responsive_child_theme_options[bitly_username]" value="<?php esc_attr_e( $options['bitly_username'] ); ?>" />
							<label class="description" for="responsive_child_theme_options[bitly_username]"><?php _e( 'Enter your <a href="http://bit.ly/a/your_api_key" target="_blank" title="Get your Bit.ly Username">Bit.ly Username</a>', 'responsive_child' ); ?></label>
						</td>
					</tr>

					<tr valign="top"><th scope="row"><?php _e( 'Bit.ly API Key', 'responsive_child' ); ?></th>
						<td>
							<input id="responsive_child_theme_options[bitly_api_key]" class="regular-text" type="text" name="responsive_child_theme_options[bitly_api_key]" value="<?php esc_attr_e( $options['bitly_api_key'] ); ?>" />
							<label class="description" for="responsive_child_theme_options[bitly_api_key]"><?php _e( 'Enter your <a href="http://bit.ly/a/your_api_key" target="_blank" title="Get your Bit.ly API Key">Bit.ly API Key</a>', 'responsive_child' ); ?></label>
						</td>
					</tr>

					<tr valign="top"><th scope="row"><?php _e( 'Open ID Server URL', 'responsive_child' ); ?></th>
						<td>
							<input id="responsive_child_theme_options[open_id_server]" class="regular-text" type="text" name="responsive_child_theme_options[open_id_server]" value="<?php esc_attr_e( $options['open_id_server'] ); ?>" />
							<label class="description" for="responsive_child_theme_options[open_id_server]"><?php _e( 'Enter in your OpenID Server URL, to use your site\'s url as a delegate server. For example if using MyOpenId, enter in http://www.myopenid.com/server/. More info here: <a href="http://openid.net/specs/openid-authentication-1_1.html#delegating_authentication" target="_blank" title="OpenID Delegate Server">http://openid.net/specs/openid-authentication-1_1.html#delegating_authentication</a>', 'responsive_child' ); ?></label>
						</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e( 'OpenID Delegate URL', 'responsive_child' ); ?></th>
						<td>
							<input id="responsive_child_theme_options[open_id_delegate]" class="regular-text" type="text" name="responsive_child_theme_options[open_id_delegate]" value="<?php esc_attr_e( $options['open_id_delegate'] ); ?>" />
							<label class="description" for="responsive_child_theme_options[open_id_delegate]"><?php _e( 'Enter in your OpenID Delegate Url, to use your site\'s url as a delegate server. For example if using MyOpenId, enter in http://{username}.myopenid.com/. More info here: <a href="http://openid.net/specs/openid-authentication-1_1.html#delegating_authentication" target="_blank" title="OpenID Delegate Server">http://openid.net/specs/openid-authentication-1_1.html#delegating_authentication</a>', 'responsive_child' ); ?></label>
						</td>
					</tr>

				</table>

				<h2><?php _e( 'Meta Settings', 'responsive_child' ); ?></h2>
				<table class="form-table">
					<tr valign="top"><th scope="row"><?php _e( 'Apple Touch Icon - 57x57', 'responsive_child' ); ?></th>
						<td>
							<input id="responsive_child_theme_options[apple_touch_icon_iphone_non_retina]" class="regular-checkbox" type="checkbox" name="responsive_child_theme_options[apple_touch_icon_iphone_non_retina]" value="1" <?php if($options['apple_touch_icon_iphone_non_retina'] == TRUE): ?> checked <?php endif; ?> />
							<label class="description" for="responsive_child_theme_options[apple_touch_icon_iphone_non_retina]"><?php _e( 'Turn on the Apple Touch icon (Should be 57x57 pixels, in the webroot directory and named apple-touch-icon-57x57-precomposed.png). Sized for the iPhone Non-Retina Screen.', 'responsive_child' ); ?></label>
						</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e( 'Apple Touch Icon - 114x114', 'responsive_child' ); ?></th>
						<td>
							<input id="responsive_child_theme_options[apple_touch_icon_iphone_retina]" class="regular-checkbox" type="checkbox" name="responsive_child_theme_options[apple_touch_icon_iphone_retina]" value="1" <?php if($options['apple_touch_icon_iphone_retina'] == TRUE): ?> checked <?php endif; ?> />
							<label class="description" for="responsive_child_theme_options[apple_touch_icon_iphone_retina]"><?php _e( 'Turn on the Apple Touch icon (Should be 114x114 pixels, in the webroot directory and named apple-touch-icon-114x114-precomposed.png). Sized for the iPhone Retina Screen.', 'responsive_child' ); ?></label>
						</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e( 'Apple Touch Icon - 72x72', 'responsive_child' ); ?></th>
						<td>
							<input id="responsive_child_theme_options[apple_touch_icon_ipad_non_retina]" class="regular-checkbox" type="checkbox" name="responsive_child_theme_options[apple_touch_icon_ipad_non_retina]" value="1" <?php if($options['apple_touch_icon_ipad_non_retina'] == TRUE): ?> checked <?php endif; ?> />
							<label class="description" for="responsive_child_theme_options[apple_touch_icon_ipad_non_retina]"><?php _e( 'Turn on the Apple Touch icon (Should be 72x72 pixels, in the webroot directory and named apple-touch-icon-72x72-precomposed.png). Sized for the iPad Non-Retina Screen.', 'responsive_child' ); ?></label>
						</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e( 'Apple Touch Icon - 144x144', 'responsive_child' ); ?></th>
						<td>
							<input id="responsive_child_theme_options[apple_touch_icon_ipad_retina]" class="regular-checkbox" type="checkbox" name="responsive_child_theme_options[apple_touch_icon_ipad_retina]" value="1" <?php if($options['apple_touch_icon_ipad_retina'] == TRUE): ?> checked <?php endif; ?> />
							<label class="description" for="responsive_child_theme_options[apple_touch_icon_ipad_retina]"><?php _e( 'Turn on the Apple Touch icon (Should be 144x144 pixels, in the webroot directory and named apple-touch-icon-144x144-precomposed.png). Sized for the iPad Retina Screen.', 'responsive_child' ); ?></label>
						</td>
					</tr>
				</table>

				<h2><?php _e( 'Reading/Writing Settings', 'responsive_child' ); ?></h2>
				<table class="form-table">
					<tr valign="top"><th scope="row"><?php _e( 'Disable Comments', 'responsive_child' ); ?></th>
						<td>
							<input id="responsive_child_theme_options[comments_disabled]" class="regular-checkbox" type="checkbox" name="responsive_child_theme_options[comments_disabled]" value="1" <?php if($options['comments_disabled'] == TRUE): ?> checked <?php endif; ?> />
							<label class="description" for="responsive_child_theme_options[comments_disabled]"><?php _e( 'Hide the comment section on posts.', 'responsive_child' ); ?></label>
						</td>
					</tr>
				</table>

				<h2><?php _e( 'Other Settings', 'responsive_child' ); ?></h2>
				<table class="form-table">
					<tr valign="top"><th scope="row"><?php _e( 'Censored Website Bar', 'responsive_child' ); ?></th>
						<td>
							<input id="responsive_child_theme_options[censored_bar]" class="regular-checkbox" type="checkbox" name="responsive_child_theme_options[censored_bar]" value="1" <?php if($options['censored_bar'] == TRUE): ?> checked <?php endif; ?> />
							<label class="description" for="responsive_child_theme_options[censored_bar]"><?php _e( 'Turn on the <a href="http://americancensorship.org/" title="American Censorship Day">Censored Website Bar</a>', 'responsive_child' ); ?></label>
						</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e( 'Internet Defense League Notification Bar', 'responsive_child' ); ?></th>
						<td>
							<input id="responsive_child_theme_options[internet_defense_league]" class="regular-checkbox" type="checkbox" name="responsive_child_theme_options[internet_defense_league]" value="1" <?php if($options['internet_defense_league'] == TRUE): ?> checked <?php endif; ?> />
							<label class="description" for="responsive_child_theme_options[internet_defense_league]"><?php _e( 'Turn on the <a href="http://internetdefenseleague.org/" title="Internet Defense League Notification Bar">Internet Defense League Notification Bar</a>', 'responsive_child' ); ?></label>
						</td>
					</tr>
				</table>


				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'responsive_child' ); ?>" />
				</p>
			</form>
		</div>
		<?php
	}

	public function theme_options_validate( $input ) {

		//Sanitize Input Text
		$input['bitly_username'] = wp_filter_nohtml_kses( $input['bitly_username'] );
		$input['bitly_api_key'] = wp_filter_nohtml_kses( $input['bitly_api_key'] );
		$input['open_id_server'] = wp_filter_nohtml_kses( $input['open_id_server'] );
		$input['open_id_delegate'] = wp_filter_nohtml_kses( $input['open_id_delegate'] );

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

		if ( ! isset( $input['apple_touch_icon_ipad_non_retina'] ) ) {
			$input['apple_touch_icon_ipad_non_retina'] = null;
		}
		$input['apple_touch_icon_ipad_non_retina'] = ( $input['apple_touch_icon_ipad_non_retina'] == 1 ? 1 : 0 );

		if ( ! isset( $input['apple_touch_icon_ipad_retina'] ) ) {
			$input['apple_touch_icon_ipad_retina'] = null;
		}
		$input['apple_touch_icon_ipad_retina'] = ( $input['apple_touch_icon_ipad_retina'] == 1 ? 1 : 0 );

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
?>