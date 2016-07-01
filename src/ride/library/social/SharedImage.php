<?php

namespace ride\library\social;

/**
 * Data container for an image of a shared item
 */
class SharedImage {

    /**
     * Source of the image, an URL or a path
     * @var string
     */
    private $source;

    /**
     * Alternative text for the image
     * @var string
     */
    private $alt;

    /**
     * Creates a new image
     * @param string $source Source of the image, an URL or a path
     * @param string $alt Alternative text for the image
     * @return null
     */
    public function __construct($source, $alt = null) {
        $this->source = $source;
        $this->alt = $alt;
    }

    /**
     * Gets the source
     * @return string
     */
    public function getSource() {
        return $this->source;
    }

    /**
     * Gets the alternative text of the image
     * @return string|null Alternative text if set, null otherwise
     */
    public function getAlt() {
        return $this->alt;
    }

}
