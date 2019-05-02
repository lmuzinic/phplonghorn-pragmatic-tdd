<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\RuleBook;

use BallGame\Domain\RuleBook\AdvancedRuleBook;
use BallGame\Domain\RuleBook\RuleBookInterface;
use BallGame\Domain\Team\Position;
use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;

class AdvancedRuleBookTest extends TestCase
{

    /**
     * @var RuleBookInterface
     */
    protected $ruleBook;

    public function setUp()
    {
        $this->ruleBook = new AdvancedRuleBook();
    }
    public function testDecideReturnsNegativeOneWhenFirstTeamHasMorePointsThanSecond()
    {
        $teamPositionA = $this->getMockBuilder(Position::class)
            ->disableOriginalConstructor()
            ->getMock();

        $teamPositionB = $this->getMockBuilder(Position::class)
            ->disableOriginalConstructor()
            ->getMock();

        $teamPositionA->method('getPercentage')->willReturn(0.250);
        $teamPositionB->method('getPercentage')->willReturn(0.249);

        $this->assertSame(-1, $this->ruleBook->decide($teamPositionA, $teamPositionB));
    }

    public function testDecideReturnsPositiveOneWhenSecondTeamHasMorePointsThanFirst()
    {
        $teamPositionA = $this->getMockBuilder(Position::class)
            ->disableOriginalConstructor()
            ->getMock();

        $teamPositionB = $this->getMockBuilder(Position::class)
            ->disableOriginalConstructor()
            ->getMock();

        $teamPositionA->method('getPercentage')->willReturn(0.250);
        $teamPositionB->method('getPercentage')->willReturn(0.251);

        $this->assertSame(1, $this->ruleBook->decide($teamPositionA, $teamPositionB));
    }

    public function testDecideReturnsNegativeOneWhenTeamsHaveEqualPointsButFirstTeamHasMoreRuns()
    {
        $teamPositionA = $this->getMockBuilder(Position::class)
            ->disableOriginalConstructor()
            ->getMock();

        $teamPositionB = $this->getMockBuilder(Position::class)
            ->disableOriginalConstructor()
            ->getMock();

        $teamPositionA->method('getPercentage')->willReturn(0.250);
        $teamPositionB->method('getPercentage')->willReturn(0.250);

        $teamPositionA->method('getWins')->willReturn(10);
        $teamPositionB->method('getWins')->willReturn(9);

        $this->assertSame(-1, $this->ruleBook->decide($teamPositionA, $teamPositionB));
    }

    public function testDecideReturnsPositiveOneWhenTeamsHaveEqualPointsButSecondTeamHasMoreRuns()
    {
        $teamPositionA = $this->getMockBuilder(Position::class)
            ->disableOriginalConstructor()
            ->getMock();

        $teamPositionB = $this->getMockBuilder(Position::class)
            ->disableOriginalConstructor()
            ->getMock();

        $teamPositionA->method('getPercentage')->willReturn(0.250);
        $teamPositionB->method('getPercentage')->willReturn(0.250);

        $teamPositionA->method('getWins')->willReturn(10);
        $teamPositionB->method('getWins')->willReturn(11);

        $this->assertSame(1, $this->ruleBook->decide($teamPositionA, $teamPositionB));
    }

    public function testDecideReturnsZeroWhenTeamsHaveEqualPercentageAndWins()
    {
        $teamPositionA = $this->getMockBuilder(Position::class)
            ->disableOriginalConstructor()
            ->getMock();

        $teamPositionB = $this->getMockBuilder(Position::class)
            ->disableOriginalConstructor()
            ->getMock();

        $teamPositionA->method('getPercentage')->willReturn(0.250);
        $teamPositionB->method('getPercentage')->willReturn(0.250);

        $teamPositionA->method('getWins')->willReturn(11);
        $teamPositionB->method('getWins')->willReturn(11);

        $this->assertSame(0, $this->ruleBook->decide($teamPositionA, $teamPositionB));
    }
}
