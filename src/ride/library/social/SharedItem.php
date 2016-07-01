<?php

namespace ride\library\social;

/**
 * Data container for a shared item
 */
class SharedItem {

    /**
     * Property for the category
     * @var string
     */
    const PROPERTY_CATEGORY = 'category';

    /**
     * Property for the publication date
     * @var string
     */
    const PROPERTY_DATE_PUBLISHED = 'date.published';

    /**
     * Property for the description
     * @var string
     */
    const PROPERTY_DESCRIPTION = 'description';

    /**
     * Property for the images
     * @var string
     */
    const PROPERTY_IMAGES = 'images';

    /**
     * Property for the locale
     * @var string
     */
    const PROPERTY_LOCALE = 'locale';

    /**
     * Property for the title
     * @var string
     */
    const PROPERTY_TITLE = 'title';

    /**
     * Property for the URL to the content
     * @var string
     */
    const PROPERTY_URL = 'url';

    /**
     * Property for the site name
     * @var string
     */
    const PROPERTY_SITE_NAME = 'site.name';

    /**
     * Properties of this item
     * @var array
     */
    private $properties = array();

    /**
     * Sets the title of the item
     * @param string $title
     * @return null
     */
    public function setTitle($title) {
        $this->setProperty(self::PROPERTY_TITLE, $title);
    }

    /**
     * Gets the title of the item
     * @return string|null
     */
    public function getTitle() {
        return $this->getProperty(self::PROPERTY_TITLE);
    }

    /**
     * Sets the description of the item
     * @param string $description
     * @return null
     */
    public function setDescription($description) {
        $this->setProperty(self::PROPERTY_DESCRIPTION, $description);
    }

    /**
     * Gets the description of the item
     * @return string|null
     */
    public function getDescription() {
        return $this->getProperty(self::PROPERTY_DESCRIPTION);
    }

    /**
     * Adds an image
     * @param SharedImage $image Data of the image
     * @return null
     */
    public function addImage(SharedImage $image) {
        $images = $this->getImages();
        $images[] = $image;

        $this->setProperty(self::PROPERTY_IMAGES, $images);
    }

    /**
     * Gets all the images
     * @return array Array with SharedImage instances
     */
    public function getImages() {
        return $this->getProperty(self::PROPERTY_IMAGES, array());
    }

    /**
     * Gets the first image
     * @return SharedImage|null
     */
    public function getImage() {
        $images = $this->getProperty(self::PROPERTY_IMAGES, array());
        if (!$images) {
            return null;
        }

        $image = array_shift($images);

        return $image;
    }

    /**
     * Sets the URL
     * @param string $url URL to the shared item
     * @return null
     */
    public function setUrl($url) {
        $this->setProperty(self::PROPERTY_URL, $url);
    }

    /**
     * Gets the URL of the shared item
     * @return string|null URL of the shared item if set, null otherwise
     */
    public function getUrl() {
        return $this->getProperty(self::PROPERTY_URL);
    }

    /**
     * Sets the locale
     * @param string $locale Code of the locale
     * @return null
     */
    public function setLocale($locale) {
        $this->setProperty(self::PROPERTY_LOCALE, $locale);
    }

    /**
     * Gets the locale of the item
     * @return string|null Code of the locale if set, null otherwise
     */
    public function getLocale() {
        return $this->getProperty(self::PROPERTY_LOCALE);
    }

    /**
     * Sets the publication date of the shared item
     * @param integer $date Timestamp of the date
     * @return null
     */
    public function setDatePublished($date) {
        $this->setProperty(self::PROPERTY_DATE_PUBLISHED, $date);
    }

    /**
     * Gets the publication date of the item
     * @return integer|null Timestamp of the date if set, null otherwise
     */
    public function getDatePublished() {
        return $this->getProperty(self::PROPERTY_DATE_PUBLISHED);
    }

    /**
     * Sets the category opf the shared item
     * @param string $category Name of the category
     * @return null
     */
    public function setCategory($category) {
        $this->setProperty(self::PROPERTY_CATEGORY, $category);
    }

    /**
     * Gets the category
     * @return string Category if set, null otherwise
     */
    public function getCategory() {
        return $this->getProperty(self::PROPERTY_CATEGORY);
    }

    /**
     * Sets the site hosting the shared item
     * @param string $name Name of the site
     * @return null
     */
    public function setSiteName($name) {
        $this->setProperty(self::PROPERTY_SITE_NAME, $name);
    }

    /**
     * Gets the name of the site
     * @return string|null
     */
    public function getSiteName() {
        return $this->getProperty(self::PROPERTY_SITE_NAME);
    }

    /**
     * Sets a share property
     * @param string $name Name of the property
     * @param mixed $value Value of the property
     * @return null
     */
    public function setProperty($name, $value) {
        if ($value !== null) {
            $this->properties[$name] = $value;
        } elseif (isset($this->properties[$name])) {
            unset($this->properties[$name]);
        }
    }

    /**
     * Gets a share property
     * @param string $name Name of the property
     * @param mixed $default Default value for the property
     * @return mixed
     */
    public function getProperty($name, $default = null) {
        if (!isset($this->properties[$name])) {
            return $default;
        }

        return $this->properties[$name];
    }

}

