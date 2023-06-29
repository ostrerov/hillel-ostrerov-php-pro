<?php

namespace Classes;

class Car extends Transport
{
    /**
     * @param  string  $name
     * @param  string  $type
     * @param  int  $speed
     * @param  int  $numDoors
     * @param  float  $engineSize
     * @param  int  $horsePower
     */
    public function __construct(
        protected string $name,
        protected string $type,
        protected int $speed,
        private int $numDoors,
        private float $engineSize,
        private int $horsePower
    ) {
        parent::__construct($name, $type, $speed);
    }

    /**
     * @return int
     */
    public function getNumDoors(): int
    {
        return $this->numDoors;
    }

    /**
     * @param  int  $numDoors
     */
    public function setNumDoors(int $numDoors): void
    {
        $this->numDoors = $numDoors;
    }

    /**
     * @return float
     */
    public function getEngineSize(): float
    {
        return $this->engineSize;
    }

    /**
     * @param  float  $engineSize
     */
    public function setEngineSize(float $engineSize): void
    {
        $this->engineSize = $engineSize;
    }

    /**
     * @return int
     */
    public function getHorsePower(): int
    {
        return $this->horsePower;
    }

    /**
     * @param  int  $horsePower
     */
    public function setHorsePower(int $horsePower): void
    {
        $this->horsePower = $horsePower;
    }

    /**
     * @return string
     */
    public function startEngine(): string
    {
        return "Запуск двигуна у {$this->name}...";
    }

    /**
     * @return string
     */
    public function getInfo(): string
    {
        return parent::getInfo().
            "Дверей: {$this->numDoors}. Кінські сили: {$this->horsePower}. Об'єм двигуна: {$this->engineSize}. ";
    }
}