<?php

namespace FiraAja\SimpleEconomy\commands;

use FiraAja\SimpleEconomy\api\EconomyAPI;
use FiraAja\SimpleEconomy\SimpleEconomy;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use poggit\libasynql\SqlError;

class EconomyCommand extends Command {

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->setPermission("economy.command");
        $this->setDescription("EssentialsEconomy Command");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (isset($args[0])) {
            switch ($args[0]) {
                case "add":
                case "give":
                    if (!$sender->hasPermission("economy.command.add")) return;
                    if (!isset($args[1])) {
                        $sender->sendMessage(TextFormat::RED . "/" . $commandLabel . " " . $args[0] . " <amount>");
                        return;
                    }
                    $player = Server::getInstance()->getPlayerExact($args[1]);
                    if (!is_numeric($args[2])) {
                        $sender->sendMessage(TextFormat::RED . "Amount must be type numeric");
                        return;
                    }
                    EconomyAPI::get($player->getName(), static function (array $rows) use ($args, $player, $sender): void {
                        if (count($rows) > 0) {
                            EconomyAPI::add($player->getName(), $args[2], static function () use ($args, $sender, $player): void {
                                $sender->sendMessage(TextFormat::GREEN . "You have added " . TextFormat::YELLOW . $args[2] . TextFormat::GREEN . " to " . TextFormat::YELLOW . $player->getName());
                            }, static fn(SqlError $error) => SimpleEconomy::getInstance()->getLogger()->error($error->getMessage()));
                        }
                    }, static fn(SqlError $error) => SimpleEconomy::getInstance()->getLogger()->error($error->getMessage()));

                    break;
                case "reduce":
                case "take":
                    if (!$sender->hasPermission("economy.command.reduce")) return;
                    if (!isset($args[1])) {
                        $sender->sendMessage(TextFormat::RED . "/" . $commandLabel . " " . $args[0] . " <amount>");
                        return;
                    }
                    $player = Server::getInstance()->getPlayerExact($args[1]);
                    if (!is_numeric($args[2])) {
                        $sender->sendMessage(TextFormat::RED . "Amount must be type numeric");
                        return;
                    }
                    EconomyAPI::get($player->getName(), static function (array $rows) use ($args, $player, $sender): void {
                        if (count($rows) > 0) {
                            EconomyAPI::subtract($player->getName(), $args[2], static function () use ($args, $sender, $player): void {
                                $sender->sendMessage(TextFormat::GREEN . "You have take " . TextFormat::YELLOW . $args[2] . TextFormat::GREEN . " from " . TextFormat::YELLOW . $player->getName() . "'s " . TextFormat::GREEN . "balance");
                            }, static fn(SqlError $error) => SimpleEconomy::getInstance()->getLogger()->error($error->getMessage()));
                        }
                    }, static fn(SqlError $error) => SimpleEconomy::getInstance()->getLogger()->error($error->getMessage()));
                    break;
                case "set":
                    if (!$sender->hasPermission("economy.command.set")) return;
                    if (!isset($args[1])) {
                        $sender->sendMessage(TextFormat::RED . "/" . $commandLabel . " " . $args[0] . " <amount>");
                        return;
                    }
                    $player = Server::getInstance()->getPlayerExact($args[1]);
                    if (!is_numeric($args[2])) {
                        $sender->sendMessage(TextFormat::RED . "Amount must be type numeric");
                        return;
                    }
                    EconomyAPI::get($player->getName(), static function (array $rows) use ($args, $player, $sender): void {
                        if (count($rows) > 0) {
                            EconomyAPI::set($player->getName(), $args[2], static function () use ($args, $sender, $player): void {
                                $sender->sendMessage(TextFormat::GREEN . "You have set " . TextFormat::YELLOW . $player->getName() . "'s " . TextFormat::GREEN . "balance to " . TextFormat::YELLOW . $args[2]);
                            }, static fn(SqlError $error) => SimpleEconomy::getInstance()->getLogger()->error($error->getMessage()));
                        }
                    }, static fn(SqlError $error) => SimpleEconomy::getInstance()->getLogger()->error($error->getMessage()));

                    break;
                case "top":
                    EconomyAPI::top(static function (array $rows) use ($sender): void {
                        $name = TextFormat::BOLD . TextFormat::GREEN . "TOP BALANCE" . PHP_EOL;
                        $i = 1;
                        foreach ($rows as $k) {
                            if ($i == 11) break;
                            $name .= $i . " - " . $k['player'] . " - " . $k['balance'] . PHP_EOL;
                            $i++;
                        }
                        $sender->sendMessage($name);
                    }, static fn(SqlError $error) => SimpleEconomy::getInstance()->getLogger()->error($error->getMessage()));
                    break;
            }
        }
    }
}