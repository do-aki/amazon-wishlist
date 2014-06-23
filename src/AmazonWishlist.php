<?php

namespace dooaki\AmazonWishlist;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class AmazonWishlist {

  private $withlist_code;

  public function __construct($wishlist_code)
  {
    $this->wishlist_code = $wishlist_code;
  }

  public function export()
  {
    $page = 1;
    $last_content = null;
    $result = [];
    while(true) {
      $crawler = $this->_fetch($this->_makeUrl($page));
      $items = $crawler->filter('tbody[name^=item]');
      if ($items->text() === $last_content) {
        break;
      }

      $result = array_merge($result, $this->_parse($items));
      $last_content = $items->text();
    }

    return $result;
  }

  protected function _makeUrl($page_number)
  {
    return "http://www.amazon.co.jp/registry/wishlist/{$this->wishlist_code}/"
      . '?reveal=all&filter=all&sort=date-added&layout=compact'
      . "&page={$page_number}";
  }

  protected function _fetch($url)
  {
    $client = new Client();
    $res = $client->get($url);
    $content = (string)$res->getBody();

    $crawler = new Crawler();
    $crawler->addHtmlContent($content, 'SJIS-win');
    return $crawler;
  }

  protected function _parse(Crawler $items)
  {
    $parsed = array();
    $items->each(function ($item) use(&$parsed) {
        $r = [];

        $tr = $item->filter('tr')->last();

        $a = $tr->filter('.productTitle a')->first();
        $r['url'] = $a->attr('href');
        $r['name'] = $a->text();

        $td = $tr->filter('td');

        $cart_url = null;
        if (0 < $td->eq(1)->filter('a')->count()) {
          $cart_url = 'http://www.amazon.co.jp' . $td->eq(1)->filter('a')->attr('href');
        }

        $r['cart_url'] = $cart_url;
        $r['price'] = intval(preg_replace('/[^0-9]/', '', $td->filter('.price')->text()));
        $r['wish'] = intval($tr->filter('td')->eq(3)->text());
        $r['received'] = intval($tr->filter('td')->eq(4)->text());
        $r['priority'] = $tr->filter('td')->eq(5)->text();

        $parsed[]= $r;
    });

    return $parsed;
  }

}

