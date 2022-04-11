<?php

declare(strict_types=1);

namespace Baraja\Banner\Entity;


use Baraja\Doctrine\Identifier\IdentifierUnsigned;
use Baraja\Localization\TranslateObject;
use Baraja\Localization\Translation;
use Doctrine\ORM\Mapping as ORM;

/**
 * @method Translation getMessage(?string $locale = null)
 * @method void setMessage(string $message, ?string $locale = null)
 */
#[ORM\Entity]
#[ORM\Table(name: 'core__banner_item')]
class BannerItem
{
	use IdentifierUnsigned;
	use TranslateObject;

	#[ORM\Column(type: 'translate', nullable: true)]
	protected ?Translation $message = null;

	#[ORM\ManyToOne(targetEntity: Banner::class, inversedBy: 'bannerItems')]
	private Banner $banner;

	#[ORM\Column(type: 'text', nullable: true)]
	private ?string $mediaSource;

	#[ORM\Column(type: 'integer')]
	private int $position = 0;

	#[ORM\Column(type: 'boolean')]
	private bool $active = false;

	#[ORM\Column(type: 'text', nullable: true)]
	private ?string $link = null;


	public function __construct(Banner $banner, ?string $mediaSource = null, ?string $message = null)
	{
		$this->banner = $banner;
		$this->mediaSource = $mediaSource;
		if ($message !== null) {
			$this->setMessage($message);
		}
	}


	public function getBanner(): Banner
	{
		return $this->banner;
	}


	public function getMediaSource(): ?string
	{
		return $this->mediaSource;
	}


	public function setMediaSource(?string $mediaSource): void
	{
		$this->mediaSource = $mediaSource;
	}


	public function getPosition(): int
	{
		return $this->position;
	}


	public function setPosition(int $position): void
	{
		$this->position = $position;
	}


	public function isActive(): bool
	{
		return $this->active;
	}


	public function setActive(bool $active): void
	{
		$this->active = $active;
	}


	public function getLink(): ?string
	{
		return $this->link;
	}


	public function setLink(?string $link): void
	{
		$this->link = $link;
	}
}
