<?php
/**
 * Description of AclTest
 *
 * @category
 * @package
 * @subpackage
 * @version     $Id$
 */

/**
 * @category
 * @package
 * @subpackage
 */
class AclTest extends ControllerTestCase
{
    /**
     * @var Jeera_Acl_Acl
     */
    private $_acl;

    public function setUp()
    {
        parent::setUp();
        $this->_acl = new Jeera_Acl_Acl();
    }

    protected function tearDown()
    {
        $this->_acl = null;
        parent::tearDown();
    }

    public function testGuestPermissions()
    {
        $this->assertTrue($this->_acl->isAllowed('guest', 'auth', 'login'));
        $this->assertTrue($this->_acl->isAllowed('guest', 'auth', 'index'));
        $this->assertFalse($this->_acl->isAllowed('guest', 'auth', 'logout'));
        $this->assertFalse($this->_acl->isAllowed('guest', 'tickets'));
        $this->assertTrue($this->_acl->isAllowed('guest', 'error'));
        $this->assertTrue($this->_acl->isAllowed('guest', 'index'));
    }
    
    public function testUserPermissions()
    {
        $this->assertTrue($this->_acl->isAllowed('user', 'auth', 'index'));
        $this->assertTrue($this->_acl->isAllowed('user', 'auth', 'logout'));
        $this->assertFalse($this->_acl->isAllowed('user', 'auth', 'login'));
        $this->assertTrue($this->_acl->isAllowed('user', 'tickets', 'index'));
        $this->assertTrue($this->_acl->isAllowed('user', 'tickets', 'search'));
        $this->assertTrue($this->_acl->isAllowed('user', 'tickets', 'submit'));
        $this->assertTrue($this->_acl->isAllowed('user', 'tickets', 'view'));
        $this->assertFalse($this->_acl->isAllowed('user', 'tickets', 'modify'));
        $this->assertTrue($this->_acl->isAllowed('user', 'error'));
        $this->assertTrue($this->_acl->isAllowed('user', 'index'));
    }
    
    public function testAdminPermissions()
    {
        $this->assertTrue($this->_acl->isAllowed('admin', 'auth', 'index'));
        $this->assertTrue($this->_acl->isAllowed('admin', 'auth', 'logout'));
        $this->assertFalse($this->_acl->isAllowed('admin', 'auth', 'login'));
        $this->assertTrue($this->_acl->isAllowed('admin', 'tickets'));
        $this->assertTrue($this->_acl->isAllowed('admin', 'error'));
        $this->assertTrue($this->_acl->isAllowed('admin', 'index'));
    }

}

