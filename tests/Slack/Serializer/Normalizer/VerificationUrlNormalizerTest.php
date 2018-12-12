<?php

declare(strict_types=1);

namespace Dividotlab\Tests\Slack\Serializer\Normalizer;

use Dividotlab\Slack\Event\SlackEventInterface;
use Dividotlab\Slack\Event\VerificationUrlSlackEvent;
use Dividotlab\Slack\Serializer\Normalizer\VerificationUrlDenormalizer;
use PHPUnit\Framework\TestCase;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 *
 * @covers \Dividotlab\Slack\Serializer\Normalizer\VerificationUrlDenormalizer
 */
class VerificationUrlNormalizerTest extends TestCase
{
    /**
     * @test
     * @dataProvider supportsDenormalizationDataProvider
     */
    public function supportsDenormalization(bool $expectedReturn, array $data, string $type, string $format): void
    {
        $normalizer = new VerificationUrlDenormalizer('foo');

        $this->assertEquals($expectedReturn, $normalizer->supportsDenormalization($data, $type, $format));
    }

    public function supportsDenormalizationDataProvider(): \Generator
    {
        // Wrong class type
        yield [
            false,
            [
                'type' => 'url_verification'
            ],
            \stdClass::class,
            'json'
        ];

        // Wrong format
        yield [
            false,
            [
                'type' => 'url_verification'
            ],
            SlackEventInterface::class,
            'xml'
        ];

        // Wrong data
        yield [
            false,
            [
                'type' => 'foo'
            ],
            SlackEventInterface::class,
            'json'
        ];
        yield [
            false,
            [],
            SlackEventInterface::class,
            'json'
        ];

        // OK
        yield [
            true,
            [
                'type' => 'url_verification'
            ],
            SlackEventInterface::class,
            'json'
        ];
    }

    /**
     * @test
     */
    public function denormalize(): void
    {
        $normalizer = new VerificationUrlDenormalizer('foo');
        $event = $normalizer->denormalize(json_decode('{
            "token": "Jhj5dZrVaK7ZwHHjRyZWjbDl",
            "challenge": "3eZbrw1aBm2rZgRNFdxV2595E9CY3gmdALWMmHkvFXO7tYXAYM8P",
            "type": "url_verification"
        }', true), VerificationUrlSlackEvent::class, 'json');

        $this->assertInstanceOf(VerificationUrlSlackEvent::class, $event);
        $this->assertEquals('foo', $event->getSlackVerificationToken());
    }
}
