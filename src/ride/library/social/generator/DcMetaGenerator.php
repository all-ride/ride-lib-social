<?php

namespace ride\library\social\generator;

use ride\library\html\Meta;
use ride\library\social\SharedItem;

/**
 * Dublin Core implementation to generate meta tags for page sharing
 */
class DcMetaGenerator implements MetaGenerator {

    /**
     * Generates meta tags to share your page on a social media platform
     * @param \ride\library\html\share\SharedItem $sharedItem Item to share
     * @return array Meta tags to be used in the head of your HTML page
     */
    public function generateMeta(SharedItem $sharedItem) {
        $meta = array();

        if ($sharedItem->getTitle()) {
            $meta[] = $this->createMeta('dc.title', $sharedItem->getTitle());
        }

        if ($sharedItem->getDescription()) {
            $meta[] = $this->createMeta('dc.description', $sharedItem->getDescription());
        }

        if ($sharedItem->getLocale()) {
            $meta[] = $this->createMeta('dc.language', str_replace('_', '-', $sharedItem->getLocale()), 'RFC1766');
        }

        if ($sharedItem->getDatePublished()) {
            $meta[] = $this->createMeta('dc.date', date('c', $sharedItem->getDatePublished()), 'W3CDTF');
        }

        if ($sharedItem->getCategory()) {
            $meta[] = $this->createMeta('dc.subject', $sharedItem->getCategory());
        }

        if ($sharedItem->getSiteName()) {
            $meta[] = $this->createMeta('dc.publisher', $sharedItem->getSiteName());
        }

        return $meta;
    }

    /**
     * Creates a meta tag
     * @param string $name
     * @param string value
     * @return \ride\library\html\Meta
     */
    private function createMeta($name, $value, $scheme = null) {
        $meta = new Meta();
        $meta->setName($name);
        $meta->setContent($value);

        if ($scheme) {
            $meta->setAttribute('scheme', $scheme);
        }

        return $meta;
    }

}
