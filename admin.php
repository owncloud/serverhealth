<?php

/**
 * ownCloud
 *
 * @author Morris Jobke
 * @copyright 2015 Morris Jobke <hey@morrisjobke.de>
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later.
 * See the COPYING-README file.
 */

$app = new \OCP\AppFramework\App('serverhealth');
/** @var OCA\ServerHealth\Controller\SettingsController $controller */
$controller = $app->getContainer()->query('OCA\ServerHealth\Controller\SettingsController');
return $controller->displayAdmin()->render();
