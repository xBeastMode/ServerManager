<?php

namespace mcrafters;

use pocketmine\utils\Config;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as CM;
use pocketmine\command\PluginCommand;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\Server;
use pocketmine\IPlayer;
use pocketmine\Player;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerGameModeChangeEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerGameModeChangeEvent;
use pocketmine\event\player\PlayerToggleSneakEvent;

class ServerManager extends PluginBase implements Listener
{
	public $cfg;
	
	public function onEnable()
	{
	        $this->getServer()->getPluginManager()->registerEvents($this, $this);
	        $this->getServer()->getLogger()->info(MT::GRAY . "[" . MT::BOLD . MT::AQUA . "Server" . MT::GRAY . "-" . MT::YELLOW . "Manager" . MT::GRAY . "] " . MT::GREEN . " has enabled");
	        $this->getServer()->getLogger()->info(MT::GRAY . "[" . MT::BOLD . MT::AQUA . "Server" . MT::GRAY . "-" . MT::YELLOW . "Manager" . MT::GRAY . "] " . MT::DARK_PURPLE . " The Plugin Is Still In Development So for now it is not working check back later");
			@mkdir($this->getDataFolder());
	        $this->saveResource("config.yml");
	        $this->cfg = new Config ($this->getDataFolder() . "config.yml", Config::YAML);
        }
        
    public function onDisable()
	{
		$this->getLogger()->info(MT::GRAY . "[" . MT::BOLD . MT::GREEN . "Server - " . MT::YELLOW . "Manager" . MT::GRAY . "] " . MT::RED . " has disabled");
	}
}
