<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\Team;

use BallGame\Domain\Team\Position;
use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;

class PositionTest extends TestCase
{
    /**
     * @var Position
     */
    protected $position;

    public function setUp()
    {
        $this->position = new Position(
            Team::create('My team')
        );
    }

    public function testPositionWhenNoGamesWerePlayed()
    {
        $this->assertSame('0.000', $this->position->getPercentage());
        $this->assertSame(0, $this->position->getWins());
        $this->assertSame(0, $this->position->getLoses());
    }

    public function testPositionWhenTeamLostOneGame()
    {
        $this->position->recordLoss();

        $this->assertSame('0.000', $this->position->getPercentage());
        $this->assertSame(0, $this->position->getWins());
        $this->assertSame(1, $this->position->getLoses());
    }

    public function testPositionWhenTeamWinsOneGame()
    {
        $this->position->recordWin();

        $this->assertSame('1.000', $this->position->getPercentage());
        $this->assertSame(1, $this->position->getWins());
        $this->assertSame(0, $this->position->getLoses());
    }

    public function testPositionWhenTeamWinsOneGameAndLosesAnother()
    {
        $this->position->recordWin();
        $this->position->recordLoss();

        $this->assertSame('0.500', $this->position->getPercentage());
        $this->assertSame(1, $this->position->getWins());
        $this->assertSame(1, $this->position->getLoses());
    }
}
