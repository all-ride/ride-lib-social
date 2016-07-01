<?php

namespace ride\library\social\generator;

use ride\library\social\SharedItem;

/**
 * Interface to generate meta tags for a page to share on a social media
 * platform.
 */
interface MetaGenerator {

    /**
     * Generates meta tags to share your page on a social media platform
     * @param \ride\library\html\share\SharedItem $sharedItem Item to share
     * @return array Meta tags to be used in the head of your HTML page
     */
    public function generateMeta(SharedItem $sharedItem);

}
