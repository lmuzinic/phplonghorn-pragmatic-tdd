<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain;

use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;


class TakeMeOutTest extends TestCase
{
    /**
     * @var Team
     */
    private $favorites;

    /**
     * @var Team
     */
    private $rivals;

    public function setUp(): void
    {
        $this->favorites = Team::create('Houston Astros');
        $this->rivals = Team::create('Texas Rangers');
    }

    public function testFavoriteTeam()
    {
        $this->assertSame('Houston Astros', $this->favorites->getName());
    }

    public function testNotSoFavoriteTeam()
    {
        $this->assertSame('Texas Rangers', $this->rivals->getName());
    }
}
