<?php

declare(strict_types=1);

namespace Baraja\Banner\Entity;


use Baraja\Doctrine\Identifier\Identifier;
use Baraja\Localization\TranslateObject;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'core__banner_item')]
class BannerItem
{
	use Identifier;
	use TranslateObject;

	#[ORM\ManyToOne(targetEntity: Banner::class, inversedBy: 'bannerItems')]
	private Banner $banner_id;

	#[ORM\Column(type: 'text', nullable: true)]
	private ?string $mediaSource;

	#[ORM\Column(type: 'text', nullable: true)]
	private ?string $message;

	#[ORM\Column(type: 'int')]
	private int $position = 0;

	#[ORM\Column(type: 'boolean')]
	private bool $active = false;

	#[ORM\Column(type: 'text', nullable: true)]
	private ?string $link;
}
