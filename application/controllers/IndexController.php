<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {

        $salt = "";
        for ($i = 0; $i < 22; $i++) {
            $salt .= substr("./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789", mt_rand(0, 63), 1);
        }

        var_dump(strlen(sha1('blah')));

        die();
    }

}

