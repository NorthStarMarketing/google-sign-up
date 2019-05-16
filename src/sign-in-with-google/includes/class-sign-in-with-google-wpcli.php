<?php
/**
 * Register all wpcli commands for the plugin.
 *
 * @link       http://www.northstarmarketing.com
 * @since      1.2.2
 *
 * @package    Sign_In_With_Google
 * @subpackage Sign_In_With_Google/includes
 */

/**
 * Register all wpcli commands for the plugin.
 *
 * @package    Sign_In_With_Google
 * @subpackage Sign_In_With_Google/includes
 * @author     Tanner Record <tanner.record@northstarmarketing.com>
 */
class Sign_In_With_Google_WPCLI {

	/** phpcs:ignore
	 * Allows updating of Sign In With Google's settings
	 *
	 * ## OPTIONS
	 *
	 * [--client_id=<client_id>]
	 * : Your Oauth Client ID from console.developers.google.com
	 *
	 * [--client_secret=<client_secret>]
	 * : Your Oauth Client Secret from console.developers.google.com
	 *
	 * [--default_role=<role>]
	 * : The role new users should have.
	 * ---
	 * default: subscriber
	 * options:
	 *   - subscriber
	 *   - contributor
	 *   - author
	 *   - editor
	 *   - administrator
	 * ---
	 *
	 * [--domains=<domains>]
	 * : A comma separated list of domains to restrict new users to.
	 * ---
	 * example:
	 *     wp siwg settings --domains=google.com,example.net,other.org
	 * ---
	 *
	 * [--custom_login_param=<parameter>]
	 * : The custom login parameter to be used.
	 * ---
	 * example:
	 *     wp siwg settings --custom_login_param=logmein
	 * ---
	 * URL to log in:
	 *     https://www.example.com?logmein // Send the user to authenticate with Google and log in
	 *     https://www.example.com/my-custom-post?logmein // Log the user in and redirect to my-custom-post
	 * ---
	 *
	 * [--show_on_login=<true|false>]
	 * : Show the "Sign In With Google" button on the login form.
	 *
	 * ## EXAMPLES
	 *
	 *     wp siwg settings --client_id=XXXXXX.apps.googleusercontent.com
	 *
	 * @when after_wp_load
	 */
	public function settings( $args = array(), $assoc_args = array() ) {

		// Sanitize everything.
		$this->sanitize_args( $assoc_args );

		// Verify the list of domains and update the setting.
		if ( isset( $assoc_args['domains'] ) ) {
			$this->update_domain_restriction( $assoc_args['domains'] );
		}

		WP_CLI::success( 'Plugin settings updated' );

	}

	/**
	 * Handles updating siwg_google_domain_restriction in the options table.
	 *
	 * @param string $domains The string of domains to verify and use.
	 */
	private function update_domain_restriction( $domains = '' ) {

		if ( ! Sign_In_With_Google_Utility::verify_domain_list( $domains ) ) {
			WP_CLI::error( 'Please use a valid list of domains' );
		}

		$result = update_option( 'siwg_google_domain_restriction', $domains );

		if ( ! $result ) {
			WP_CLI::warning( 'Not updating domain restriction - Input matches current setting' );
		}

	}

	/**
	 * Sanitize command arguments
	 *
	 * @since 1.2.2
	 *
	 * @param array $args An array of arguments to sanitize.
	 */
	private function sanitize_args( $args = array() ) {
		$sanitized_assoc_args = array();

		// Just return if $args is empty.
		if ( empty( $args ) ) {
			return;
		}

		foreach ( $args as $key => $value ) {
			$sanitized_assoc_args[ $key ] = sanitize_text_field( $value );
		}

		return $sanitized_assoc_args;
	}


}