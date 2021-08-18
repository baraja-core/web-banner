<?php

declare(strict_types=1);

namespace Baraja\Banner\Entity;


use Baraja\Doctrine\Identifier\IdentifierUnsigned;
use Baraja\Localization\TranslateObject;
use Baraja\Localization\Translation;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'core__banner')]
class Banner
{
	use IdentifierUnsigned;
	use TranslateObject;

	#[ORM\Column(type: 'translate')]
	private Translation $name;

	#[ORM\Column(type: 'string', length: 64, unique: true)]
	private string $slug;

	#[ORM\Column(type: 'string', length: 16)]
	private string $type;

	#[ORM\Column(type: 'text', nullable: true)]
	private ?string $description = null;

	#[ORM\Column(type: 'boolean')]
	private bool $active = false;

	#[ORM\Column(type: 'integer')]
	private int $width;

	#[ORM\Column(type: 'integer')]
	private int $height;

	/** @var array<string, string|int|bool> */
	#[ORM\Column(type: 'json')]
	private array $meta = [];

	/** @var BannerItem[]|Collection */
	#[ORM\OneToMany(mappedBy: 'banner', targetEntity: BannerItem::class)]
	private $bannerItems;


	public function __construct(string $name, string $slug, string $type, int $width, int $height)
	{
		$this->name = $this->setName($name);
		$this->slug = $slug;
		$this->type = $type;
		$this->width = $width;
		$this->height = $height;
		$this->bannerItems = new ArrayCollection;
	}


	/**
	 * @return string|null
	 */
	public function getDescription(): ?string
	{
		return $this->description;
	}


	/**
	 * @param string|null $description
	 */
	public function setDescription(?string $description): void
	{
		$this->description = $description;
	}


	public function isActive(): bool
	{
		return $this->active;
	}


	public function setActive(bool $active): void
	{
		$this->active = $active;
	}


	/**
	 * @return array<string, string|int|bool>
	 */
	public function getMeta(): array
	{
		return $this->meta;
	}


	/**
	 * @param array<string, string|int|bool> $meta
	 */
	public function setMeta(array $meta): void
	{
		$this->meta = $meta;
	}
}
