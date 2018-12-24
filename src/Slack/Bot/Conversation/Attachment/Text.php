<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Bot\Conversation\Attachment;

use BotMan\BotMan\Interfaces\WebAccess;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class Text implements WebAccess
{
    const COLOR_SUCCESS = '#28a745';
    const COLOR_ERROR   = '#dc3545';
    const COLOR_INFO    = '#007bff';
    const COLOR_WARNING = '#ffc107';

    /**
     * @var array
     */
    private $parameters = [];

    public static function create(): self
    {
        return new static;
    }

    public function setColor(string $color): self
    {
        return $this->setParameter('color', $color);
    }

    public function setTitle(string $title): self
    {
        return $this->setParameter('title', $title);
    }

    public function setUrl(string $url): self
    {
        return $this->setParameter('title_link', $url);
    }

    public function setPreText(string $text): self
    {
        return $this->setParameter('pretext', $text);
    }

    public function setAuthorName(string $authorName): self
    {
        return $this->setParameter('author_name', $authorName);
    }

    public function setAuthorLink(string $authorLink): self
    {
        return $this->setParameter('author_link', $authorLink);
    }

    public function setAuthorIcon(string $authorIcon): self
    {
        return $this->setParameter('author_icon', $authorIcon);
    }

    public function setText(string $text): self
    {
        return $this->setParameter('text', $text);
    }

    public function setImageUrl(string $imageUrl): self
    {
        return $this->setParameter('image_url', $imageUrl);
    }

    public function setThumbUrl(string $thumbUrl): self
    {
        return $this->setParameter('thumb_url', $thumbUrl);
    }

    public function setFooter(string $footer): self
    {
        return $this->setParameter('footer', $footer);
    }

    public function setFallback(string $fallback): self
    {
        return $this->setParameter('fallback', $fallback);
    }

    public function setFooterIcon(string $footerIcon): self
    {
        return $this->setParameter('footer_icon', $footerIcon);
    }

    public function setFooterDate(\DateTime $date): self
    {
        return $this->setParameter('ts', $date->getTimestamp());
    }

    /**
     * @param string     $name
     * @param string|int $value
     *
     * @return Text
     */
    protected function setParameter(string $name, $value): self
    {
        $this->parameters[$name] = $value;

        return $this;
    }

    public function toWebDriver(): array
    {
        return $this->parameters;
    }
}
