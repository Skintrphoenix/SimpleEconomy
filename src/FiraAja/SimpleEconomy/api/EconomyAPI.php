<?php

namespace FiraAja\SimpleEconomy\api;

use FiraAja\SimpleEconomy\event\BalanceChangedEvent;
use FiraAja\SimpleEconomy\SimpleEconomy;
use FiraAja\SimpleEconomy\utils\QueryConstant;
use pocketmine\player\Player;

class EconomyAPI {

    /**
     * @param Player $player
     * @param int $balance
     * @param ?callable $onSuccess
     * @param ?callable $onError
     * @return void
     */
    public static function insert(Player $player, int $balance, ?callable $onSuccess = null, ?callable $onError = null): void {
        SimpleEconomy::getInstance()->getProvider()->executeInsert(QueryConstant::ECONOMY_CREATE, [
            "player" => $player->getName(),
            "balance" => $balance
        ], $onSuccess, $onError);
    }

    /**
     * @param Player $player
     * @param ?callable $onSuccess
     * @param ?callable $onError
     * @return void
     */
    public static function get(Player $player, ?callable $onSuccess = null, ?callable $onError = null): void {
        SimpleEconomy::getInstance()->getProvider()->executeSelect(QueryConstant::ECONOMY_LOAD, [
            "player" => $player->getName(),
        ], $onSuccess, $onError);
    }

    /**
     * @param Player $player
     * @param ?callable $onSuccess
     * @param ?callable $onError
     * @return void
     */
    public static function balance(Player $player, ?callable $onSuccess = null, ?callable $onError = null): void {
        SimpleEconomy::getInstance()->getProvider()->executeSelect(QueryConstant::ECONOMY_BALANCE, [
            "player" => $player->getName(),
        ], $onSuccess, $onError);
    }

    /**
     * @param Player $player
     * @param int $balance
     * @param ?callable $onSuccess
     * @param ?callable $onError
     * @return void
     */
    public static function add(Player $player, int $balance, ?callable $onSuccess = null, ?callable $onError = null): void {
        $event = new BalanceChangedEvent($player, $balance);
        $event->call();

        if ($event->isCancelled()) return;

        SimpleEconomy::getInstance()->getProvider()->executeInsert(QueryConstant::ECONOMY_ADD_BALANCE, [
            "player" => $player->getName(),
            "balance" => $balance
        ], $onSuccess($event), $onError);
    }

    /**
     * @param Player $player
     * @param int $balance
     * @param ?callable $onSuccess
     * @param ?callable $onError
     * @return void
     */
    public static function subtract(Player $player, int $balance, ?callable $onSuccess = null, ?callable $onError = null): void {
        $event = new BalanceChangedEvent($player, $balance);
        $event->call();

        if ($event->isCancelled()) return;

        SimpleEconomy::getInstance()->getProvider()->executeInsert(QueryConstant::ECONOMY_SUBTRACT_BALANCE, [
            "player" => $player->getName(),
            "balance" => $balance
        ], $onSuccess($event), $onError);
    }

    /**
     * @param Player $player
     * @param int $balance
     * @param ?callable $onSuccess
     * @param ?callable $onError
     * @return void
     */
    public static function set(Player $player, int $balance, ?callable $onSuccess = null, ?callable $onError = null): void {
        $event = new BalanceChangedEvent($player, $balance);
        $event->call();

        if ($event->isCancelled()) return;

        SimpleEconomy::getInstance()->getProvider()->executeInsert(QueryConstant::ECONOMY_SET_BALANCE, [
            "player" => $player->getName(),
            "balance" => $balance
        ], $onSuccess($event), $onError);
    }

    /**
     * @param ?callable $onSuccess
     * @param ?callable $onError
     * @return void
     */
    public static function top(?callable $onSuccess = null, ?callable $onError = null): void {
        SimpleEconomy::getInstance()->getProvider()->executeSelect(QueryConstant::ECONOMY_ALL, [], $onSuccess, $onError);
    }
}