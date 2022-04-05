<?php
/**
 * Microweber auto provision plesk plugin
 * Author: Bozhidar Slaveykov
 * @email: info@microweber.com
 * Copyright: Microweber CMS
 */

class Modules_Microweber_TaskWhiteLabelBrandingUpdate extends \pm_LongTask_Task
{
    public $runningLog = '';
	public $trackProgress = true;

	public function run()
	{
        foreach (Modules_Microweber_Domain::getDomains() as $domain) {

            if (!$domain->hasHosting()) {
                continue;
            }

            $installations = json_decode($domain->getSetting('mwAppInstallations'), true);
            if (!$installations || !is_array($installations)) {
                return;
            }

            try {
                foreach ($installations as $installation) {
                    $this->runningLog = 'Applying whitelabel settings on domain: ' . $domain->getName();
                    Modules_Microweber_WhiteLabelBranding::applyToInstallation($domain, $installation['appInstallation']);
                }
            } catch (Exception $e) {
                // Broken domain permissions
                $this->runningLog = $e->getMessage() . ' - Applying whitelabel settings on domain: ' . $domain->getName();
            }
        }
	}

    public function statusMessage()
    {
        switch ($this->getStatus()) {
            case static::STATUS_RUNNING:
                return $this->runningLog;
            case static::STATUS_DONE:
                return 'Whitelabel settings are applied on all domains.';
            case static::STATUS_ERROR:
                return 'Error when applying whitelabel settings on domains.';
            case static::STATUS_NOT_STARTED:
                return pm_Locale::lmsg('taskPingError', [
                    'id' => $this->getId()
                ]);
        }

        return '';
    }


    public function onStart()
	{
		$this->setParam('onStart', 1);
	}

	public function onDone()
	{
		$this->setParam('onDone', 1);
	}
}
