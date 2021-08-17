<?php

declare(strict_types=1);

namespace Baraja\Banner\Entity;


use Baraja\Doctrine\Identifier\IdentifierUnsigned;
use Baraja\Localization\TranslateObject;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'core__banner_item')]
class BannerItem
{
	use IdentifierUnsigned;
	use TranslateObject;

	#[ORM\ManyToOne(targetEntity: Banner::class, inversedBy: 'bannerItems')]
	private Banner $banner;

	#[ORM\Column(type: 'text', nullable: true)]
	private ?string $mediaSource = null;

	#[ORM\Column(type: 'text', nullable: true)]
	private ?string $message = null;

	#[ORM\Column(type: 'integer')]
	private int $position = 0;

	#[ORM\Column(type: 'boolean')]
	private bool $active = false;

	#[ORM\Column(type: 'text', nullable: true)]
	private ?string $link = null;
}
