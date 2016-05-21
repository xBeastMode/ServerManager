<?php

namespace mcrafters;

use pocketmine\utils\Config;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as SM;
use pocketmine\command\PluginCommand;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\Server;
use pocketmine\IPlayer;
use pocketmine\Player;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerGameModeChangeEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerToggleSneakEvent;

class ServerManager extends PluginBase implements Listener
{
    public $cfg;

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getLogger()->info(SM::GRAY . "[" . SM::BOLD . SM::AQUA . "Server" . SM::GRAY . "-" . SM::YELLOW . "Manager" . SM::GRAY . "] " . SM::GREEN . " has successfully enabled");
        $this->getServer()->getLogger()->info(SM::GRAY . "[" . SM::BOLD . SM::AQUA . "Server" . SM::GRAY . "-" . SM::YELLOW . "Manager" . SM::GRAY . "] " . SM::DARK_PURPLE . " This plugin is still in development mode. Most features will not work. Please check back at a later date.");
        @mkdir($this->getDataFolder());
        $this->saveResource("config.yml");
        $this->saveResource("messages.yml");
        $this->cfg = new Config ($this->getDataFolder() . "config.yml", Config::YAML);
        $this->cfgm = new Config ($this->getDataFolder() . "messages.yml", Config::YAML);
    }

    public function onBreak(BlockBreakEvent $bbe)
    {
        if($this->cfg->get("BlockBreaking") == false or $this->cfg->get("BlockBreaking") == disabled){
        if(!$bbe->getPlayer()->hasPermission('servermanager.bypass') or $bbe->getPlayer()->isOp()){
            $bbe->getPlayer()->sendMessage(SM::GRAY . "[" . SM::AQUA . "Server-" . SM::YELLOW . "Manager" . SM::GRAY . "] " . $this->cfgm->get("BlockBreaking"));
        $bbe->setCancelled();
    }
	}
}
    public function onDisable()
	{
		$this->saveResource("config.yml");
        	$this->saveResource("messages.yml");
		$this->getLogger()->info(SM::GRAY . "[" . SM::BOLD . SM::GREEN . "Server - " . SM::YELLOW . "Manager" . SM::GRAY . "] " . SM::RED . " has successfully disabled");
	}
}
