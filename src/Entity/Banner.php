<?php

declare(strict_types=1);

namespace Baraja\Banner\Entity;


use Baraja\Doctrine\Identifier\IdentifierUnsigned;
use Baraja\Localization\TranslateObject;
use Baraja\Localization\Translation;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nette\Utils\Strings;

/**
 * @method Translation getName(?string $locale = null)
 * @method void setName(string $message, ?string $locale = null)
 * @method Translation getDescription(?string $locale = null)
 * @method void setDescription(string $message, ?string $locale = null)
 */
#[ORM\Entity]
#[ORM\Table(name: 'core__banner')]
class Banner
{
	use IdentifierUnsigned;
	use TranslateObject;

	#[ORM\Column(type: 'translate')]
	protected Translation $name;

	#[ORM\Column(type: 'translate', nullable: true)]
	protected ?Translation $description = null;

	#[ORM\Column(type: 'string', length: 64, unique: true)]
	private string $slug;

	#[ORM\Column(type: 'string', length: 16)]
	private string $type;

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
		$this->setName($name);
		$this->setSlug($slug);
		$this->setType($type);
		$this->setWidth($width);
		$this->setHeight($height);
		$this->bannerItems = new ArrayCollection;
	}


	public function getSlug(): string
	{
		return $this->slug;
	}


	public function setSlug(string $slug): void
	{
		$this->slug = Strings::webalize($slug);
	}


	public function getType(): string
	{
		return $this->type;
	}


	public function setType(string $type): void
	{
		$this->type = $type;
	}


	public function getWidth(): int
	{
		return $this->width;
	}


	public function setWidth(int $width): void
	{
		if ($width < 1) {
			throw new \InvalidArgumentException('Width must be positive number.');
		}

		$this->width = $width;
	}


	public function getHeight(): int
	{
		return $this->height;
	}


	public function setHeight(int $height): void
	{
		if ($height < 1) {
			throw new \InvalidArgumentException('Height must be positive number.');
		}

		$this->height = $height;
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


	/**
	 * @return BannerItem[]|Collection
	 */
	public function getBannerItems()
	{
		return $this->bannerItems;
	}
}
