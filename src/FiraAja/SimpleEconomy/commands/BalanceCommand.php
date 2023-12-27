<?php

namespace FiraAja\SimpleEconomy\commands;

use FiraAja\SimpleEconomy\api\EconomyAPI;
use FiraAja\SimpleEconomy\EconomyCurrency;
use FiraAja\SimpleEconomy\SimpleEconomy;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use poggit\libasynql\SqlError;

class BalanceCommand extends Command {

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->setDescription("Show player balance");
        $this->setPermission("economy.command.balance");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void
    {
        $player = $args[0] ?? null;
        if (!$sender instanceof Player && $player === null) {
            $sender->sendMessage(TextFormat::RED . "/balance <player>");
            return;
        }
        if ($player !== null) {
            $playerExact = Server::getInstance()->getPlayerExact($player);

            if ($playerExact !== null) {
                $player = $playerExact->getName();
            }
        }

        $player ??= $sender->getName();
        $isSelf = $player === $sender->getName();

        EconomyAPI::get($player, static function (array $rows) use ($player, $sender, $isSelf): void {
            if (count($rows) > 0) {
                EconomyAPI::balance($player, static function (array $rows) use ($sender, $isSelf): void {
                    $sender->sendMessage($isSelf ? TextFormat::GREEN . "Your balance: " . TextFormat::YELLOW . EconomyCurrency::symbol() . $rows[0]['balance'] : TextFormat::GREEN . $rows[0]['player'] . "'s balance: " . TextFormat::YELLOW . EconomyCurrency::symbol() . $rows[0]['balance']);
                }, static function (SqlError $error) {
                    SimpleEconomy::getInstance()->getLogger()->error($error->getMessage());
                });
            } else {
                $sender->sendMessage(TextFormat::RED . "Player " . $player . " not found");
            }
        }, static function (SqlError $error) {
            SimpleEconomy::getInstance()->getLogger()->error($error->getMessage());
        });

    }
}