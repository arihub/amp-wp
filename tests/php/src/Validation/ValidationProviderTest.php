<?php

namespace AmpProject\AmpWP\Tests\Validation;

use AmpProject\AmpWP\Tests\Helpers\AssertContainsCompatibility;
use AmpProject\AmpWP\Tests\Helpers\PrivateAccess;
use AmpProject\AmpWP\Tests\Helpers\ValidationRequestMocking;
use AmpProject\AmpWP\Validation\ValidationProvider;
use WP_UnitTestCase;

/** @coversDefaultClass ValidationProvider */
final class ValidationProviderTest extends WP_UnitTestCase {
	use PrivateAccess, AssertContainsCompatibility;

	/**
	 * Setup.
	 *
	 * @inheritdoc
	 */
	public function setUp() {
		parent::setUp();
		$this->validation_provider = new ValidationProvider( 100 );
		add_filter( 'pre_http_request', [ ValidationRequestMocking::class, 'get_validate_response' ] );
	}

	/**
	 * Test get_url_validation.
	 *
	 * @covers ::get_url_validation()
	 */
	public function test_get_url_validation() {
		$single_post_permalink = get_permalink( self::factory()->post->create() );
		$this->call_private_method( $this->validation_provider, 'get_url_validation', [ $single_post_permalink, 'post' ] );
		$this->assertTrue( in_array( $single_post_permalink, ValidationRequestMocking::get_validated_urls(), true ) );

		$number_of_posts = 30;
		$post_permalinks = [];

		for ( $i = 0; $i < $number_of_posts; $i++ ) {
			$permalink         = get_permalink( self::factory()->post->create() );
			$post_permalinks[] = $permalink;
			$this->call_private_method( $this->validation_provider, 'get_url_validation', [ $permalink, 'post' ] );
		}

		// All of the posts created should be present in the validated URLs.
		$this->assertEmpty( array_diff( $post_permalinks, ValidationRequestMocking::get_validated_urls() ) );

		$this->assertEquals( 31, $this->validation_provider->total_errors );
		$this->assertEmpty( $this->validation_provider->unaccepted_errors );
		$this->assertEquals( 31, $this->validation_provider->number_crawled );

		$this->assertEquals(
			[ 'post' ],
			array_keys( $this->validation_provider->validity_by_type )
		);
	}

	/**
	 * Tests locking and unlocking.
	 *
	 * @covers ::lock
	 * @covers ::unlock
	 * @covers ::is_locked
	 * @covers ::get_lock_timeout
	 * @covers ::with_lock
	 */
	public function test_locking() {
		$this->assertFalse( get_transient( ValidationProvider::LOCK_TRANSIENT ) );

		$expected_result = 'EXPECTED RESULT';
		$result          = $this->validation_provider->with_lock(
			function() use ( $expected_result ) {
				$this->assertEquals( 'locked', get_transient( ValidationProvider::LOCK_TRANSIENT ) );

				// Expect an error when lock is already in place.
				$this->assertWPError( $this->validation_provider->with_lock( '__return_empty_string' ) );

				return $expected_result;
			}
		);

		$this->assertEquals( $expected_result, $result );
		$this->assertFalse( get_transient( ValidationProvider::LOCK_TRANSIENT ) );

		// Test with_lock with no return value.
		$this->assertNull(
			$this->validation_provider->with_lock(
				function() {
					$this->assertEquals( 'locked', get_transient( ValidationProvider::LOCK_TRANSIENT ) );
					return;
				}
			)
		);
		$this->assertFalse( get_transient( ValidationProvider::LOCK_TRANSIENT ) );
	}
}