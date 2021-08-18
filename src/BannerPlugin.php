<?php

declare(strict_types=1);

namespace Baraja\Banner;


use Baraja\Plugin\BasePlugin;

class BannerPlugin extends BasePlugin
{
	public function __construct()
	{
	}


	public function getName(): string
	{
		return 'Banner';
	}
}
