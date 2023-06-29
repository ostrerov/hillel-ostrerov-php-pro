<?php

namespace Classes;

class Transport
{
    /**
     * @param  string  $name
     * @param  string  $type
     * @param  int  $speed
     */
    public function __construct(
        protected string $name = 'Транспорт',
        protected string $type = 'Т/З',
        protected int $speed = 0
    ) {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param  string  $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param  string  $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getSpeed(): int
    {
        return $this->speed;
    }

    /**
     * @param  int  $speed
     */
    public function setSpeed(int $speed): void
    {
        $this->speed = $speed;
    }

    /**
     * @return string
     */
    public function getInfo(): string
    {
        return "Ім'я Т/З: {$this->name}. Тип Т/З: {$this->type}. Максимальна швидкість Т/З: {$this->speed}. ";
    }

    /**
     * @param  array  $data
     * @return array
     */
    public function getAllObjects(array $data): array
    {
        $objects = [];

        foreach ($data as $object) {
            $objects[] = $object->getInfo();
        }

        return $objects;
    }
}