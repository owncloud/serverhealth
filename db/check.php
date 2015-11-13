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

namespace OCA\ServerHealth\Db;

use \OCP\AppFramework\Db\Entity;

/**
 * @method string getClass()
 * @method setClass(string $class)
 * @method string getState()
 * @method setState(string $state)
 * @method string getLastRun()
 * @method setLastRun(string $state)
 */
class Check extends Entity {

	public $class;
	public $lastRun;
	public $state;
}
