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
use OCP\ILogger;

class GroupCheck extends BaseCheck {

	/** @var IL10N */
	protected $l;
	/** @var IDBConnection */
	protected $db;
	/** @var ILogger */
	protected $logger;

	protected $offset = 0;
	protected $foundEntries = 0;

	public function __construct(IL10N $l10n, IDBConnection $db, CheckMapper $checkMapper, ILogger $logger) {
		parent::__construct($checkMapper);
		$this->l = $l10n;
		$this->db = $db;
		$this->logger = $logger;

		$this->name = $this->l->t('Group check');
		$this->description = $this->l->t('This checks for problems within the group memberships and group admins.');
	}

	public function setEntity($checkEntity) {
		parent::setEntity($checkEntity);

		$oldState = $checkEntity->getState();
		if (is_string($oldState) && strlen($oldState)) {
			$oldState = json_decode($oldState);
			$this->state->setStateAsPercentage($oldState->percentage);
			$this->state->setStateAsText($oldState->text);

			$this->offset = intval($oldState->offset);
			$this->foundEntries = intval($oldState->foundEntries);
		}
	}

	public function saveEntity() {
		$this->checkEntity->setState(json_encode([
			'percentage' => $this->state->getStateAsPercentage(),
			'text' => $this->state->getStateAsText(),
			'offset' => $this->offset,
			'foundEntries' => $this->foundEntries,
		]));
		parent::saveEntity();
	}

	/**
	 * Runs a single step to process the check
	 */
	public function runStep() {
		parent::runStep();

		$sql = 'SELECT u.* FROM (SELECT * FROM `*PREFIX*group_user` LIMIT 100 OFFSET ' . $this->offset . ') u LEFT OUTER JOIN `*PREFIX*groups` g ON u.`gid` = g.`gid` WHERE g.`gid` IS NULL;';
		$stmt = $this->db->executeQuery($sql);

		$this->offset += 100;

		$brokenGroupMemberships = [];
		while ($row = $stmt->fetch()) {
			$brokenGroupMemberships[] = $row;
		}

		$this->foundEntries += count($brokenGroupMemberships);

		if (count($brokenGroupMemberships)) {
			$this->logger->info('brokenGroupMemberships: ' . json_encode($brokenGroupMemberships), ['app' => 'serverhealth']);
		}

		$sql = 'SELECT COUNT(*) FROM `*PREFIX*group_user`;';
		$stmt = $this->db->executeQuery($sql);
		$userGroups = $stmt->fetchAll(\PDO::FETCH_COLUMN);

		$userGroupsCount = $userGroups[0];

		$newStatePercentage = false;
		if ($userGroupsCount > 0) {
			$newStatePercentage = min(1, round(($this->offset + 100)/$userGroupsCount, 2));
		}

		$this->state->setStateAsPercentage($newStatePercentage);
		if ($newStatePercentage >= 1) {
			$stateText = $this->foundEntries . ' broken entries found.';
		} else {
			$stateText = $this->foundEntries . ' broken entries already found.';
		}
		$this->state->setStateAsText($stateText);

		// update database
		$this->saveEntity();
	}

	/**
	 * Determines the active state of this check
	 *
	 * @return true|string true if active else a string with the cause why it is not active
	 */
	public function isActive() {
		return true;
	}

	public function reset() {
		$this->offset = 0;
		$this->foundEntries = 0;
		parent::reset();
	}
}
