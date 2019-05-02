<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\Match;

use BallGame\Domain\Match\Match;
use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;

class MatchTest extends TestCase
{
    /**
     * @expectedException \BallGame\Domain\Exception\MatchBetweenSameTeamException
     */
    public function testCreatingMatchBetweenSameTeamsIsNotAllowed()
    {
        Match::create(
            Team::create('Same team'),
            Team::create('Same team'),
            1,
            2
        );
    }
}
