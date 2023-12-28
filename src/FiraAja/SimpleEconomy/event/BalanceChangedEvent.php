<?php

namespace FiraAja\SimpleEconomy\event;

use Ifera\ScoreHud\event\PlayerEvent;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\player\Player;

class BalanceChangedEvent extends PlayerEvent implements Cancellable {
    use CancellableTrait;

    public function __construct(protected Player $player, protected float $amount = 0)
    {
        parent::__construct($this->player);
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

}