# Ride: Social Library

Library of the PHP Ride framework to share data on social media.

## SharedItem

The _SharedItem_ class is used as a data container with the information to share. 

## SharedImage

A _SharedImage_ represents an image used by a shared item.
You can add multiple images to an item but the generator will decide if they are used.
The first added image will always be the main image.

## MetaGenerator

The _MetaGenerator_ interface is to be implemented for each metadata standard.
An implementation for DC, OG and Twitter are provided. 

## Code Sample

```php
<?php

use ride\library\social\generator\MetaGenerator;
use ride\library\social\SharedImage;
use ride\library\social\SharedItem;

function foo(MetaGenerator $metaGenerator) {
    $image1 = new SharedImage('http://my-url/image.jpg');
    $image2 = new SharedImage('http://my-url/image2.jpg', 'Some alt');
    
    $item = new SharedItem();
    $item->setTitle('title');
    $item->setDescription('desciption');
    $item->setUrl('http://my-url');
    $item->setLocale('nl_BE');
    $item->setDatePublished(time());
    $item->setCategory('some category');
    $item->setSiteName('My Site');
    $item->setProperty('custom property', 'value');
    
    $item->addImage($image1);
    $item->addImage($image2);
    
    return $metaGenerator->generateMeta($item);
}
```
