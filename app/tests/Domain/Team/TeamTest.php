<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\Team;

use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;

class TeamTest extends TestCase
{
    /**
     * @expectedException \BallGame\Domain\Exception\TeamWithEmptyNameException
     */
    public function testCreatingTeamWithNoNameThrowsAnException()
    {
        Team::create('');
    }
}
