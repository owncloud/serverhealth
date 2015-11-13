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

	/**
	 * @param string $stateText
	 * @param float|false $statePercentage
	 */
	public function __construct($stateText, $statePercentage) {
		$this->stateText = $stateText;
		$this->statePercentage = $statePercentage;
	}

	/**
	 * @return boolean indicates if there are steps to run left
	 */
	public function hasNextStep() {
		return $this->statePercentage < 1;
	}

	/**
	 * @return string state as a text in localized format
	 */
	public function getStateAsText() {
		return $this->stateText;
	}

	/**
	 * @param string $text state as a text in localized format
	 */
	public function setStateAsText($text) {
		$this->stateText = $text;
	}

	/**
	 * @return float|false state as a number between 0 and 1 or false if not
	 * determinable
	 */
	public function getStateAsPercentage() {
		return $this->statePercentage > 1 ? 1 : $this->statePercentage;
	}

	/**
	 * @param string $percentage state as a number between 0 and 1 or false if not
	 * determinable
	 */
	public function setStateAsPercentage($percentage) {
		$this->statePercentage = $percentage;
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
