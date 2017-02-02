<?php


namespace ITS\Tests\BBS;

use ITS\BBS\BBS;

class BBSTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BBS
     */
	protected $bbs;

	protected function setUp()
	{
		$this->bbs = new BBS('10');
	}

	private function provider()
	{
		return [
			'10',
			'1000',
			'4711',
			'25454325',
			'235324534543',
			'3534346454764568',
			'9650608768068965975976598',
			'1045065947568056805087680568056665',
			'346303950348394894385958928534593852985298529',
			'436045695945694506456459643843593469457065796945843823'
		];
	}

	public function testRandomBBS()
	{
		foreach ($this->provider() as $n) {
			$this->bbs->setStart($n);

			echo "\n\nStartNum: $n \n";
			print_r($this->bbs->randomBBS());
		}
	}
}