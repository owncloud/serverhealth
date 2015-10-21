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

class State implements IState {

	/** @var string */
	protected $stateText;
	/** @var float|false */
	protected $statePercentage;
	/** @var bool */
	protected $hasNextStep;

	/**
	 * @param string $stateText
	 * @param float|false $statePercentage
	 * @param bool $hasNextStep
	 */
	public function __construct($stateText, $statePercentage, $hasNextStep = true) {
		$this->stateText = $stateText;
		$this->statePercentage = $statePercentage;
		$this->hasNextStep = $hasNextStep;
	}

	/**
	 * @return boolean indicates if there are steps to run left
	 */
	public function hasNextStep() {
		return $this->hasNextStep;
	}

	/**
	 * @return string state of the text in localized format
	 */
	public function getStateAsText() {
		return $this->stateText;
	}

	/**
	 * @return float|false state of number between 0 and 1 or false if not
	 * determinable
	 */
	public function getStateAsPercentage() {
		return $this->statePercentage;
	}

	/**
	 * Returns hasNextStep, stateText and statePercentage as array
	 *
	 * @return array
	 */
	public function getArrayRepresentation() {
		$abc = [
			'hasNext' => $this->hasNextStep(),
			'stateText' => $this->getStateAsText(),
			'statePercentage' => $this->getStateAsPercentage(),
		];
		return $abc;
	}

}
