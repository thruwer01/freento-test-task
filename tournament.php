<?php

declare(strict_types = 1);


class Tournament {

    private string $name;

    private string $startDate;

    private array $players;

    private array $pairs;

    public function __construct(string $name, string $startDate = "")
    {
        $this->name = $name;
        $this->startDate = !empty($startDate) ? $startDate : $this->plusDayFromDate(date('Y-m-d'));
    }

    public function addPlayer(Player $player): Tournament
    {
        $this->players[] = $player;
        return $this;
    }

    public function renderPairs():void
    {
        foreach($this->pairs as $date => $players) {
            echo "$this->name, $date \n";
            foreach ($players as $player1 => $player2) {
                echo "$player1 - $player2\n";
            }
        }
    }

    private function checkDatesForPlayers(string $player1,string $player2,string $eventDate): array
    {
        if (!isset($this->pairs[$eventDate])) $this->pairs[$eventDate] = [];

        if (
        !isset($this->pairs[$eventDate][$player1]) &&
        !isset($this->pairs[$eventDate][$player2]) &&
        !in_array($player2, array_values($this->pairs[$eventDate])) &&
        !in_array($player1, array_values($this->pairs[$eventDate]))
        ) {

            $this->pairs[$eventDate][$player1] = $player2;
        } else {
            $eventDate = $this->plusDayFromDate($eventDate);
            return $this->checkDatesForPlayers($player1, $player2, $eventDate);
        }
            
        return $this->pairs;
    }
    
    public function createPairs(): void
    {   
        //Я так на кодварсе не потел
        foreach ($this->players as $key => $player1)
        {
            $temp = array_slice($this->players, $key + 1);
            $eventDate = $this->startDate;

            foreach ($temp as $key2 => $player2)
            {
                $this->pairs = $this->checkDatesForPlayers($player1->getName(), $player2->getName(), $eventDate);
            }
        }
        $this->renderPairs();
    }

    private function plusDayFromDate(string $date): string
    {
        return date('Y.m.d', strtotime(str_replace('.', '-', $date) . '+ 1 days'));
    }

}