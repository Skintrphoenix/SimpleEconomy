<?php

namespace FiraAja\SimpleEconomy;

use FiraAja\SimpleEconomy\commands\BalanceCommand;
use FiraAja\SimpleEconomy\commands\EconomyCommand;
use FiraAja\SimpleEconomy\commands\PayCommand;
use FiraAja\SimpleEconomy\utils\QueryConstant;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use poggit\libasynql\DataConnector;
use poggit\libasynql\libasynql;

class SimpleEconomy extends PluginBase {
    use SingletonTrait;

    /** @var DataConnector $connector */
    private DataConnector $connector;

    protected function onEnable(): void
    {
        SimpleEconomy::$instance = $this;
        if (!class_exists(libasynql::class)) {
            $this->getLogger()->error("libasynql not found");
            $this->getServer()->shutdown();
        }
        $this->saveDefaultConfig();
        $this->initProvider();
        $this->initCommands();

        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }

    protected function onDisable(): void
    {
        $this->connector->close();
    }

    /**
     * @return void
     */
    private function initProvider(): void {
        $this->connector = libasynql::create($this, $this->getConfig()->get("database"), [
            "sqlite" => "sqlite.sql",
            "mysql" => "mysql.sql"
        ]);
        $this->connector->executeGeneric(QueryConstant::ECONOMY_INIT);
        $this->connector->waitAll();
    }

    private function initCommands(): void {
        $this->getServer()->getCommandMap()->registerAll("EssentialsEconomy", [
            new BalanceCommand("balance"),
            new EconomyCommand("economy"),
            new PayCommand("pay")
        ]);
    }

    /**
     * @return DataConnector
     */
    public function getProvider(): DataConnector {
        return $this->connector;
    }
}