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

interface IState {

	/**
	 * @return boolean indicates if there are steps to run left
	 */
	public function hasNextStep();

	/**
	 * @return string state in localized text format
	 */
	public function getStateAsText();

	/**
	 * @return float|false state in a number between 0 and 1 or false if not
	 * determinable
	 */
	public function getStateAsPercentage();

	/**
	 * Returns hasNextStep, stateText and statePercentage as array
	 *
	 * @return array
	 */
	public function getArrayRepresentation();

}
