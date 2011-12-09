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
        $view->headLink()->appendStylesheet('/css/960gs/reset.css')
            ->appendStylesheet('/css/960gs/text.css')
            ->appendStylesheet('/css/960gs/960.css')
            ->appendStylesheet('/css/site.css');

        $this->bootstrap('Navigation');
        $navigationContainer = $this->getResource('Navigation');
        $view->navigation($navigationContainer);

        $view->addHelperPath(APPLICATION_PATH . '/views/helpers', 'Jeera_View_Helper');
        
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);

        return $view;
    }

    protected function _initNavigation()
    {
        $container = new Zend_Navigation(array(
                array(
                    'label' => 'Home',
                    'module' => 'default',
                    'controller' => 'tickets',
                    'action' => 'index',
                    'reset_params' => true
                ),
                array(
                    'label' => 'Submit Ticket',
                    'module' => 'default',
                    'controller' => 'tickets',
                    'action' => 'submit',
                    'reset_params' => true
                ),
                array(
                    'label' => 'Search',
                    'module' => 'default',
                    'controller' => 'tickets',
                    'action' => 'search',
                    'reset_params' => true
                )
            ));

        return $container;
    }

    public function _initTranslator()
    {
        $translator = new Zend_Translate(array(
                'adapter' => 'array',
                'content' => realpath(APPLICATION_PATH . '/../library/form-translations.php')
                )
        );
        
        return $translator;
    }

}

