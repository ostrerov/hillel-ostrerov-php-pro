<?php

namespace Classes;

class Bicycle extends Transport
{
    private int $numGears;
    private int $numTransmissions;

    /**
     * @param  string  $name
     * @param  string  $type
     * @param  int  $speed
     * @param  int  $numGears
     * @param  int  $numTransmissions
     */
    public function __construct(string $name, string $type, int $speed, int $numGears, int $numTransmissions)
    {
        parent::__construct($name, $type, $speed);
        $this->numGears = $numGears;
        $this->numTransmissions = $numTransmissions;
    }

    /**
     * @return int
     */
    public function getNumGears(): int
    {
        return $this->numGears;
    }

    /**
     * @param  int  $numGears
     */
    public function setNumGears(int $numGears): void
    {
        $this->numGears = $numGears;
    }

    /**
     * @return int
     */
    public function getNumTransmissions(): int
    {
        return $this->numTransmissions;
    }

    /**
     * @param  int  $numTransmissions
     */
    public function setNumTransmissions(int $numTransmissions): void
    {
        $this->numTransmissions = $numTransmissions;
    }

    /**
     * @return string
     */
    public function ringBell(): string
    {
        return "Дзвіночок дзвонить у {$this->name}!";
    }

    /**
     * @return string
     */
    public function getInfo(): string
    {
        return parent::getInfo().
            "Кількість передач: {$this->numTransmissions}. Кількість шестерень: {$this->numGears}. ";
    }
}