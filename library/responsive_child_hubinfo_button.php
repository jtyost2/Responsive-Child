<?php
class ResponsiveChildHubinfoButton {

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
		add_shortcode( 'hubinfo', array($this, 'hubinfo') );

		//Register Scripts
		wp_register_script(
			'responsive.child.hubinfo.min',
			RESPONSIVE_CHILD_TEMPLATE_URI . "/js/hubinfo.min.js",
			array('jquery')
		);

		//Register Styles
		wp_register_style(
			'responsive.child.hubinfo.min',
			RESPONSIVE_CHILD_TEMPLATE_URI."/css/hubinfo.min.css"
		);
	}

	public function hubinfo($atts) {
		extract( shortcode_atts( array(
			'user' => 'jtyost2',
			'repo' => 'Erudite-Child-Theme',
			'twitter' => 'jtyost2',
		), $atts ) );

		wp_enqueue_script('responsive.child.hubinfo.min');
		wp_enqueue_style('responsive.child.hubinfo.min' );

		return self::_hubinfo_button($user, $repo, $twitter);
	}

	protected function _hubinfo_button($userName = null, $repoName = null, $twitterUsername = null) {
		$randomValue = self::_return_random_value();
		$scriptString = null;
		$scriptString .= '<div class="hubInfo" id="' . $randomValue . '"> </div>';
		$scriptString .= '<script type="text/javascript">';
		$scriptString .= 'jQuery(document).ready(function(){';
		$scriptString .= '
		var hubInfoDiv' . $randomValue . ' = jQuery("div.hubInfo#' . $randomValue . '").hubInfo({
			user: "' . $userName . '",
			repo: "' . $repoName . '"
		});';

		if(!empty($twitterUsername)) {
			$scriptString .= '
			hubInfoDiv' . $randomValue . '.on(\'render\', function() {
				jQuery(\'<a href="https://twitter.com/share" class="twitter-share-button" data-via="' . $twitterUsername . '">Tweet</a>\')
					.insertAfter("div.hubInfo#' . $randomValue . ' .repo-forks");
				!function(d,s,id){
					var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}
				}(document,"script","twitter-wjs");
			});';
		}
		$scriptString .= "});";
		$scriptString .= '</script>';
		return $scriptString;
	}

	protected function _make_seed() {
		list($usec, $sec) = explode(' ', microtime());
		return (float) $sec + ((float) $usec * 100000);
	}

	protected function _return_random_value() {
		mt_srand(self::_make_seed());
		return mt_rand();
	}
}
