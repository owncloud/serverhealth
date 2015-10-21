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

use OCA\ServerHealth\Db\CheckMapper;
use OCP\IDBConnection;
use OCP\IL10N;

class GroupCheck extends BaseCheck {

	/** @var IL10N */
	protected $l;
	/** @var IDBConnection */
	protected $db;

	public function __construct(IL10N $l10n, IDBConnection $db, CheckMapper $checkMapper) {
		parent::__construct($checkMapper);
		$this->l = $l10n;
		$this->db = $db;

		$this->name = $this->l->t('Group check');
		$this->description = $this->l->t('This checks for problems within the group memberships and group admins.');
	}

	/**
	 * Runs a single step to process the check
	 */
	public function runStep() {
		parent::runStep();
		$sql = 'SELECT DISTINCT `gid` FROM `*PREFIX*group_user`;';
		$stmt = $this->db->executeQuery($sql);

		$userGroups = $stmt->fetchAll(\PDO::FETCH_COLUMN);

		$this->state = new State('', 0.2);
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
