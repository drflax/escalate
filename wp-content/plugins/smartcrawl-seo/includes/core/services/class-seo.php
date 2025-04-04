<?php
/**
 * Seo_Free class for handling free SEO services in SmartCrawl.
 *
 * @package SmartCrawl
 */

namespace SmartCrawl\Services;

use SmartCrawl\Seo_Report;

/**
 * Class Seo_Free
 *
 * Handles free SEO services.
 */
class Seo extends Service {

	const ERR_BASE_API_ISSUE = 40;

	const ERR_BASE_CRAWL_RUN = 51;

	const ERR_BASE_COOLDOWN = 52;

	const ERR_BASE_CRAWL_ERR = 53;

	const ERR_BASE_GENERIC = 59;

	/**
	 * Retrieves known verbs.
	 *
	 * @return array The known verbs.
	 */
	public function get_known_verbs() {
		return array();
	}

	/**
	 * Checks if the verb is cacheable.
	 *
	 * @param string $verb The verb to check.
	 *
	 * @return bool False as no verb is cacheable.
	 */
	public function is_cacheable_verb( $verb ) {
		return false;
	}

	/**
	 * Retrieves the service base URL.
	 *
	 * @return string|false The service base URL or false if not available.
	 */
	public function get_service_base_url() {
		return false;
	}

	/**
	 * Retrieves the request URL for the given verb.
	 *
	 * @param string $verb The verb to get the request URL for.
	 *
	 * @return string|false The request URL or false if the verb is empty.
	 */
	public function get_request_url( $verb ) {
		return false;
	}

	/**
	 * Retrieves the request arguments for the given verb.
	 *
	 * @param string $verb The verb to get the request arguments for.
	 *
	 * @return array The request arguments.
	 */
	public function get_request_arguments( $verb ) {
		return array();
	}

	/**
	 * Local ignores list sync handler
	 *
	 * @return bool Status
	 */
	public function sync_ignores() {
		return false;
	}

	/**
	 * Checks whether a call is currently being processed
	 *
	 * @return bool
	 */
	public function in_progress() {
		$flag = $this->get_progress_flag();

		$expected_timeout = intval( $flag ) + ( HOUR_IN_SECONDS / 4 );
		if ( ! empty( $flag ) && is_numeric( $flag ) && time() > $expected_timeout ) {
			// Over timeout threshold, clear flag forcefully.
			$this->stop();
		}

		return ! ! $flag;
	}

	/**
	 * Gets progress flag state
	 *
	 * @return bool
	 */
	public function get_progress_flag() {
		return get_option( $this->get_filter( 'seo-progress' ), false );
	}

	/**
	 * Stops expecting response
	 *
	 * @return bool
	 */
	public function stop() {
		$this->set_progress_flag( false );

		return true;
	}

	/**
	 * Sets progress flag state.
	 *
	 * @param bool $flag Whether the service check is in progress.
	 *
	 * @return bool
	 */
	public function set_progress_flag( $flag ) {
		if ( ! empty( $flag ) ) {
			$flag = time();
		}

		return ! ! update_option( $this->get_filter( 'seo-progress' ), $flag );
	}

	/**
	 * Public wrapper for start service method call
	 *
	 * @return bool Service response hash on success, (bool) on failure
	 */
	public function start() {
		$this->stop();

		return false;
	}

	/**
	 * Public wrapper for status service method call
	 *
	 * @return bool Service response hash on success, (bool)false on failure
	 */
	public function status() {
		return false;
	}

	/**
	 * Public wrapper for result service method call
	 *
	 * @return bool Service response hash on success, (bool)false on failure
	 */
	public function result() {
		return false;
	}

	/**
	 * Retrieves cooldown timer.
	 *
	 * @return false
	 */
	public function get_cooldown_remaining() {
		return false;
	}

	/**
	 * Sets result to new value.
	 *
	 * Sets both cache and permanent result.
	 *
	 * @param array $result Result.
	 *
	 * @return bool
	 */
	public function set_result( $result ) {
		return ! ! update_option( $this->get_filter( 'seo-service-result' ), $result );
	}

	/**
	 * Returns last service run time
	 *
	 * Returns either time embedded in results, or the timestamp
	 * from the results service, whichever is greater.
	 *
	 * @return int UNIX timestamp
	 */
	public function get_last_run_timestamp() {
		$recorded = (int) get_option( $this->get_filter( 'seo-service-last_runtime' ), 0 );

		$raw      = $this->get_result();
		$embedded = ! empty( $raw['end'] ) ? (int) $raw['end'] : 0;
		if ( empty( $embedded ) && ! empty( $raw['issues']['previous']['timestamp'] ) ) {
			$embedded = (int) $raw['issues']['previous']['timestamp'];
		}

		return max( $recorded, $embedded );
	}

	/**
	 * Public result getter
	 *
	 * @return mixed result
	 */
	public function get_result() {
		return get_option( $this->get_filter( 'seo-service-result' ), array() );
	}

	/**
	 * Sets service last run time
	 *
	 * Attempts to use embedded result, and falls back
	 * to current timestamp
	 *
	 * @return bool
	 */
	public function set_last_run_timestamp() {
		$raw       = $this->get_result();
		$timestamp = ! empty( $raw['end'] ) ? (int) $raw['end'] : 0;
		if ( empty( $timestamp ) && ! empty( $raw['issues']['previous']['timestamp'] ) ) {
			$timestamp = (int) $raw['issues']['previous']['timestamp'];
		}

		if ( empty( $timestamp ) ) {
			$timestamp = time();
		}

		return ! ! update_option( $this->get_filter( 'seo-service-last_runtime' ), $timestamp );
	}

	/**
	 * Handles the error response.
	 *
	 * @param object $response The response to handle.
	 * @param string $verb     The verb that caused the error.
	 *
	 * @return bool True if the error was handled, false otherwise.
	 */
	public function handle_error_response( $response, $verb ) {
		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );
		if ( empty( $body ) || empty( $data ) ) {
			$this->set_error_message( __( 'Unspecified error', 'smartcrawl-seo' ) );

			return true;
		}

		$msg = '';
		if ( ! empty( $data['message'] ) ) {
			$msg = $data['message'];
		}

		if ( ! empty( $data['data']['manage_link'] ) ) {
			$url = esc_url( $data['data']['manage_link'] );

			$msg .= ' <a href="' . $url . '">' . __( 'Manage', 'smartcrawl-seo' ) . '</a>';
		}

		if ( ! empty( $msg ) ) {
			$this->set_error_message( $msg );
		}

		return true;
	}

	/**
	 * Retrieves the SEO report.
	 *
	 * @return Seo_Report The SEO report.
	 */
	public function get_report() {
		return new Seo_Report();
	}

}
