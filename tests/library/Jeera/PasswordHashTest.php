<?php

require_once realpath(dirname(__FILE__) . '/../../../library/Jeera/PasswordHash.php');

/**
 * Description of PasswordHashTest
 *
 * @author jeremykendall
 */
class PasswordHashTest extends PHPUnit_Framework_TestCase
{

    /**
     * Strong (default) hasher
     * 
     * @var Jeera_PasswordHash
     */
    private $_hasher;

    /**
     * Portable hasher
     *
     * @var Jeera_PasswordHash
     */
    private $_portableHasher;
    /**
     * Correct password
     *
     * @var string
     */
    private $_correct = 'test12345';

    /**
     * Wrong password
     *
     * @var string
     */
    private $_wrong = 'test12346';

    private $_portableCorrectHash = '$P$9IQRaTwmfeRo7ud9Fh4E2PdI0S3r.L0';

    public function setUp()
    {
        parent::setUp();
        $this->_hasher = new Jeera_PasswordHash(8, false);
        $this->_portableHasher = new Jeera_PasswordHash(8, true);
    }

    public function tearDown()
    {
        $this->_hasher = null;
        $this->_portableHasher = null;
        parent::tearDown();
    }

    public function testcheckPasswordSucceeds()
    {
        $hash = $this->_hasher->hashPassword($this->_correct);
        $this->assertTrue($this->_hasher->checkPassword($this->_correct, $hash));
    }

    public function testcheckPasswordFails()
    {
        $hash = $this->_hasher->hashPassword($this->_correct);
        $this->assertFalse($this->_hasher->checkPassword($this->_wrong, $hash));
    }

    public function testFallbackcheckPasswordSucceeds()
    {
        $hash = $this->_portableHasher->hashPassword($this->_correct);
        $this->assertTrue($this->_portableHasher->checkPassword($this->_correct, $hash));
    }

    public function testFallbackcheckPasswordFails()
    {
        $hash = $this->_portableHasher->hashPassword($this->_correct);
        $this->assertFalse($this->_portableHasher->checkPassword($this->_wrong, $hash));
    }

    public function testcheckPasswordPortableCorrectHashSucceeds()
    {
        $this->assertTrue($this->_portableHasher->checkPassword($this->_correct, $this->_portableCorrectHash));
    }

    public function testcheckPasswordPortableCorrectHashFails()
    {
        $this->assertFalse($this->_portableHasher->checkPassword($this->_wrong, $this->_portableCorrectHash));
    }

}
