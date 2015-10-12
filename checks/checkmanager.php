<?php
/**
 * Created by PhpStorm.
 * User: mjob
 * Date: 12.10.15
 * Time: 16:20
 */

namespace OCA\Health\Checks;


class CheckManager implements ICheckManager {

	protected $checkClosures = [];
	protected $checks = [];

	/**
	 * @param \Closure $check a closure that creates the check of type ICheck
	 *                        otherwise \InvalidArgumentException is thrown later
	 */
	public function addCheck(\Closure $check) {
		$this->checkClosures[] = $check;
	}

	/**
	 * @return ICheck[] an array of all registered checks
	 */
	public function getChecks() {
		if (!empty($this->checks)) {
			return $this->checks;
		}

		foreach ($this->checkClosures as $closure) {
			$check = $closure();
			if (!($check instanceof ICheck)) {
				throw new \InvalidArgumentException('The given check does not implement the ICheck interface');
			}
			$this->checks[] = $check;
		}

		return $this->checks;
	}
}
