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

interface ICheckManager {

	/**
	 * @param \Closure $check a closure that creates the check of type ICheck
	 *                        otherwise \InvalidArgumentException is thrown later
	 */
	public function addCheck(\Closure $check);

	/**
	 * @return ICheck[] an array of all registered checks
	 */
	public function getChecks();

}
