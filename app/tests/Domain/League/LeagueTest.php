<?php
declare(strict_types=1);


namespace BallGame\Tests\Domain\League;


use BallGame\Domain\League\League;
use BallGame\Domain\Match\Match;
use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;

class LeagueTest extends TestCase
{
    public function testGetStandingsShouldReturnSortedLeagueStandings()
    {
        $astros = Team::create('Houston Astros');
        $rangers = Team::create('Texas Rangers');

        $match = Match::create(
            $astros,
            $rangers,
            2,
            0
        );

        $league = new League();

        $league->record($match);

        $sortedStandings = $league->getSortedStandings();

        $this->assertSame([
            ['Houston Astros', '1.000', 1, 0],
            ['Texas Rangers', '0.000', 0, 1],
        ], $sortedStandings);
    }

    public function testGetStandingsShouldReturnSortedLeagueStandingsWhenAwayTeamWinsInThreeGamesOutOfFour()
    {
        $league = new League();

        $astros = Team::create('Houston Astros');
        $rangers = Team::create('Texas Rangers');

        $match = Match::create(
            $rangers,
            $astros,
            0,
            10
        );

        $league->record($match);

        $match = Match::create(
            $rangers,
            $astros,
            0,
            3
        );

        $league->record($match);

        $match = Match::create(
            $rangers,
            $astros,
            0,
            1
        );

        $league->record($match);

        $match = Match::create(
            $rangers,
            $astros,
            1,
            0
        );

        $league->record($match);

        $sortedStandings = $league->getSortedStandings();

        $this->assertSame([
            ['Houston Astros', '0.750', 3, 1],
            ['Texas Rangers', '0.250', 1, 3],
        ], $sortedStandings);
    }
}
