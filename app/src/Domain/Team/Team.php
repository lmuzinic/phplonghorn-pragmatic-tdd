<?php
declare(strict_types=1);


namespace BallGame\Domain\Team;


class Team
{
    /**
     * @var string
     */
    private $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function create(string $name)
    {
        return new self($name);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
