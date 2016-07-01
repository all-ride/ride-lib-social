<?php

namespace ride\library\social\generator;

use ride\library\social\SharedItem;

/**
 * Chain to generate meta tags for a page to share on different social media
 * platforms.
 */
class ChainMetaGenerator implements MetaGenerator {

    /**
     * Meta generators to chain
     * @var array
     */
    private $generators = array();

    /**
     * Adds an array of meta generators to this chain
     * @param array $metaGenerators
     * @return null
     */
    public function addMetaGenerators(array $metaGenerators) {
        foreach ($metaGenerators as $metaGenerator) {
            $this->addMetaGenerator($metaGenerator);
        }
    }

    /**
     * Adds a meta generator to this chain
     * @param MetaGenerator $metaGenerator
     * @return null
     */
    public function addMetaGenerator(MetaGenerator $metaGenerator) {
        $this->generators[] = $metaGenerator;
    }

    /**
     * Generates meta tags to share your page on a social media platform
     * @param \ride\library\html\share\SharedItem $sharedItem Item to share
     * @return array Meta tags to be used in the head of your HTML page
     */
    public function generateMeta(SharedItem $sharedItem) {
        $meta = array();

        foreach ($this->generators as $generator) {
            $meta = array_merge($meta, $generator->generateMeta($sharedItem));
        }

        return $meta;
    }

}
