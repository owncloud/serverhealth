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

use OCA\ServerHealth\Checks\BaseCheck;
use OCA\ServerHealth\Checks\CheckManager;
use OCA\ServerHealth\Db\CheckMapper;
use OCP\AppFramework\Http\DataResponse;
use PHPUnit_Framework_TestCase;

class TestCheck extends BaseCheck {
	public function runStep() {}
	public function isActive() {
		return true;
	}
	public function __construct(CheckMapper $checkMapper, $name, $description) {
		parent::__construct($checkMapper);

		$this->name = $name;
		$this->description = $description;
	}
}

class SettingsControllerTest extends PHPUnit_Framework_TestCase {

	/** @var SettingsController */
	private $controller;
	/** @var CheckManager */
	protected $checkManager;

	public function setUp() {
		$request = $this->getMockBuilder('OCP\IRequest')
			->disableOriginalConstructor()->getMock();
		$this->checkManager = $this->getMockBuilder('OCA\ServerHealth\Checks\CheckManager')
			->disableOriginalConstructor()->getMock();

		$this->controller = new SettingsController(
			'serverhealth', $request, $this->checkManager
		);
	}


	public function testChecks() {
		$checkName = 'MyCheck';
		$checkDescription = 'This is my check';
		$check = new TestCheck($this->getMockBuilder('OCA\ServerHealth\Db\CheckMapper')
			->disableOriginalConstructor()->getMock(), $checkName, $checkDescription);

		$this->checkManager->expects($this->once())
			->method('getChecks')
			->will($this->returnValue([$check]));

		/** @var DataResponse $result */
		$result = $this->controller->checks();

		$this->assertTrue($result instanceof DataResponse);
		$this->assertEquals([
			[
				'name' => $checkName,
				'description' => $checkDescription,
				'state' => [
					'hasNextStep' => true,
					'stateText' => '',
					'statePercentage' => false,
				],
				'lastRun' => '2015-10-09 15:34:12'
			]
		], $result->getData(), '', 0.0, 10, true);
	}

}