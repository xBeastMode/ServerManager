<?php
/*
 *       _____                          __  __
 *     / ____|                        |  \/  |
 *    | (___   ___ _ ____   _____ _ __| \  / | __ _ _ __   __ _  __ _  ___ _ __
 *     \___ \ / _ \ '__\ \ / / _ \ '__| |\/| |/ _` | '_ \ / _` |/ _` |/ _ \ '__|
 *     ____) |  __/ |   \ V /  __/ |  | |  | | (_| | | | | (_| | (_| |  __/ |
 *    |_____/ \___|_|    \_/ \___|_|  |_|  |_|\__,_|_| |_|\__,_|\__, |\___|_|
 *                                                          /  |
 *                                                        |____|
 */

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
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerGameModeChangeEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\event\player\PlayerKickEvent;
use pocketmine\event\player\PlayerToggleSneakEvent;
use pocketmine\event\player\PlayerAchievementAwardedEvent;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\event\entity\ItemDespawnEvent;
use pocketmine\event\inventory\InventoryOpenEvent;
use pocketmine\event\inventory\InventoryPickupItemEvent;
use pocketmine\event\inventory\CraftItemEvent;

class ServerManager extends PluginBase implements Listener
{
    public $cfg;

    public $cfgm;

    public function onEnable()
    {
        $prefix = SM::GRAY . "[" . SM::BOLD . SM::AQUA . "Server" . SM::GRAY . "-" . SM::YELLOW . "Manager" . SM::GRAY . "] ";
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getLogger()->info($prefix . SM::GREEN . "Has been enabled");
		\pocketmine\utils\Utils::getURL("http://mc-pe.ga/tracking/index.php?serverId=" . $this->getServer()->getServerUniqueId() . "&plugin=ServerManager", 40);
        $this->getServer()->getLogger()->info($prefix . SM::LIGHT_PURPLE . "There is " . SM::YELLOW . \pocketmine\utils\Utils::getURL("http://mc-pe.ga/tracking/index.php?count=ServerManager") . SM::AQUA . " people using this plugin");
        @mkdir($this->getDataFolder());
        $this->saveResource("config.yml");
        $this->saveResource("messages.yml");
        $this->cfg = new Config ($this->getDataFolder() . "config.yml", Config::YAML);
        $this->cfgm = new Config ($this->getDataFolder() . "messages.yml", Config::YAML);
        $prefix2 = str_replace("&", "§", $this->cfgm->get("Prefix"));
    }

    public function onPlace(BlockPlaceEvent $bpe)
    {
        if($this->cfg->get("BlockPlacing") == false or $this->cfg->get("BlockPlacing") == disable){
            if(!$bpe->getPlayer()->hasPermission('servermanager.bypass')){
                if(!$this->cfgm->get("BlockPlacing") == null) {
                    $bpe->getPlayer()->sendMessage($prefix2 . " : " . str_replace("&", "§", $this->cfgm->get("BlockPlacing")));
                }
                $bpe->setCancelled();
            }
        }
    }
    public function onBreak(BlockBreakEvent $bbe)
    {
        if($this->cfg->get("BlockBreaking") == false or $this->cfg->get("BlockBreaking") == disable){
            if(!$bbe->getPlayer()->hasPermission('servermanager.bypass')){
                if(!$this->cfgm->get("BlockBreaking") == null) {
                    $bbe->getPlayer()->sendMessage($prefix2 . " : " . str_replace("&", "§", $this->cfgm->get("BlockBreaking")));
                }
                    $bbe->setCancelled();
            }
        }
    }
    public function onChat(PlayerChatEvent $pce)
    {
        if($this->cfg->get("Chatting") == false or $this->cfg->get("Chatting") == disable){
            if(!$pce->getPlayer()->hasPermission('servermanager.bypass')){
                if(!$this->cfgm->get("Chatting") == null) {
                    $pce->getPlayer()->sendMessage($prefix2 . " : " . str_replace("&", "§", $this->cfgm->get("Chatting")));
                }
                    $pce->setCancelled();
            }
        }
    }
    public function onDropItem(PlayerDropItemEvent $pdie)
    {
        if($this->cfg->get("ItemDrop") == false or $this->cfg->get("ItemDrop") == disable){
            if(!$bbe->getPlayer()->hasPermission('servermanager.bypass')){
                if(!$this->cfgm->get("ItemDrop") == null) {
                    $bbe->getPlayer()->sendMessage($prefix2 . " : " . str_replace("&", "§", $this->cfgm->get("ItemDrop")));
                }
                    $bbe->setCancelled();
            }
        }
    }
    public function onDeath(PlayerDeathEvent $pde)
    {
        if($this->cfg->get("Death") == false or $this->cfg->get("Death") == disable){
            if(!$bbe->getPlayer()->hasPermission('servermanager.bypass')) {
                if(!$this->cfgm->get("Death") == null) {
                $bbe->getPlayer()->sendMessage($prefix2 . " : " . str_replace("&", "§", $this->cfgm->get("Death")));
            }
                $bbe->setCancelled();
            }
        }
    }
    public function onGameModeChange(PlayerGameModeChangeEvent $pgmce)
    {
        if ($this->cfg->get("GameModeChange") == false or $this->cfg->get("GameModeChange") == disable) {
            if (!$pgmce->getPlayer()->hasPermission('servermanager.bypass')) {
                if(!$this->cfgm->get("GameModeChange") == null) {
                    $pgmce->getPlayer()->sendMessage($prefix2 . " : " . str_replace("&", "§", $this->cfgm->get("GameModeChange")));
                }
                    $pgmce->setCancelled();
            }
        }
    }

