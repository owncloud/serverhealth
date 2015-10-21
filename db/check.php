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
 */
class Check extends Entity {

	public $class;
	public $lastRun;

	/**
	 * @return \Datetime
	 */
	public function getLastRun() {
		// TODO new Date().toJSON()
		// "2015-10-19T12:14:16.622Z"
		return \DateTime::createFromFormat(\DateTime::ISO8601, $this->lastRun);
	}

	/**
	 * @param \DateTime $lastRun
	 */
	public function setLastRun($lastRun) {
		if($lastRun instanceof \DateTime) {
			$lastRun = $lastRun->format(\DateTime::ISO8601);
		}
		$this->setter('lastRun', [$lastRun]);
	}
}
