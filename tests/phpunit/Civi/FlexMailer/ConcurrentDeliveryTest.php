<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.7                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2017                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
 */
namespace Civi\FlexMailer;

/**
 *
 * @copyright CiviCRM LLC (c) 2004-2017
 * @version $Id: Job.php 30879 2010-11-22 15:45:55Z shot $
 *
 */

// For compat w/v4.6 phpunit
require_once 'tests/phpunit/api/v3/JobProcessMailingTest.php';

/**
 * Class ConcurrentDeliveryTest
 *
 * Check that CiviMail batching and concurrency features work as expected.
 * This is a variation on api_v3_JobProcessMailingTest -- but this uses
 * FlexMailer instead of BAO delivery.
 *
 * @group headless
 * @group civimail
 * @see \api_v3_JobProcessMailingTest
 */
class ConcurrentDeliveryTest extends \api_v3_JobProcessMailingTest {

  public function setUp() {
    // Activate before transactions are setup.
    $manager = \CRM_Extension_System::singleton()->getManager();
    if ($manager->getStatus('org.civicrm.flexmailer') !== \CRM_Extension_Manager::STATUS_INSTALLED) {
      $manager->install(array('org.civicrm.flexmailer'));
    }

    parent::setUp();

    \Civi::settings()->set('flexmailer_traditional', 'flexmailer');
  }

  public function tearDown() {
    // We're building on someone else's test and don't fully trust them to
    // protect our settings. Make sure they did.
    $ok = ('flexmailer' == \Civi::settings()->get('flexmailer_traditional'))
      && ('s:10:"flexmailer";' === \CRM_Core_DAO::singleValueQuery('SELECT value FROM civicrm_setting WHERE name ="flexmailer_traditional"'));

    parent::tearDown();

    $this->assertTrue($ok, 'FlexMailer remained active during testing');
  }

  // ---- Boilerplate ----

  // The remainder of this class contains dummy stubs which make it easier to
  // work with the tests in an IDE.

  /**
   * @dataProvider concurrencyExamples
   * @see          _testConcurrencyCommon
   */
  public function testConcurrency($settings, $expectedTallies, $expectedTotal) {
    parent::testConcurrency($settings, $expectedTallies, $expectedTotal);
  }

  public function testBasic() {
    parent::testBasic();
  }

}
