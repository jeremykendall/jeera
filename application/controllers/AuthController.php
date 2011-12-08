<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AuthController
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
class AuthController extends Zend_Controller_Action
{
    /**
     * @var Zend_Db_Adapter_Abstract
     */
    private $_db;
    
    public function init()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        $this->_db = $bootstrap->getResource('db');
    }
    
    public function indexAction()
    {
        
    }
    
    public function loginAction()
    {
        
        $form = new Jeera_Form_Login();
        $this->view->form = $form;

        $request = $this->getRequest();

        if (!$request->isPost() || !$form->isValid($request->getPost())) {
            return;
        }
        
        $username = $form->getElement('username')->getValue();
        $password = $form->getElement('password')->getValue();
        
        $hasher = new Jeera_PasswordHash();
        $users = new Jeera_Model_DbTable_Users();
        $user = $users->findByUsername($username);
        
        if ($user && $hasher->checkPassword($password, $user['passwordHash'])) {
            $user = $user->toArray();
            unset($user['passwordHash']);
            Zend_Auth::getInstance()->getStorage()->write($user);
        } else {
            $this->view->loginErrorMessage = 'Login failed.  Please try again.';
            return;
        }
        
        return $this->_helper->redirector('index', 'index');
        
    }
    
    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        return $this->_helper->redirector('index', 'index');
    }
}
