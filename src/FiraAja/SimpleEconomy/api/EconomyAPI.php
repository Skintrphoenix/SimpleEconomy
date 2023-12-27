<?php

namespace FiraAja\SimpleEconomy\api;

use FiraAja\SimpleEconomy\SimpleEconomy;
use FiraAja\SimpleEconomy\utils\QueryConstant;

class EconomyAPI {

    /**
     * @param string $player
     * @param int $balance
     * @param ?callable $onSuccess
     * @param ?callable $onError
     * @return void
     */
    public static function insert(string $player, int $balance, ?callable $onSuccess = null, ?callable $onError = null): void {
        SimpleEconomy::getInstance()->getProvider()->executeInsert(QueryConstant::ECONOMY_CREATE, [
            "player" => $player,
            "balance" => $balance
        ], $onSuccess, $onError);
    }

    /**
     * @param string $player
     * @param ?callable $onSuccess
     * @param ?callable $onError
     * @return void
     */
    public static function get(string $player, ?callable $onSuccess = null, ?callable $onError = null): void {
        SimpleEconomy::getInstance()->getProvider()->executeSelect(QueryConstant::ECONOMY_LOAD, [
            "player" => $player,
        ], $onSuccess, $onError);
    }

    /**
     * @param string $player
     * @param ?callable $onSuccess
     * @param ?callable $onError
     * @return void
     */
    public static function balance(string $player, ?callable $onSuccess = null, ?callable $onError = null): void {
        SimpleEconomy::getInstance()->getProvider()->executeSelect(QueryConstant::ECONOMY_BALANCE, [
            "player" => $player,
        ], $onSuccess, $onError);
    }

    /**
     * @param string $player
     * @param int $balance
     * @param ?callable $onSuccess
     * @param ?callable $onError
     * @return void
     */
    public static function add(string $player, int $balance, ?callable $onSuccess = null, ?callable $onError = null): void {
        SimpleEconomy::getInstance()->getProvider()->executeInsert(QueryConstant::ECONOMY_ADD_BALANCE, [
            "player" => $player,
            "balance" => $balance
        ], $onSuccess, $onError);
    }

    /**
     * @param string $player
     * @param int $balance
     * @param ?callable $onSuccess
     * @param ?callable $onError
     * @return void
     */
    public static function subtract(string $player, int $balance, ?callable $onSuccess = null, ?callable $onError = null): void {
        SimpleEconomy::getInstance()->getProvider()->executeInsert(QueryConstant::ECONOMY_SUBTRACT_BALANCE, [
            "player" => $player,
            "balance" => $balance
        ], $onSuccess, $onError);
    }

    /**
     * @param string $player
     * @param int $balance
     * @param ?callable $onSuccess
     * @param ?callable $onError
     * @return void
     */
    public static function set(string $player, int $balance, ?callable $onSuccess = null, ?callable $onError = null): void {
        SimpleEconomy::getInstance()->getProvider()->executeInsert(QueryConstant::ECONOMY_SET_BALANCE, [
            "player" => $player,
            "balance" => $balance
        ], $onSuccess, $onError);
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