<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    
    protected function _initAcl()
    {
        return new Jeera_Acl_Acl(Zend_Auth::getInstance());
    }

    protected function _initPlugins()
    {
        $this->bootstrap('FrontController');
        $front = $this->getResource('FrontController');
        $acl = $this->getResource('Acl');

        $auth = Zend_Auth::getInstance();

        $front->setParam('auth', $auth);
        $front->setParam('acl', $acl);
        $front->registerPlugin(new Jeera_Controller_Plugin_Auth($auth, $acl));

        return $front;
    }


}

