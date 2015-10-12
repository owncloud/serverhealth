<?php
/**
 * ownCloud - health
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Morris Jobke <hey@morrisjobke.de>
 * @copyright Morris Jobke 2015
 */

namespace OCA\Health\AppInfo;

use OCA\Health\Checks\ICheckManager;

\OCP\App::registerAdmin('health', 'admin');

$app = new \OCP\AppFramework\App('health');
/** @var ICheckManager $checkmanager */
$checkmanager = $app->getContainer()->query('OCA\Health\Checks\CheckManager');
