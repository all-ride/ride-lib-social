<?php

namespace ride\library\social\generator;

use ride\library\html\Meta;
use ride\library\social\SharedItem;

/**
 * Open graph implementation to generate meta tags for page sharing
 */
class OgMetaGenerator implements MetaGenerator {

    /**
     * Type for an article
     * @var string
     */
    const TYPE_ARTICLE = 'article';

    /**
     * Type for a website (default)
     * @var string
     */
    const TYPE_WEBSITE = 'website';

    /**
     * Default publisher of articles
     * @var string
     */
    private $publisher;

    /**
     * Sets the default publisher of articles, override with the
     * article:publisher property of your shared item
     * @param string $publisher Facebook page URL or ID of the publishing entity
     * @return null
     */
    public function setPublisher($publisher) {
        $this->publisher = $publisher;
    }

    /**
     * Gets the default publisher of articles
     * @return string|null
     */
    public function getPublisher() {
        return $this->publisher;
    }

    /**
     * Generates meta tags to share your page on a social media platform
     * @param \ride\library\html\share\SharedItem $sharedItem Item to share
     * @return array Meta tags to be used in the head of your HTML page
     */
    public function generateMeta(SharedItem $sharedItem) {
        $meta = array();

        $title = $sharedItem->getTitle();
        $url = $sharedItem->getUrl();
        $image = $sharedItem->getImage();

        if (!$title || !$url || !$image) {
            return $meta;
        }

        $description = $sharedItem->getDescription();
        $images = $sharedItem->getImages();
        $locale = $sharedItem->getLocale();
        $siteName = $sharedItem->getSiteName();

        $datePublished = $sharedItem->getDatePublished();
        $category = $sharedItem->getCategory();
        $authors = $sharedItem->getProperty('article:author');
        $publisher = $sharedItem->getProperty('article:publisher', $this->publisher);
        $tags = $sharedItem->getProperty('article:tag');

        if ($datePublished || $authors || $category || $publisher || $tags) {
            $type = self::TYPE_ARTICLE;
        } else {
            $type = self::TYPE_WEBSITE;
        }

        $meta[] = $this->createMeta('og:title', $title);
        if ($description) {
            $meta[] = $this->createMeta('og:description', $description);
        }
        $meta[] = $this->createMeta('og:url', $url);
        $meta[] = $this->createMeta('og:type', $type);

        if ($images) {
            foreach ($images as $image) {
                // @todo
                // $meta[] = $this->createMeta('og:image', $image->getUrl());
                // if ($image->getWidth()) {
                    // $meta[] = $this->createMeta('og:image:width', $image->getWidth());
                // }
                // if ($image->getHeight()) {
                    // $meta[] = $this->createMeta('og:image:height', $image->getHeight());
                // }
            }
        }

        if ($locale) {
            $meta[] = $this->createMeta('og:locale', $locale);
        }

        if ($siteName) {
            $meta[] = $this->createMeta('og:site_name', $siteName);
        }

        if ($type == self::TYPE_ARTICLE) {
            if ($authors) {
                if (!is_array($authors)) {
                    $authors = array($authors);
                }

                foreach ($authors as $author) {
                    $meta[] = $this->createMeta('article:author', $author);
                }
            }
            if ($datePublished) {
                $meta[] = $this->createMeta('article:published_time', date('c', $datePublished));
            }
            if ($publisher) {
                $meta[] = $this->createMeta('article:publisher', $publisher);
            }
            if ($category) {
                $meta[] = $this->createMeta('article:section', $category);
            }
            if ($tags) {
                if (!is_array($tags)) {
                    $tags = array($tags);
                }

                foreach ($tags as $tag) {
                    $meta[] = $this->createMeta('article:tag', $tag);
                }
            }
        }

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
        $meta->setProperty($name);
        $meta->setContent($value);

        return $meta;
    }

}
