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

interface ICheck {

	/**
	 * @return string name of the check
	 */
	public function getName();

	/**
	 * @return integer ID of the check
	 */
	public function getId();

	/**
	 * @return string description of the check
	 */
	public function getDescription();

	/**
	 * Runs a single step to process the check
	 */
	public function runStep();

	/**
	 * Determines the active state of this check
	 *
	 * @return true|string true if active else a string with the cause why it is not active
	 */
	public function isActive();

	/**
	 * Creates an entity object to store in the database
	 *
	 * @return Check DB entity
	 */
	public function getEntity();

	/**
	 * Sets all info from an entity object
	 *
	 * @param Check $checkEntity DB entity
	 */
	public function setEntity($checkEntity);

	/**
	 * @return IState the state of the check
	 */
	public function getState();

	/**
	 * resets the state of this checks
	 */
	public function reset();

	/**
	 * @return \Datetime
	 */
	public function getLastRunDateTime();

	/**
	 * @param \DateTime $lastRun
	 */
	public function setLastRunDateTime($lastRun);
}
