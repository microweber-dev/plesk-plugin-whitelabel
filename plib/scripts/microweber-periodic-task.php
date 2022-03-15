<?php
/**
 * Microweber auto provision plesk plugin
 * Author: Bozhidar Slaveykov
 * @email: info@microweber.com
 * Copyright: Microweber CMS
 */

pm_Context::init('microweber');

$taskManager = new pm_LongTask_Manager();

 foreach (Modules_Microweber_Domain::getDomains() as $domain) {

    if (!$domain->hasHosting()) {
        continue;
    }

    $task = new Modules_Microweber_TaskDomainAppInstallationScan();
    $task->setParam('domainId', $domain->getId());
    $taskManager->start($task, NULL);

}

$task = new Modules_Microweber_TaskDomainAppInstallationCount();
$taskManager->start($task, NULL);
