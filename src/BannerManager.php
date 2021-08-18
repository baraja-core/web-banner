<?php

declare(strict_types=1);

namespace Baraja\Banner;


use Baraja\Banner\Entity\Banner;
use Baraja\Doctrine\EntityManager;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

final class BannerManager
{
	public function __construct(
		private EntityManager $entityManager,
	) {
	}


	/**
	 * @throws NoResultException|NonUniqueResultException
	 */
	public function getBannerById(int $id): Banner
	{
		return $this->entityManager->getRepository(Banner::class)
			->createQueryBuilder('banner')
			->select('banner, bannerItem')
			->join('banner.bannerItems', 'bannerItem')
			->where('banner.id = :id')
			->setParameter('id', $id)
			->orderBy('bannerItem.position', 'DESC')
			->getQuery()
			->getSingleResult();
	}


	/**
	 * @throws NoResultException|NonUniqueResultException
	 */
	public function getBannerBySlug(string $slug): Banner
	{
		return $this->entityManager->getRepository(Banner::class)
			->createQueryBuilder('banner')
			->select('banner, bannerItem')
			->join('banner.bannerItems', 'bannerItem')
			->where('banner.slug = :slug')
			->setParameter('slug', $slug)
			->orderBy('bannerItem.position', 'DESC')
			->getQuery()
			->getSingleResult();
	}
}
