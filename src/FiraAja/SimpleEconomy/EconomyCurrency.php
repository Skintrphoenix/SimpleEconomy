<?php

namespace FiraAja\SimpleEconomy;

class EconomyCurrency {

    /**
     * @return string
     */
    public static function name(): string {
        return SimpleEconomy::getInstance()->getConfig()->get("currency")["name"];
    }


    /**
     * @return string
     */
    public static function symbol(): string {
        return SimpleEconomy::getInstance()->getConfig()->get("currency")["symbol"];
    }

    /**
     * @return string
     */
    public static function code(): string {
        return SimpleEconomy::getInstance()->getConfig()->get("currency")["code"];
    }

    public static function default(): string {
        return SimpleEconomy::getInstance()->getConfig()->get("currency")["default"];
    }
}