<?php

/**
 * Jeera Application Library
 *
 * @category   Jeera
 * @package    Jeera_Controller
 * @subpackage Plugin
 */

/**
 * @category   Jeera
 * @package    Jeera_Controller
 * @subpackage Plugin
 */
class Jeera_Controller_Plugin_Auth extends Zend_Controller_Plugin_Abstract
{

    /**
     * @var Zend_Auth
     */
    private $_auth;
    /**
     * @var Zend_Acl
     */
    private $_acl;
    /**
     * Where an unauthenticated user will be redirected
     *
     * @var array
     */
    private $_noauth = array('controller' => 'auth', 'action' => 'login');
    /**
     * Where an unauthorized user will be redirected
     *
     * @var array
     */
    private $_noacl = array('controller' => 'error', 'action' => 'error');

    public function __construct(Zend_Auth $auth, Zend_Acl $acl)
    {
        $this->_auth = $auth;
        $this->_acl = $acl;
    }

    /**
     * Compares logged in user's role to ACL and redirects user to login 
     * (or no privileges page) based on role's permissions in the ACL
     *
     * @param Zend_Controller_Request_Abstract $request
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $frontController = Zend_Controller_Front::getInstance();

        $controller = $request->getControllerName();
        $action = $request->getActionName();
        $resource = $controller;

        if ($this->_auth->hasIdentity()) {
            $identity = $this->_auth->getIdentity();
            if (is_array($identity)) {
                $role = $identity['role'];
            } else if (is_object($identity)) {
                $role = $identity->role;
            } else {
                // If $identity isn't an array and isn't an object, something isn't right.
                // Set role to guest and move on.
                $role = 'guest';
            }
        } else {
            $role = 'guest';
        }

        if (!$this->_acl->has($resource)) {
            $resource = null;
        }

        $isDispatchable = $frontController->getDispatcher()->isDispatchable($request);

        if ($isDispatchable && !$this->_acl->isAllowed($role, $resource, $action)) {
            if (!$this->_auth->hasIdentity()) {
                // Not logged in, send to login page
                $controller = $this->_noauth['controller'];
                $action = $this->_noauth['action'];
                $redirectNS = new Zend_Session_Namespace(
                        'redirect');
                $redirectNS->fromUrl = $_SERVER['REQUEST_URI'];
            } else {
                // Permission to access resource denied.  Send to error page.
                $controller = $this->_noacl['controller'];
                $action = $this->_noacl['action'];
            }
        }

        $request->setControllerName($controller);
        $request->setActionName($action);
    }

}