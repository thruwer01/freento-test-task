<?php

declare(strict_types = 1);


class Player
{

    private string $name;
    
    private string $city = "";

    public function __construct($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setCity(string $city)
    {
        $this->city = $city;
        
        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getNameForTournament(): string
    {
        return empty($this->getCity()) ? $this->getName() : $this->getName() . " (".$this->getCity().")";
    }
}