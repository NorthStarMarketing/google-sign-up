<?php
/**
 * Class UtilityTest
 *
 * @package Sign_In_With_Google
 */

use PHPUnit\Framework\TestCase;

/**
 * Tests the class responsible for Admin functionality.
 */
class AdminTest extends TestCase {

	/**
	 * The Admin class.
	 *
	 * @var Sign_In_With_Google_Admin
	 */
	private $admin;

	/**
	 * Test that the class can be instantiated.
	 */
	public function setUp() {
		$this->admin = new Sign_In_With_Google_Admin( 'sign-in-with-google', '1.0.0' );
	}

	/**
	 * Test
	 *
	 * @param string $email           The address of which to get the domain.
	 * @param string $expected_result The expected domain.
	 *
	 * @dataProvider providerGetDomainFromEmail
	 */
	public function testGetDomainFromEmailReturnsDomain( $email, $expected_result ) {
		$result = $this->admin->get_domain_from_email( $email );

		$this->assertEquals( $expected_result, $result );
	}

	/**
	 * Provides the test cases for testGetdomainFromEmailReturnsDomain.
	 */
	public function providerGetDomainFromEmail() {

		return array(
			array( 'first.last@example.com', 'example.com' ),
			array( 'first@example.com', 'example.com' ),
			array( 'first.last@example.co.uk', 'example.co.uk' ),
		);
	}
}
