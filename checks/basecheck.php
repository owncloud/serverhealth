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

namespace OCA\ServerHealth\Checks;

use OCA\ServerHealth\Db\Check;
use OCA\ServerHealth\Db\CheckMapper;

abstract class BaseCheck implements ICheck {

	/** @var Check */
	protected $checkEntity;
	/** @var State */
	protected $state;
	/** @var string */
	protected $name = '';
	/** @var string */
	protected $description = '';

	public function __construct(CheckMapper $checkMapper) {
		$this->checkMapper = $checkMapper;
		$this->state = new State('', false, true);
	}

	/**
	 * Creates an entity object to store in the database
	 *
	 * @return Check DB entity
	 */
	public function getEntity() {
		return $this->checkEntity;
	}

	/**
	 * Sets all info from an entity object
	 *
	 * @param Check $checkEntity DB entity
	 */
	public function setEntity($checkEntity) {
		$this->checkEntity = $checkEntity;
	}

	/**
	 * Save the entity to the DB
	 */
	protected function saveEntity() {
		$this->checkMapper->update($this->checkEntity);
	}

	public function runStep() {
		$this->checkEntity->setLastRun(new \DateTime());
		$this->saveEntity();
	}

	public function getState() {
		return $this->state;
	}

	/**
	 * @return string name of the check
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return string description of the check
	 */
	public function getDescription(){
		return $this->description;
	}
}
