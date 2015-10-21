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

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use OCA\ServerHealth\Db\Check;
use OCA\ServerHealth\Db\CheckMapper;
use OCP\AppFramework\IAppContainer;

class CheckManager {

	/** @var  ICheck[] */
	protected $checks = [];
	/** @var CheckMapper */
	protected $checkMapper;
	/** @var IAppContainer */
	protected $container;

	public function __construct(CheckMapper $checkMapper, IAppContainer $container) {
		$this->checkMapper = $checkMapper;
		$this->container = $container;
	}

	/**
	 * @param string $class Name of the class to load
	 * @throws \InvalidArgumentException if the specified class doesn't implement the ICheck interface
	 */
	public function addCheck($class) {
		$check = new Check();
		$check->setClass($class);

		$checkObject = $this->createCheckObjectFromEntity($check);
		if (!($checkObject instanceof ICheck)) {
			throw new \InvalidArgumentException('The given check does not implement the ICheck interface');
		}

		try {
			$this->checkMapper->insert($check);
		} catch(UniqueConstraintViolationException $e) {
			// thread already existing checks that are use the same check class as okay
		}
	}

	/**
	 * @return ICheck[] an array of all registered checks
	 */
	public function getChecks() {
		if (!empty($this->checks)) {
			return $this->checks;
		}

		$checks = $this->checkMapper->findAll();

		foreach ($checks as $check) {
			$this->checks[] = $this->createCheckObjectFromEntity($check);
		}

		return $this->checks;
	}

	/**
	 * @param Check $check
	 * @return ICheck
	 */
	protected function createCheckObjectFromEntity(Check $check) {
		$checkObject = $this->container->query($check->getClass());
		$checkObject->setEntity($check);

		return $checkObject;
	}

	/**
	 * @param integer $checkId
	 * @return ICheck
	 */
	public function getCheck($checkId) {
		$check = $this->checkMapper->find($checkId);
		return $this->createCheckObjectFromEntity($check);
	}
}
