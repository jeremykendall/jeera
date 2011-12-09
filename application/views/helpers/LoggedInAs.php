<?php

class Jeera_View_Helper_LoggedInAs extends Zend_View_Helper_Abstract
{

    public function loggedInAs()
    {
        $auth = Zend_Auth::getInstance();

        if ($auth->hasIdentity()) {

            $identity = $auth->getIdentity();

            $userName = $identity['firstName'] . ' ' . $identity['lastName'];

            $logoutUrl = $this->view->url(
                    array(
                        'module' => 'default',
                        'controller' => 'auth',
                        'action' => 'logout'
                    )
            );
            $links = '<p id="logout">Howdy %s! | <a href="%s">Logout</a></p>';
            return sprintf($links, $userName, $logoutUrl);
        }

        $request = Zend_Controller_Front::getInstance()->getRequest();
        $controller = $request->getControllerName();
        $action = $request->getActionName();

        if ($controller == 'auth' && ($action == 'index' || $action == 'register')) {
            return '';
        }

        $loginUrl = $this->view->url(
                    array(
                        'module' => 'default',
                        'controller' => 'auth',
                        'action' => 'login'
                    )
            );

        $links = '<p id="slgnIn"><a href="%s">Login</a>';
        return sprintf($links, $loginUrl);
    }

}