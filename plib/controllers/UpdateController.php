<?php
/**
 * Microweber auto provision plesk plugin
 * Author: Bozhidar Slaveykov
 * @email: info@microweber.com
 * Copyright: Microweber CMS
 */

class UpdateController extends Modules_Microweber_BasepluginController
{
    public function init()
    {
        parent::init();

        $this->view->tabs = [];

    }

    public function indexAction()
    {
        if (!pm_Session::getClient()->isAdmin()) {
            return $this->_redirect('index/error?type=permission');
        }

        $this->view->pageTitle = $this->_moduleName . ' - Update';
    }

}