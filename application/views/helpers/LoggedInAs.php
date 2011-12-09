<?php
/**
 * Jeera Trouble Ticket System
 *
 * @category    Jeera
 * @package     Jeera_View
 * @subpackage  Helper
 */

/**
 * View helper to provide welcome message and logout link
 *
 * @category    Jeera
 * @package     Jeera_View
 * @subpackage  Helper
 */
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
                    ),
                null,
                true
            );
            $links = '<p id="logout">Howdy %s! | <a href="%s">Logout</a></p>';
            return sprintf($links, $userName, $logoutUrl);
        }

        $request = Zend_Controller_Front::getInstance()->getRequest();
        $controller = $request->getControllerName();
        $action = $request->getActionName();

        if ($controller == 'auth') {
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