<?php
declare(strict_types=1);


namespace BallGame\Infrastructure;


use BallGame\Domain\Match\Match;

class MatchRepository
{
    /**
     * @var Match[]
     */
    private $matches;

    public function save(Match $match)
    {
        $this->matches[] = $match;
    }

    public function findAll()
    {
        return $this->matches;
    }
}
