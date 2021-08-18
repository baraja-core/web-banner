<?php

declare(strict_types=1);

namespace Baraja\Banner;


use Baraja\Doctrine\ORM\DI\OrmAnnotationsExtension;
use Baraja\Plugin\Component\VueComponent;
use Baraja\Plugin\PluginComponentExtension;
use Baraja\Plugin\PluginManager;
use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\ServiceDefinition;

class BannerExtension extends CompilerExtension
{
	/**
	 * @return string[]
	 */
	public static function mustBeDefinedBefore(): array
	{
		return [OrmAnnotationsExtension::class];
	}


	public function beforeCompile(): void
	{
		$builder = $this->getContainerBuilder();
		PluginComponentExtension::defineBasicServices($builder);
		OrmAnnotationsExtension::addAnnotationPathToManager($builder, 'Baraja\Banner', __DIR__ . '/Entity');

		$builder->addDefinition($this->prefix('bannerManager'))
			->setFactory(BannerManager::class);

		/** @var ServiceDefinition $pluginManager */
		$pluginManager = $this->getContainerBuilder()->getDefinitionByType(PluginManager::class);
		$pluginManager->addSetup(
			'?->addComponent(?)',
			[
				'@self',
				[
					'key' => 'Banner',
					'name' => 'cms-banner-default',
					'implements' => BannerPlugin::class,
					'componentClass' => VueComponent::class,
					'view' => 'default',
					'source' => __DIR__ . '/../templates/default.js',
					'position' => 100,
					'tab' => 'Banners',
				],
			]
		);
	}
}
