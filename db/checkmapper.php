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

use OCP\AppFramework\Db\Mapper;
use OCP\IDb;

class CheckMapper extends Mapper {

	public function __construct(IDb $db){
		parent::__construct($db, 'serverhealth_checks', '\OCA\ServerHealth\Db\Check');
	}

	/**
	 * returns all checks
	 *
	 * @return Check[]
	 */
	public function findAll(){
		$sql = 'SELECT * FROM `' . $this->getTableName() .  '`';
		return $this->findEntities($sql);
	}


	/**
	 * Returns a specific check
	 *
	 * @param integer $id the id of the check to return
	 * @return Check
	 */
	public function find($id) {
		$sql = 'SELECT * FROM `' . $this->getTableName() .  '` '.
			'WHERE `id`= ?';
		return $this->findEntity($sql, [$id]);
	}
}
