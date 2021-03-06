<?php
/**
 * This file defines the ApiExtension
 *
 * @category AppBundle
 * @package DependdencyInjection
 * @author Fondative <dev devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since File available since Release 1.0.0
 */
namespace AppBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Yaml\Parser;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
/**
 * Class AppExtension
 *
 * @package DependdencyInjection
 * @author Fondative <devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 */
class AppExtension extends Extension
{

    /**
     * {@inheritDoc}
     * @param $configs array Attribute
     * @param $container ContainerBuilder Container Build
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $patchFile = __DIR__ . '/../../../app/config/patch_format.yml';
        $container->setParameter('patch.format', $this->loadPatchFormat($patchFile));

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

    }

    /**
     * Load format to validate patch requests
     *
     * @author Fondative <devteam@fondative.com>
     * @param $filePath
     * @return array
     */
    public function loadPatchFormat($filePath)
    {
        $filePath = file_get_contents($filePath);
        $yaml = new Parser();
        $data = $yaml->parse($filePath);
        $format = array();
        if (is_array($data)) {
            foreach ($data as $name => $patch) {
                if (isset($patch['resource'])) {
                    $path = __DIR__ . '/../../' . $patch['resource'];
                    $format = array_merge($format, $this->loadPatchFormat($path));
                } else {
                    $format = array_merge($format, array($name => $patch));
                }
            }
        }
        return $format;
    }


}