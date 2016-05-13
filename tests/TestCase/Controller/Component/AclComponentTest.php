<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\AclComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\AclComponent Test Case
 */
class AclComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\AclComponent
     */
    public $Acl;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Acl = new AclComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Acl);

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
