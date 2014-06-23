<?php

namespace dooaki\Test;

use dooaki\AmazonWishlist\AmazonWishlist;

class AmazonWishlistTest extends \PHPUnit_Framework_TestCase {

    public function test()
    {
        $expect = [
        [
            'url' => 'http://www.amazon.co.jp/%E3%83%A4%E3%83%83%E3%83%9B%E3%83%BC%E3%83%96%E3%83%AB%E3%83%BC%E3%82%A4%E3%83%B3%E3%82%B0-%E3%82%A4%E3%83%B3%E3%83%89%E3%81%AE%E9%9D%92%E9%AC%BC-350ml-12%E7%BC%B6%E3%82%BB%E3%83%83%E3%83%88/dp/B00BB8XLDI/',
            'name' => 'インドの青鬼 350ml 12缶セット',
            'cart_url' => 'http://www.amazon.co.jp/gp/item-dispatch/',
            'price' => 3849,
            'wish' => 2,
            'received' => 1,
            'priority' => '低',
        ],
        [
            'url' => 'http://www.amazon.co.jp/%E3%82%88%E3%81%AA%E3%82%88%E3%81%AA%E3%82%A8%E3%83%BC%E3%83%AB-350ml-12%E7%BC%B6%E3%82%BB%E3%83%83%E3%83%88/dp/B00BB4QX46/',
            'name' => 'よなよなエール 350ml 12缶セット',
            'cart_url' => 'http://www.amazon.co.jp/gp/item-dispatch/',
            'price' => 3602,
            'wish' => 1,
            'received' => 0,
            'priority' => '中',
        ],
        [
            'url' => 'http://www.amazon.co.jp/%E6%B0%B4%E6%9B%9C%E6%97%A5%E3%81%AE%E3%83%8D%E3%82%B3-350ml-8%E7%BC%B6%E3%82%BB%E3%83%83%E3%83%88/dp/B00BB9K3M4/',
            'name' => '水曜日のネコ 350ml 8缶セット',
            'cart_url' => 'http://www.amazon.co.jp/gp/item-dispatch/',
            'price' => 2695,
            'wish' => 9999,
            'received' => 0,
            'priority' => '最高',
        ]

        ];

        $wishlist = new AmazonWishlist('2RBUW0RZIHB4L');
        $actual = $wishlist->export();

        $this->assertCount(count($expect), $actual);
        array_map(function($e, $a) {
            foreach ($e as $k => $v) {
                switch ($k) {
                    case 'url':
                    case 'cart_url':
                        $this->assertArrayHasKey($k, $a);
                        $this->assertStringStartsWith($v, $a[$k], $k);
                        break;
                    default:
                        $this->assertArrayHasKey($k, $a);
                        $this->assertSame($v, $a[$k], $k);
                }
            }
        }, $expect, $actual);
    }

}
