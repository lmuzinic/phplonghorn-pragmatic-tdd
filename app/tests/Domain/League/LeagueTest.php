<?php
declare(strict_types=1);


namespace BallGame\Tests\Domain\League;


use BallGame\Domain\League\League;
use BallGame\Domain\Match\Match;
use BallGame\Domain\Team\Team;
use BallGame\Infrastructure\MatchRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class LeagueTest extends TestCase
{
    /**
     * @var League
     */
    private $league;

    /**
     * @var MatchRepository|MockObject
     */
    private $matchRepository;

    public function setUp()
    {
        $this->matchRepository = $this
            ->getMockBuilder(MatchRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->matchRepository->expects($this->atLeastOnce())->method('save');
        
        $this->league = new League($this->matchRepository);
    }

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

        $this->league->record($match);

        $this->matchRepository->method('findAll')->willReturn([$match]);

        $sortedStandings = $this->league->getSortedStandings();

        $this->assertSame([
            ['Houston Astros', '1.000', 1, 0],
            ['Texas Rangers', '0.000', 0, 1],
        ], $sortedStandings);
    }

    public function testGetStandingsShouldReturnSortedLeagueStandingsWhenAwayTeamWinsInThreeGamesOutOfFour()
    {
        $astros = Team::create('Houston Astros');
        $rangers = Team::create('Texas Rangers');

        $match1 = Match::create(
            $rangers,
            $astros,
            0,
            10
        );

        $this->league->record($match1);

        $match2 = Match::create(
            $rangers,
            $astros,
            0,
            3
        );

        $this->league->record($match2);

        $match3 = Match::create(
            $rangers,
            $astros,
            0,
            1
        );

        $this->league->record($match3);

        $match4 = Match::create(
            $rangers,
            $astros,
            1,
            0
        );

        $this->league->record($match4);

        $this->matchRepository->method('findAll')->willReturn([
            $match1,
            $match2,
            $match3,
            $match4,
        ]);
        $sortedStandings = $this->league->getSortedStandings();

        $this->assertSame([
            ['Houston Astros', '0.750', 3, 1],
            ['Texas Rangers', '0.250', 1, 3],
        ], $sortedStandings);
    }
}
