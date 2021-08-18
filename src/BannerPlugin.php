<?php

declare(strict_types=1);

namespace Baraja\Banner;


use Baraja\Plugin\BasePlugin;

final class BannerPlugin extends BasePlugin
{
	public function getName(): string
	{
		return 'Banner';
	}
}
