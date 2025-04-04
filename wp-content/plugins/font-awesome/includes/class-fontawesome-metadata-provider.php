<?php
/**
 * This module is not considered part of the public API, only internal.
 * Any data or functionality that it produces should be exported by the
 * main FontAwesome class and the API documented and semantically versioned there.
 */
namespace FortAwesome;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use WP_Error, Error, Exception;

require_once trailingslashit( FONTAWESOME_DIR_PATH ) . 'includes/class-fontawesome-api-settings.php';

/**
 * Provides metadata about Font Awesome icons.
 *
 * Internal use only. Not part of this plugin's public API.
 *
 * @internal
 */
class FontAwesome_Metadata_Provider {
	/**
	 * Singleton instance.
	 *
	 * @internal
	 */
	protected static $instance = null;

	/**
	 * Post method that wraps wp_remote_post.
	 *
	 * Internal use only. Not part of this plugin's public API.
	 *
	 * @internal
	 */
	protected function post( $url, $args = array() ) {
		return wp_remote_post( $url, $args );
	}

	/**
	 * Returns the FontAwesome_Metadata_Provider singleton instance.
	 *
	 * Internal use only. Not part of this plugin's public API.
	 *
	 * @return FontAwesome_Metadata_Provider
	 * @internal
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Resets the singleton instance referenced by this class and returns that new instance.
	 * All previous releases metadata held in the previous instance will be abandoned.
	 *
	 * Internal use only. Not part of this plugin's public API.
	 *
	 * @return FontAwesome_Metadata_Provider
	 */
	public static function reset() {
		self::$instance = null;
		return self::instance();
	}

	/**
	 * Returns query errors if there was a problem querying the
	 * graphql api in a readable string.
	 *
	 * @ignore
	 */
	protected function query_errors( $errors ) {
		$error_string = '';

		foreach ( $errors as $error ) {
			$error_string .= $error['message'];
		}

		return $error_string;
	}

	/**
	 * Queries the GraphQL API and returns the response body when the HTTP status
	 * of the response is 200.
	 *
	 * Internal use only. Not part of this plugin's public API.
	 *
	 * External code should use {@see FontAwesome::query()} instead.
	 *
	 * @param string | array $query {@see FontAwesome::query()}.
	 * @param $ignore_auth when TRUE this will omit an authorization header on
	 *     the network request, even if an apiToken is present.
	 * @ignore
	 * @internal
	 * @throws ApiTokenMissingException
	 * @throws ApiTokenEndpointRequestException
	 * @throws ApiTokenEndpointResponseException
	 * @throws ApiTokenInvalidException
	 * @throws AccessTokenStorageException
	 * @throws ApiRequestException
	 * @throws ApiResponseException
	 * @return string json encoded response body when the API server response
	 *     has a HTTP 200 status.
	 */
	public function metadata_query( $query, $ignore_auth = false ) {
		$body = '';

		if ( is_string( $query ) ) {
			$body = '{"query": ' . wp_json_encode( $query ) . '}';
		} elseif ( is_array( $query ) ) {
			$filtered_query_array          = array();
			$filtered_query_array['query'] = $query['query'];
			if ( array_key_exists( 'variables', $query ) ) {
				$filtered_query_array['variables'] = $query['variables'];
			}

			$body = wp_json_encode( $filtered_query_array );
		}

		$args = array(
			'method'  => 'POST',
			'headers' => array(
				'Content-Type' => 'application/json',
			),
			'body'    => $body,
			'timeout' => 10, // seconds.
		);

		if ( ! $ignore_auth ) {
			$access_token                     = fa_api_settings()->current_access_token();
			$args['headers']['authorization'] = "Bearer $access_token";
		}

		$response = $this->post( FONTAWESOME_API_URL, $args );

		if ( $response instanceof WP_Error ) {
			// phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped
			throw ApiRequestException::with_wp_error( add_failed_request_diagnostics( $response ) );
		}

		if ( 200 === $response['response']['code'] ) {
			return $response['body'];
		} else {
			// phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped
			throw ApiResponseException::with_wp_response( $response );
		}
	}
}

// phpcs:disable Universal.Files.SeparateFunctionsFromOO.Mixed

/**
 * Convenience global function to get a singleton instance of the Metadata Provider.
 *
 * Internal use only. Not part of this plugin's public API.
 *
 * @see FontAwesome_Metadata_Provider::instance()
 * @return FontAwesome_Metadata_Provider
 * @internal
 */
function fa_metadata_provider() {
	return FontAwesome_Metadata_Provider::instance();
}
