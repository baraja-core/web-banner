<?php

declare(strict_types=1);

namespace Baraja\Banner;


use Baraja\Banner\Entity\Banner;
use Baraja\Doctrine\EntityManager;
use Baraja\StructuredApi\BaseEndpoint;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

final class BannerEndpoint extends BaseEndpoint
{
	public function __construct(
		private EntityManager $entityManager,
		private BannerManager $bannerManager,
	) {
	}


	public function actionDefault(): void
	{
		/** @var Banner[] $banners */
		$banners = $this->entityManager->getRepository(Banner::class)
			->createQueryBuilder('banner')
			->select('banner, bannerItem')
			->join('banner.bannerItems', 'bannerItem')
			->orderBy('bannerItem.position', 'DESC')
			->getQuery()
			->getResult();

		$return = [];
		foreach ($banners as $banner) {
			$return[] = [
				'id' => $banner->getId(),
				'name' => (string) $banner->getName(),
				'slug' => $banner->getSlug(),
				'type' => $banner->getType(),
				'description' => (string) $banner->getDescription(),
				'active' => $banner->isActive(),
				'width' => $banner->getWidth(),
				'height' => $banner->getHeight(),
				'meta' => $banner->getMeta(),
				'bannerItems' => $banner->getBannerItems(),
			];
		}

		$this->sendJson(
			[
				'items' => $return,
			]
		);
	}


	public function postCreateBanner(string $name, string $slug, string $type, int $width, int $height): void
	{
		if (!$name || !$slug || !$type || !$width || !$height) {
			$this->sendError('Please enter all fields.');
		}

		$banner = new Banner($name, $slug, $type, $width, $height);
		$this->entityManager->persist($banner);
		$this->entityManager->flush();
		$this->flashMessage('Banner has been created.', self::FLASH_MESSAGE_SUCCESS);
		$this->sendOk(
			[
				'id' => $banner->getId(),
			]
		);
	}


	public function actionOverview(int $id): void
	{
		try {
			$banner = $this->bannerManager->getBannerById($id);
		} catch (NoResultException | NonUniqueResultException) {
			$this->sendError('Banner "' . $id . '" does not exist.');
		}

		$this->sendJson(
			[
				'id' => $banner->getId(),
				'name' => (string) $banner->getName(),
				'slug' => $banner->getSlug(),
				'type' => $banner->getType(),
				'description' => (string) $banner->getDescription(),
				'active' => $banner->isActive(),
				'width' => $banner->getWidth(),
				'height' => $banner->getHeight(),
				'meta' => $banner->getMeta(),
				'bannerItems' => $banner->getBannerItems(),
			]
		);
	}
}
