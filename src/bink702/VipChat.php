<?php

declare(strict_types=1);

namespace bink702;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerChatEvent;

class VipChat extends PluginBase implements Listener{

    public $VChat = [];

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("by §3bink702");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {

        switch ($command->getName()) {
            case "vc":
            case "vipchat":
                if ($sender instanceof Player) {
                    if ($sender->hasPermission("vc.use")) {
                        if (!isset($args[0])) {
                            $sender->sendMessage("§l§7[§3VipChat§7] /vc on|off");
                            $sender->sendMessage("§l§7[§3VipChat§7] /vipchat on|off");
                            return true;
                        }
                        $arg = array_shift($args);
                        switch ($arg) {
                            case "on":
                                $this->VChat[$sender->getName()] = $sender->getName();
                                $sender->sendMessage("§l§7[§3VipChat§7] §2Kamu masuk obrolan VIP");
                                break;
                            case "off":
                                unset($this->VChat[$sender->getName()]);
                                $sender->sendMessage("§l§7[§3VipChat§7] §4Kamu keluar dari obrolan VIP");
                                break;
                        }
                    }
                }else{
                    $this->getLogger()->info("Hanya Dapat Digunakan Dlam Game");
                }
            break;
        }
        return true;
    }

    public function onChat(PlayerChatEvent $event){
        $player = $event->getPlayer();
        $p = $this->getServer()->getOnlinePlayers();
        if(isset($this->VChat[$player->getName()])){
            foreach ($p as $pl){
                if($pl->hasPermission('vc.use')){
                    $event->setCancelled();
                    $pl->sendMessage("§l§7[§3VipChat§7] §6♔§b". $player->getName() ."  §4>§6>§a> §r§6" . $event->getMessage());
                    $this->getLogger()->info("§l§7[§3VipChat§7] §6♔§b". $player->getName() ."  §4>§6>§a> §r§6" . $event->getMessage());;
                }
            }
        }
    }

}
