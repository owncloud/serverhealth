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

namespace OCA\Health\Checks;

interface ICheck {

	/**
	 * @return string name of the check
	 */
	public function getName();

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
}
