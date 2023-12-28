<?php

namespace FiraAja\SimpleEconomy\commands;

use FiraAja\SimpleEconomy\api\EconomyAPI;
use FiraAja\SimpleEconomy\SimpleEconomy;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use poggit\libasynql\SqlError;

class PayCommand extends Command {

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->setPermission("economy.command.pay");
        $this->setDescription("Pay with your balance");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $player = $args[0] ?? null;
        if (!$sender instanceof Player && $player === null) {
            $sender->sendMessage(TextFormat::RED . "/pay <player> <amount>");
            return;
        }
        if ($player !== null) {
            $playerExact = Server::getInstance()->getPlayerExact($player);

            if ($playerExact !== null) {
                $player = $playerExact;
            }
        }
        if (!is_numeric($args[1])) {
            $sender->sendMessage(TextFormat::RED . "Amount must be type numeric");
            return;
        }

        EconomyAPI::get($player, static function (array $rows) use ($player, $args, $playerExact, $sender): void {
            if (count($rows) > 0) {
                EconomyAPI::balance($sender, static function (array $rows) use ($args, $player, $playerExact, $sender): void {
                    if ($rows[0]['balance'] >= $args[1]) {
                        EconomyAPI::subtract($sender, $args[1], static function () use ($args, $player, $playerExact, $sender): void {
                            EconomyAPI::add($player, $args[1], static function () use ($playerExact, $args, $sender): void {
                                $playerExact->sendMessage(TextFormat::GREEN . "You have received " . TextFormat::YELLOW . $args[1] . TextFormat::GREEN . " from " . TextFormat::YELLOW . $sender);
                            }, static fn(SqlError $error) => SimpleEconomy::getInstance()->getLogger()->error($error->getMessage()));
                            $sender->sendMessage(TextFormat::GREEN . "You have paid " . TextFormat::YELLOW . $args[1] . TextFormat::GREEN . " to " . TextFormat::YELLOW . $playerExact);
                        }, static fn(SqlError $error) => SimpleEconomy::getInstance()->getLogger()->error($error->getMessage()));
                    }
                }, static fn(SqlError $error) => SimpleEconomy::getInstance()->getLogger()->error($error->getMessage()));
            }
        });
    }
}