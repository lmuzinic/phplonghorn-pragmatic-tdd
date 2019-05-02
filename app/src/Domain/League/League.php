<?php
declare(strict_types=1);


namespace BallGame\Domain\League;


use BallGame\Domain\Match\Match;
use BallGame\Domain\Team\Position;
use BallGame\Infrastructure\MatchRepository;

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

    /**
     * @var MatchRepository
     */
    private $matchRepository;

    public function __construct(MatchRepository $matchRepository)
    {
        $this->matchRepository = $matchRepository;
    }

    public function record(\BallGame\Domain\Match\Match $match)
    {
        $this->matchRepository->save($match);
    }

    public function getSortedStandings()
    {
        foreach ($this->matchRepository->findAll() as $match) {
            $homeTeamPosition = $this->getHomeTeamPosition($match);
            $awayTeamPosition = $this->getAwayTeamPosition($match);

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
                $this->format($position->getPercentage()),
                $position->getWins(),
                $position->getLoses(),
            ];
        }

        return $standings;
    }

    private function format($percentage)
    {
        return number_format($percentage, 3);
    }

    /**
     * @param Match $match
     * @return Position
     */
    private function getHomeTeamPosition(Match $match): Position
    {
        if (!isset($this->positions[sha1($match->getHomeTeam()->getName())])) {
            $this->positions[sha1($match->getHomeTeam()->getName())] = new Position($match->getHomeTeam());
        }
        $homeTeamPosition = $this->positions[sha1($match->getHomeTeam()->getName())];

        return $homeTeamPosition;
    }

    /**
     * @param Match $match
     * @return Position
     */
    private function getAwayTeamPosition(Match $match): Position
    {
        if (!isset($this->positions[sha1($match->getAwayTeam()->getName())])) {
            $this->positions[sha1($match->getAwayTeam()->getName())] = new Position($match->getAwayTeam());
        }
        $awayTeamPosition = $this->positions[sha1($match->getAwayTeam()->getName())];

        return $awayTeamPosition;
    }
}
