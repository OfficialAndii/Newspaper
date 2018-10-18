<?php

/*
 *
 * Newspaper
 *
 * Copyright © 2018 Johnmacrocraft
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 */

namespace Johnmacrocraft\Newspaper\forms;

use Johnmacrocraft\Newspaper\Newspaper;
use pocketmine\form\MenuForm;
use pocketmine\form\MenuOption;
use pocketmine\lang\BaseLang;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class MySubscriptionInfoForm extends MenuForm {

	/** @var string */
	private $name;
	/** @var BaseLang */
	private $lang;

	public function __construct(string $player, string $name, BaseLang $lang) {
		$this->lang = $lang;
		parent::__construct($this->lang->translateString("gui.subinfo.title"), $this->lang->translateString("gui.subinfo.label", [Newspaper::getPlugin()->getSubscription($player, $name)["subscribeUntil"]]), [new MenuOption($this->lang->translateString("gui.subinfo.button.unsub"))]);
		$this->name = $name;
	}

	public function onSubmit(Player $player, int $selectedOption) : void {
		if(!Newspaper::getPlugin()->badPerm($player, "gui.subscriptions.unsubscribe", "gui.subinfo.perm.unsub")) {
			($subscriptions = Newspaper::getPlugin()->getPlayerData($player->getName()))->removeNested("subscriptions." . $this->name);
			$subscriptions->save();
			$player->sendMessage(TextFormat::GREEN . $this->lang->translateString("gui.subinfo.success.unsub"));
		}
	}
}