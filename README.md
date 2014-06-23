dooaki\amazon-wishlist
===============

[![Build Status](https://travis-ci.org/do-aki/amazon-wishlist.svg?branch=master)](https://travis-ci.org/do-aki/amazon-wishlist)

parse wishlist on amazon.co.jp

Requirements
-------------
* PHP 5.4 or later

Installation
-------------

you can install the script with [Composer](http://getcomposer.org/).

in your `composer.json` file:
```
{
    "require": {
        "dooaki/amazon-wishlist": "dev-master"
    }
}
```

```
composer.phar install
```

Usage
-------------
```php
<?php

use dooaki\AmazonWishlist\AmazonWishlist;

// http://www.amazon.co.jp/gp/wishlist/[wishlist_token]/
$wishlist = new AmazonWishlist('wishlist_token'); 

var_dump($wishlist->export());

```
