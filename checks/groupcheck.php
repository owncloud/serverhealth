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

use OCP\IL10N;

class GroupCheck implements ICheck {

	/** @var IL10N */
	protected $l;

	public function __construct(IL10N $l10n) {
		$this->l = $l10n;
	}

	/**
	 * @return string name of the check
	 */
	public function getName() {
		return $this->l->t('Group check');
	}

	/**
	 * @return string description of the check
	 */
	public function getDescription(){
		return $this->l->t('This checks for problems within the group memberships and group admins.');
	}

	/**
	 * Runs a single step to process the check
	 */
	public function runStep() {
		// TODO
	}

	/**
	 * Determines the active state of this check
	 *
	 * @return true|string true if active else a string with the cause why it is not active
	 */
	public function isActive() {
		return true;
	}
}
