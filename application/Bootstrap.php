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

    protected function _initView()
    {
        $view = new Zend_View();
        $view->setEncoding('UTF-8');
        $view->doctype('XHTML1_TRANSITIONAL');
        $view->headTitle('Jeera');
        $view->headTitle()->setSeparator(' - ');
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8')
            ->appendHttpEquiv('Content-Language', 'en-US');
        $view->addHelperPath(APPLICATION_PATH . '/views/helpers', 'Jeera_View_Helper');
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);

        return $view;
    }

}

