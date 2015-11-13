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

namespace OCA\ServerHealth\Controller;

use OCA\ServerHealth\Checks\CheckManager;
use OCA\ServerHealth\Checks\ICheck;
use OCA\ServerHealth\Checks\IState;
use OCA\ServerHealth\Checks\IStepResult;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http\Response;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;
use OCP\AppFramework\Controller;

class SettingsController extends Controller {

	/** @var CheckManager */
	protected $checkManager;

	public function __construct($AppName, IRequest $request, CheckManager $checkManager){
		parent::__construct($AppName, $request);

		$this->checkManager = $checkManager;
	}

	/**
	 * Simple method that provides the admin settings HTML
	 *
	 * @return Response
	 */
	public function displayAdmin() {
		return new TemplateResponse('serverhealth', 'adminSettings', [], '');
	}

	/**
	 * @NoCSRFRequired
	 *
	 * @return Response
	 */
	public function checks() {
		$checks = $this->checkManager->getChecks();

		$mapping = array_map(function(ICheck $check) {
			return [
				'id' => $check->getId(),
				'name' => $check->getName(),
				'description' => $check->getDescription(),
				'state' => $check->getState()->getArrayRepresentation(),
				'lastRun' => $check->getLastRunDateTime()->format('Y-m-d\TH:i:s.000\Z'),
			];
		}, $checks);

		return new DataResponse($mapping);
	}

	/**
	 * Triggers on step run
	 *
	 * @NoCSRFRequired
	 *
	 * @param integer $checkId the id of the check to perform the next steps with
	 * @param bool $restart whether the run should be restarted
	 * @return Response
	 */
	public function runStep($checkId, $restart) {
		$check = $this->checkManager->getCheck($checkId);

		if ($restart) {
			$check->reset();
		}

		$check->runStep();

		return new DataResponse($check->getState()->getArrayRepresentation());
	}


}
