<?php
declare(strict_types=1);


namespace BallGame\Tests\Domain\League;


use BallGame\Domain\League\League;
use BallGame\Domain\Match\Match;
use BallGame\Domain\RuleBook\AdvancedRuleBook;
use BallGame\Domain\RuleBook\SimpleRuleBook;
use BallGame\Domain\Team\Team;
use BallGame\Infrastructure\MatchRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AdvancedLeagueTest extends TestCase
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

        $this->league = new League($this->matchRepository, new AdvancedRuleBook());
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
}
