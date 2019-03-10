<?php
declare(strict_types=1);


namespace BallGame\Domain\Match;


use BallGame\Domain\Team\Team;

class Match
{
    /**
     * @var Team
     */
    private $homeTeam;

    /**
     * @var Team
     */
    private $awayTeam;

    /**
     * @var int
     */
    private $homeTeamPoints;

    /**
     * @var int
     */
    private $awayTeamPoints;

    /**
     * @return Team
     */
    public function getHomeTeam(): Team
    {
        return $this->homeTeam;
    }

    /**
     * @return Team
     */
    public function getAwayTeam(): Team
    {
        return $this->awayTeam;
    }

    /**
     * @return int
     */
    public function getHomeTeamPoints(): int
    {
        return $this->homeTeamPoints;
    }

    /**
     * @return int
     */
    public function getAwayTeamPoints(): int
    {
        return $this->awayTeamPoints;
    }

    private function __construct(Team $homeTeam, Team $awayTeam, int $homeTeamPoints, int $awayTeamPoints)
    {
        $this->homeTeam = $homeTeam;
        $this->awayTeam = $awayTeam;
        $this->homeTeamPoints = $homeTeamPoints;
        $this->awayTeamPoints = $awayTeamPoints;
    }

    public static function create(Team $homeTeam, Team $awayTeam, int $homeTeamPoints, int $awayTeamPoints)
    {
        return new self($homeTeam, $awayTeam, $homeTeamPoints, $awayTeamPoints);
    }
}
