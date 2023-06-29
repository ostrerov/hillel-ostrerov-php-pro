<?php

namespace Classes;

class Boat extends Transport
{
    private int $numPassengers;
    private int $maxPassengers;
    private string $engineType;

    /**
     * @param  string  $name
     * @param  string  $type
     * @param  int  $speed
     * @param  int  $numPassengers
     * @param  string  $engineType
     */
    public function __construct(
        string $name,
        string $type,
        int $speed,
        int $maxPassengers,
        int $numPassengers,
        string $engineType
    ) {
        parent::__construct($name, $type, $speed);
        $this->maxPassengers = $maxPassengers;
        $this->numPassengers = $numPassengers;
        $this->engineType = $engineType;
    }

    /**
     * @return int
     */
    public function getNumPassengers(): int
    {
        return $this->numPassengers;
    }

    /**
     * @param  int  $numPassengers
     */
    public function setNumPassengers(int $numPassengers): void
    {
        $this->numPassengers = $numPassengers;
    }

    /**
     * @return string
     */
    public function getEngineType(): string
    {
        return $this->engineType;
    }

    /**
     * @param  string  $engineType
     */
    public function setEngineType(string $engineType): void
    {
        $this->engineType = $engineType;
    }

    /**
     * @return string
     */
    public function travel(): string
    {
        return "Подорож із {$this->numPassengers} пасажирами зі {$this->maxPassengers}. Борт: {$this->name}.";
    }

    /**
     * @return string
     */
    public function getInfo(): string
    {
        return parent::getInfo(
            )."Кількість пасажирів: {$this->numPassengers}. Максимальна вмістимість пасажирів: {$this->maxPassengers}. Засіб руху: {$this->engineType}.";
    }
}