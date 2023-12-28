<?php

namespace FiraAja\SimpleEconomy;

use FiraAja\SimpleEconomy\api\EconomyAPI;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
use poggit\libasynql\SqlError;

class EventListener implements Listener {

    public function __construct (protected readonly SimpleEconomy $plugin) {}

    /**
     * @param PlayerLoginEvent $event
     * @return void
     */
    public function onLogin (PlayerLoginEvent $event): void {
        $player = $event->getPlayer();

        if ($player->isConnected()) {
            EconomyAPI::get($player, static function (array $rows) use ($player): void {
                if (count($rows) === 0) {
                    EconomyAPI::insert($player, EconomyCurrency::default(),
                        static fn() => SimpleEconomy::getInstance()->getLogger()->info("New player: " . $player->getName() . " registered"),
                        static fn(SqlError $error) => SimpleEconomy::getInstance()->getLogger()->error($error->getMessage())
                    );
                }
            }, static fn(SqlError $error) => SimpleEconomy::getInstance()->getLogger()->error($error->getMessage()));
        }
    }
}