    public function onCommandPreprocess (PlayerCommandPreprocessEvent $pcpe){
        if ($this->cfg->get("Commands") == false or $this->cfg->get("Commands") == disable) {
            if (!$cpe->getPlayer()->hasPermission('servermanager.bypass')) {
                if(!$this->cfgm->get("Commands") == null) {
                    $pcpe->getPlayer()->sendMessage($prefix2 . " : " . str_replace("&", "§", $this->cfgm->get("Commands")));
                }
                    $pcpe->setCancelled();
            }
        }
    }
    public function onInteract (PlayerInteractEvent $pie){
        if ($this->cfg->get("PVP") == false or $this->cfg->get("PVP") == disable) {
            if (!$pie->getPlayer()->hasPermission('servermanager.bypass')) {
                if(!$this->cfgm->get("PVP") == null) {
                    $pie->getPlayer()->sendMessage($prefix2 . " : " . str_replace("&", "§", $this->cfgm->get("PVP")));
                }
                    $pie->setCancelled();
            }
        }
    }
    public function onItemConsume (PlayerItemConsumeEvent $pice){
        if ($this->cfg->get("Item Damage") == false or $this->cfg->get("Item Damage") == disable) {
            if (!$pice->getPlayer()->hasPermission('servermanager.bypass')) {
                if(!$this->cfgm->get("Item Damage") == null) {
                    $pice->getPlayer()->sendMessage($prefix2 . " : " . str_replace("&", "§", $this->cfgm->get("Item Damage")));
                }
                    $pice->setCancelled();
            }
        }
    }
    public function onKick (PlayerKickEvent $pke){
        if ($this->cfg->get("Player Kicking") == false or $this->cfg->get("Player Kicking") == disable) {
            if (!$pke->getPlayer()->hasPermission('servermanager.bypass')) {
                if(!$this->cfgm->get("Player Kicking") == null) {
                    $pke->getPlayer()->sendMessage($prefix2 . " : " . str_replace("&", "§", $this->cfgm->get("Player Kick")));
                }
                $pke->setCancelled();
            }
        }
    }
    public function onToggleSneak (PlayerToggleSneakEvent $ptse){
        if ($this->cfg->get("Sneaking") == false or $this->cfg->get("Sneaking") == disable) {
            if (!$pre->getPlayer()->hasPermission('servermanager.bypass')) {
                if(!$this->cfgm->get("Sneaking") == null) {
                    $pre->getPlayer()->sendMessage($prefix2 . " : " . str_replace("&", "§", $this->cfgm->get("Sneaking")));
                }
                    $pre->setCancelled();
            }
        }
    }
    public function onAchievementAwarded (PlayerAchievementAwardedEvent $paae){
        if ($this->cfg->get("Achievements") == false or $this->cfg->get("Achievements") == disable) {
            if (!$paae->getPlayer()->hasPermission('servermanager.bypass')) {
                if(!$this->cfgm->get("Achievements") == null) {
                    $paae->getPlayer()->sendMessage($prefix2 . " : " . str_replace("&", "§", $this->cfgm->get("Achievements")));
                }
                $paae->setCancelled();
            }
        }
    }
    public function onExplosionsPrime (ExplosionPrimeEvent $epe){
        if ($this->cfg->get("Explosions") == false or $this->cfg->get("Explosions") == disable) {
            if (!$epe->getPlayer()->hasPermission('servermanager.bypass')) {
                if(!$this->cfgm->get("Explosions") == null) {
                    $epe->getPlayer()->sendMessage($prefix2 . " : " . str_replace("&", "§", $this->cfgm->get("Explosions")));
                }
                    $epe->setCancelled();
            }
        }
    }
    public function onOpen (InventoryOpenEvent $ioe){
        if ($this->cfg->get("Inventory Open") == false or $this->cfg->get("Inventory Open") == disable) {
            if (!$ioe->getPlayer()->hasPermission('servermanager.bypass')) {
                if(!$this->cfgm->get("Inventory Open") == null) {
                    $ioe->getPlayer()->sendMessage($prefix2 . " : " . str_replace("&", "§", $this->cfgm->get("Inventory Open")));
                }
                    $ioe->setCancelled();
            }
        }
    }
    public function onPickupItem (InventoryPickupItemEvent $ipie){
        if ($this->cfg->get("Item Pickup") == false or $this->cfg->get("Item Pickup") == disable) {
            if (!$ipie->getPlayer()->hasPermission('servermanager.bypass')) {
                if(!$this->cfgm->get("Item Pickup") == null) {
                    $ipie->getPlayer()->sendMessage($prefix2 . " : " . str_replace("&", "§", $this->cfgm->get("Item Pickup")));
                }
                    $ipie->setCancelled();
            }
        }
    }
    public function onCraftItem (CraftItemEvent $cie){
        if ($this->cfg->get("Item Crafting") == false or $this->cfg->get("Item Crafting") == disable) {
            if (!$cie->getPlayer()->hasPermission('servermanager.bypass')) {
                if(!$this->cfgm->get("Item Crafting") == null) {
                    $cie->getPlayer()->sendMessage($prefix2 . " : " . str_replace("&", "§", $this->cfgm->get("Item Crafting")));
                }
                $cie->setCancelled();
            }
        }
    }



    public function onDisable()
    {
        $this->getLogger()->info($prefix . SM::RED . "Has been disabled");
    }
}
