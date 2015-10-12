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

namespace OCA\Health\Controller;

use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;
use OCP\AppFramework\Controller;

class SettingsController extends Controller {


	public function __construct($AppName, IRequest $request){
		parent::__construct($AppName, $request);
	}

	/**
	 * Simple method that provides the admin settings HTML
	 */
	public function displayAdmin() {
		return new TemplateResponse('health', 'adminSettings', [], '');
	}

	/**
	 * @NoCSRFRequired
	 */
	public function checks() {

		$checks = [];

		$checks[] = [
			'name' => 'LDAP check',
			'description' => 'Lorem ipsum dolor atem',
			'status' => 1,
			'lastRun' => '2015-10-09 15:34:12'
		];

		$checks[] = [
			'name' => 'Filesystem check',
			'description' => 'Lorem ipsum dolor atem',
			'status' => 3,
			'lastRun' => '2015-10-11 15:34:12'
		];

		return new DataResponse($checks);
	}


}
