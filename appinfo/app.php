<?php
/**
 * ownCloud - ServerHealth
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Morris Jobke <hey@morrisjobke.de>
 * @copyright Copyright (c) 2015, ownCloud, Inc.
 */

namespace OCA\ServerHealth\AppInfo;

use OCA\ServerHealth\Checks\CheckManager;

\OCP\App::registerAdmin('serverhealth', 'admin');

$app = new \OCP\AppFramework\App('serverhealth');
$container = $app->getContainer();

/** @var CheckManager $checkManager */
$checkManager = $container->query('OCA\ServerHealth\Checks\CheckManager');
$checkManager->addCheck('OCA\ServerHealth\Checks\GroupCheck');
