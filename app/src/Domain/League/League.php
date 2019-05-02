<?php
declare(strict_types=1);


namespace BallGame\Domain\League;


use BallGame\Domain\Match\Match;
use BallGame\Domain\Team\Position;

class League
{
    /**
     * @var Position[]
     */
    protected $positions;

    /**
     * @var Match[]
     */
    private $matches;

    public function record(\BallGame\Domain\Match\Match $match)
    {
        $this->matches[] = $match;
    }

    public function getSortedStandings()
    {
        foreach ($this->matches as $match) {
            if (!isset($this->positions[sha1($match->getHomeTeam()->getName())])) {
                $this->positions[sha1($match->getHomeTeam()->getName())] = new Position($match->getHomeTeam());
            }
            $homeTeamPosition = $this->positions[sha1($match->getHomeTeam()->getName())];

            if (!isset($this->positions[sha1($match->getAwayTeam()->getName())])) {
                $this->positions[sha1($match->getAwayTeam()->getName())] = new Position($match->getAwayTeam());
            }
            $awayTeamPosition = $this->positions[sha1($match->getAwayTeam()->getName())];

            // home team won
            if ($match->getHomeTeamRuns() > $match->getAwayTeamRuns()) {
                $homeTeamPosition->recordWin();
                $awayTeamPosition->recordLoss();
            }

            // away team won
            if ($match->getAwayTeamRuns() > $match->getHomeTeamRuns()) {
                $awayTeamPosition->recordWin();
                $homeTeamPosition->recordLoss();
            }
        }

        uasort($this->positions, function (Position $teamA, Position $teamB) {
            if ($teamA->getPercentage() > $teamB->getPercentage()) {
                return -1;
            }

            if ($teamB->getPercentage() > $teamA->getPercentage()) {
                return 1;
            }

            if ($teamA->getPercentage() === $teamB->getPercentage()) {
                return 0;
            }
        });

        $standings = [];
        foreach ($this->positions as $position) {
            $standings[] = [
                $position->getTeam()->getName(),
                $position->getPercentage(),
                $position->getWins(),
                $position->getLoses(),
            ];
        }

        return $standings;
    }
}
