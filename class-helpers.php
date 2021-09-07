<?php

class UBP_Helpers {

	/**
	 * Only load required files on the 404_template hook
	 */
	public static function init_404_template( $template ) {
		global $UBP_404_Template;
		require_once dirname( __FILE__ ) . '/class-404-template.php';
		$UBP_404_Template = new UBP_404_Template();
		return $template;
	}

	public static function requirements_check() {
		add_action( 'admin_notices', 'UBP_Helpers::request_uploads_writable' );
		add_action( 'admin_footer', 'UBP_Helpers::request_permalinks_enabled' );
	}

	/**
	 * Display an error message when permalinks are disabled
	 * Runs on admin_footer becuase admin_notices hook is too early to catch recent changes in permalinks
	 */
	public static function request_permalinks_enabled() {
		if ( '' != get_option( 'permalink_structure' ) ) {
			return true; }

		echo '<div id="ubp_permalinks_message" class="error"><p>'
			 . __( 'Pretty Permalinks must be enabled for Uploads by Proxy to work. ', 'uploads-by-proxy' )
			 . sprintf( __( '%1$sRead about using Permalinks%3$s, then %2$sgo to your Permalinks settings%3$s.', 'uploads-by-proxy' ), '<a href="http://codex.wordpress.org/Using_Permalinks" target="_blank">', '<a href="options-permalink.php">', '</a>' )
			 . '</p></div>';

		return false;
	}

	/**
	 * Display an error message when uploads folder is not writable
	 */
	public static function request_uploads_writable() {
		$upload_dir = wp_upload_dir();
		if ( is_writable( $upload_dir['basedir'] ) ) {
			return true; }

		echo '<div id="ubp_uploads_message" class="error"><p>'
			 . __( 'The uploads directory must be enabled for Uploads by Proxy to work. ', 'uploads-by-proxy' )
			 . sprintf( __( '%1$sRead about changing file permissions%2$s, or try running:', 'uploads-by-proxy' ), '<a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">', '</a>' )
			 . sprintf( "<br/><code>chmod 755 '%s';</code>", $upload_dir['basedir'] )
			 . '</p></div>';

		return false;
	}

}
