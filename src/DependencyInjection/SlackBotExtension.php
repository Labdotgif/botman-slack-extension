<?php

declare(strict_types=1);

namespace Dividotlab\DependencyInjection;

use Dividotlab\Slack\Serializer\Normalizer\VerificationUrlNormalizer;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class SlackBotExtension extends Extension implements PrependExtensionInterface
{
    /**
     * @var string
     */
    private $oauthToken;

    /**
     * @var string
     */
    private $verificationUrlToken;

    public function __construct(string $oauthToken, string $verificationUrlToken)
    {
        $this->oauthToken           = $oauthToken;
        $this->verificationUrlToken = $verificationUrlToken;
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('bot.yaml');
        $loader->load('normalizers.yaml');

        $container->getDefinition(VerificationUrlNormalizer::class)
            ->setArgument(0, $configs[0]['slack.verification_url.token']);
    }

    public function prepend(ContainerBuilder $container)
    {
        // FIXME Should be in a configuration node, but it's time saving
        $container->prependExtensionConfig('slack_bot', [
            'slack.bot.oauth.token'        => $this->oauthToken,
            'slack.verification_url.token' => $this->verificationUrlToken,
        ]);
    }
}
