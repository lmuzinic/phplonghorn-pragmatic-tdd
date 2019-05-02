<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\RuleBook;

use BallGame\Domain\RuleBook\RuleBookInterface;
use BallGame\Domain\RuleBook\SimpleRuleBook;
use BallGame\Domain\Team\Position;
use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;

class SimpleRuleBookTest extends TestCase
{
    /**
     * @var RuleBookInterface
     */
    protected $ruleBook;

    public function setUp()
    {
        $this->ruleBook = new SimpleRuleBook();
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

    public function testDecideReturnsZeroWhenTeamsHaveEqualPoints()
    {
        $teamPositionA = $this->getMockBuilder(Position::class)
            ->disableOriginalConstructor()
            ->getMock();

        $teamPositionB = $this->getMockBuilder(Position::class)
            ->disableOriginalConstructor()
            ->getMock();

        $teamPositionA->method('getPercentage')->willReturn(0.250);
        $teamPositionB->method('getPercentage')->willReturn(0.250);

        $this->assertSame(0, $this->ruleBook->decide($teamPositionA, $teamPositionB));
    }
}
