<?php
declare(strict_types=1);


namespace BallGame\Domain\Match;


use BallGame\Domain\Exception\MatchBetweenSameTeamException;
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
    private $homeTeamRuns;

    /**
     * @var int
     */
    private $awayTeamRuns;

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
    public function getHomeTeamRuns(): int
    {
        return $this->homeTeamRuns;
    }

    /**
     * @return int
     */
    public function getAwayTeamRuns(): int
    {
        return $this->awayTeamRuns;
    }

    private function __construct(Team $homeTeam, Team $awayTeam, int $homeTeamRuns, int $awayTeamRuns)
    {
        $this->homeTeam = $homeTeam;
        $this->awayTeam = $awayTeam;
        $this->homeTeamRuns = $homeTeamRuns;
        $this->awayTeamRuns = $awayTeamRuns;
    }

    public static function create(Team $homeTeam, Team $awayTeam, int $homeTeamRuns, int $awayTeamRuns)
    {
        if ($homeTeam->getName() === $awayTeam->getName()) {
            throw new MatchBetweenSameTeamException();
        }

        return new self($homeTeam, $awayTeam, $homeTeamRuns, $awayTeamRuns);
    }
}
