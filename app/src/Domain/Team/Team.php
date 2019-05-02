<?php
declare(strict_types=1);


namespace BallGame\Domain\Team;


use BallGame\Domain\Exception\TeamWithEmptyNameException;

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
        if (empty($name)) {
            throw new TeamWithEmptyNameException();
        }

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
