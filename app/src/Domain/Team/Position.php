<?php
declare(strict_types=1);


namespace BallGame\Domain\Team;


class Position
{
    /**
     * @var Team
     */
    private $team;

    /**
     * @var int
     */
    private $wins = 0;

    /**
     * @var int
     */
    private $loses = 0;

    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    public function recordWin()
    {
        $this->wins += 1;
    }

    public function recordLoss()
    {
        $this->loses += 1;
    }

    /**
     * @return int
     */
    public function getWins(): int
    {
        return $this->wins;
    }

    /**
     * @return int
     */
    public function getLoses(): int
    {
        return $this->loses;
    }

    public function getPercentage()
    {
        if (0 === $this->wins) {
            return 0.0;
        }

        return (float)($this->wins / ($this->wins + $this->loses));
    }

    public function getTeam()
    {
        return $this->team;
    }
}
