<?php
declare(strict_types=1);


namespace BallGame\Domain\RuleBook;


use BallGame\Domain\Team\Position;

class AdvancedRuleBook implements RuleBookInterface
{
    public function decide(Position $teamA, Position $teamB)
    {
        if ($teamA->getPercentage() > $teamB->getPercentage()) {
            return -1;
        }

        if ($teamB->getPercentage() > $teamA->getPercentage()) {
            return 1;
        }

        if ($teamA->getPercentage() === $teamB->getPercentage()) {
            if ($teamA->getWins() > $teamB->getWins()) {
                return -1;
            }

            if ($teamB->getWins() > $teamA->getWins()) {
                return 1;
            }

            if ($teamB->getWins() === $teamA->getWins()) {
                return 0;
            }
        }
    }
}
