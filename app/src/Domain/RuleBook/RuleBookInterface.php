<?php
declare(strict_types=1);


namespace BallGame\Domain\RuleBook;


use BallGame\Domain\Team\Position;

interface RuleBookInterface
{
    public function decide(Position $teamA, Position $teamB);
}
