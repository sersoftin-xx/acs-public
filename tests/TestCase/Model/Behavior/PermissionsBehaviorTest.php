<?php
namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\PermissionsBehavior;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\PermissionsBehavior Test Case
 */
class PermissionsBehaviorTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Behavior\PermissionsBehavior
     */
    public $Permissions;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Permissions = new PermissionsBehavior();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Permissions);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
