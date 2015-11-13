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
		$this->state = new State('', false);
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
		$this->setLastRunDateTime(new \DateTime());
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

	/**
	 * @return integer ID of the check
	 */
	public function getId() {
		return $this->checkEntity->getId();
	}

	public function reset() {
		$this->state = new State('', false);
		$this->checkEntity->setState('');
		$this->saveEntity();
	}

	/**
	 * @return \Datetime
	 */
	public function getLastRunDateTime() {
		return \DateTime::createFromFormat('Y-m-d\TH:i:s.000\Z', $this->checkEntity->getLastRun());
	}

	/**
	 * @param \DateTime $lastRun
	 */
	public function setLastRunDateTime($lastRun) {
		if($lastRun instanceof \DateTime) {
			$lastRun = $lastRun->format('Y-m-d\TH:i:s.000\Z');
		}
		$this->checkEntity->setLastRun($lastRun);
	}
}
