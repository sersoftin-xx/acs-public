<?php
namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\ArrayStoreBehavior;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\ArrayStoreBehavior Test Case
 */
class ArrayStoreBehaviorTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Behavior\ArrayStoreBehavior
     */
    public $ArrayStore;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->ArrayStore = new ArrayStoreBehavior();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ArrayStore);

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
