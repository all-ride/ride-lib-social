<?php

namespace ride\library\social\generator;

use ride\library\html\Meta;
use ride\library\social\SharedItem;
use ride\library\StringHelper;

/**
 * Twitter implementation to generate meta tags for page sharing
 */
class TwitterMetaGenerator implements MetaGenerator {

    /**
     * Type of an application
     * @var string
     */
    const TYPE_APP = 'app';

    /**
     * Type of a player
     * @var string
     */
    const TYPE_PLAYER = 'player';

    /**
     * Type of a plain summary
     * @var string
     */
    const TYPE_SUMMARY = 'summary';

    /**
     * Type of a summary with large image
     * @var string
     */
    const TYPE_SUMMARY_LARGE_IMAGE = 'summary_large_image';

    /**
     * Default @username of the site
     * @var string
     */
    private $site;

    /**
     * Default Twitter user id of the site
     * @var string
     */
    private $siteId;

    /**
     * Default @username of the creator
     * @var string
     */
    private $creator;

    /**
     * Default Twitter user id of the creator
     * @var string
     */
    private $creatorId;

    /**
     * Sets the default @username of the site
     * @param string $site
     * @return null
     */
    public function setSite($site) {
        $this->site = $site;
    }

    /**
     * Sets the default @username of the site
     * @return string|null
     */
    public function getSite() {
        return $this->site;
    }

    /**
     * Sets the default Twitter user id of the site
     * @param string $siteId
     * @return null
     */
    public function setSiteId($siteId) {
        $this->siteId = $siteId;
    }

    /**
     * Gets the Twitter user id of the site
     * @return string|null
     */
    public function getSiteId() {
        return $this->siteId;
    }

    /**
     * Sets the @username of the creator
     * @param string $creator
     * @return null
     */
    public function setCreator($creator) {
        $this->creator = $creator;
    }

    /**
     * Gets the @username of the creator
     * @return string|null
     */
    public function getCreator() {
        return $this->creator;
    }

    /**
     * Sets the Twitter user id of the creator
     * @param string $creatorId
     * @return null
     */
    public function setCreatorId($creatorId) {
        $this->creatorId = $creatorId;
    }

    /**
     * Gets the Twitter user id of the creator
     * @return string|null
     */
    public function getCreatorId() {
        return $this->creatorId;
    }

    /**
     * Generates meta tags to share your page on a social media platform
     * @param \ride\library\social\SharedItem $sharedItem Item to share
     * @return array Meta tags to be used in the head of your HTML page
     */
    public function generateMeta(SharedItem $sharedItem) {
        $meta = array();

        $site = $sharedItem->getProperty('twitter:site', $this->site);
        $siteId = $sharedItem->getProperty('twitter:site:id', $this->siteId);
        $title = $sharedItem->getTitle();

        if ((!$site && !$siteId) || !$title) {
            return $meta;
        }

        $type = $sharedItem->getProperty('twitter:card', self::TYPE_SUMMARY_LARGE_IMAGE);
        $isSummary = $type == self::TYPE_SUMMARY || self::TYPE_SUMMARY_LARGE_IMAGE;
        $description = $sharedItem->getDescription();
        $image = $sharedItem->getImage();
        $creator = $sharedItem->getProperty('twitter:creator', $this->creator);
        $creatorId = $sharedItem->getProperty('twitter:creator:id', $this->creatorId);

        if ($site) {
            $meta[] = $this->createMeta('twitter:site', $site);
        } elseif ($siteId) {
            $meta[] = $this->createMeta('twitter:site:id', $siteId);
        }

        $meta[] = $this->createMeta('twitter:title', StringHelper::truncate($title, 70));
        if ($isSummary && $description) {
            $meta[] = $this->createMeta('twitter:description', StringHelper::truncate($description, 200));
        }

        // @todo
        // if ($image) {
            // $meta[] = $this->createMeta('twitter:image', $image->getUrl());
            // if ($image->getAlt()) {
                // $meta[] = $this->createMeta('twitter:image:alt', $image->getAlt());
            // }
        // }

        switch ($type) {
            case self::TYPE_SUMMARY_LARGE_IMAGE:
                if ($creator) {
                    $meta[] = $this->createMeta('twitter:creator', $creator);
                } elseif ($creatorId) {
                    $meta[] = $this->createMeta('twitter:creator:id', $creatorId);
                }

                break;
            case self::TYPE_PLAYER:
                $player = $sharedItem->getProperty('twitter:player');
                $stream = $sharedItem->getProperty('twitter:player:stream');
                $width = $sharedItem->getProperty('twitter:player:width');
                $height = $sharedItem->getProperty('twitter:player:height');

                if ($player && $stream) {
                    $meta[] = $this->createMeta('twitter:player', $player);
                    $meta[] = $this->createMeta('twitter:player:stream', $stream);
                    if ($width) {
                        $meta[] = $this->createMeta('twitter:player:width', $width);
                    }
                    if ($height) {
                        $meta[] = $this->createMeta('twitter:player:height', $height);
                    }
                }

                break;
            case self::TYPE_APP:
                $iphoneName = $sharedItem->getProperty('twitter:app:name:iphone');
                $iphoneId = $sharedItem->getProperty('twitter:app:id:iphone');
                $iphoneUrl = $sharedItem->getProperty('twitter:app:url:iphone');
                $ipadName = $sharedItem->getProperty('twitter:app:name:ipad');
                $ipadId = $sharedItem->getProperty('twitter:app:id:ipad');
                $ipadUrl = $sharedItem->getProperty('twitter:app:url:ipad');
                $androidName = $sharedItem->getProperty('twitter:app:name:googleplay');
                $androidId = $sharedItem->getProperty('twitter:app:id:googleplay');
                $androidUrl = $sharedItem->getProperty('twitter:app:url:googleplay');

                if ($iphoneName && $iphoneId && $iphoneUrl) {
                    $meta[] = $this->createMeta('twitter:app:name:iphone', $iphoneName);
                    $meta[] = $this->createMeta('twitter:app:id:iphone', $iphoneId);
                    $meta[] = $this->createMeta('twitter:app:url:iphone', $iphoneUrl);

                    if (!$ipadName && !$ipadId && !$ipadUrl) {
                        $meta[] = $this->createMeta('twitter:app:name:ipad', $iphoneName);
                        $meta[] = $this->createMeta('twitter:app:id:ipad', $iphoneId);
                        $meta[] = $this->createMeta('twitter:app:url:ipad', $iphoneUrl);
                    }
                }

                if ($ipadName && $ipadId && $ipadUrl) {
                    $meta[] = $this->createMeta('twitter:app:name:ipad', $ipadName);
                    $meta[] = $this->createMeta('twitter:app:id:ipad', $ipadId);
                    $meta[] = $this->createMeta('twitter:app:url:ipad', $ipadUrl);
                }

                if ($androidName && $androidId && $androidUrl) {
                    $meta[] = $this->createMeta('twitter:app:name:googleplay', $androidName);
                    $meta[] = $this->createMeta('twitter:app:id:googleplay', $androidId);
                    $meta[] = $this->createMeta('twitter:app:url:googleplay', $androidUrl);
                }

                break;
        }

        $meta[] = $this->createMeta('twitter:widgets:csp', 'on');

        return $meta;
    }

    /**
     * Creates a meta tag
     * @param string $name
     * @param string value
     * @return \ride\library\html\Meta
     */
    private function createMeta($name, $value) {
        $meta = new Meta();
        $meta->setName($name);
        $meta->setContent($value);

        return $meta;
    }

}
