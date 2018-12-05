<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Bot;

use BotMan\BotMan\Cache\ArrayCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Http\Curl;
use BotMan\BotMan\Interfaces\CacheInterface;
use BotMan\BotMan\Interfaces\StorageInterface;
use BotMan\BotMan\Storages\Drivers\FileStorage;
use Dividotlab\Slack\Bot\Driver\SlackDriver;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class BotFactory
{
    /**
     * @var string
     */
    private $botOauthToken;

    public function __construct(string $botOauthToken)
    {
        $this->botOauthToken = $botOauthToken;
    }

    public function create(
        array $config = [],
        CacheInterface $cache = null,
        Request $request = null,
        StorageInterface $storageDriver = null
    ) {
        $config = array_merge_recursive($config, [
            'slack' => [
                'token' => $this->botOauthToken
            ]
        ]);

        if (empty($cache)) {
            $cache = new ArrayCache();
        }

        if (empty($request)) {
            $request = Request::createFromGlobals();
        }

        if (empty($storageDriver)) {
            $storageDriver = new FileStorage(__DIR__);
        }

        DriverManager::loadDriver(SlackDriver::class);

        $driverManager = new DriverManager($config, new Curl());
        $driver = $driverManager->getMatchingDriver($request);

        return new BotMan($cache, $driver, $config, $storageDriver);
    }

}
