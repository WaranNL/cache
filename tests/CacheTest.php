<?php
namespace Waran\Tests;

use Waran\Cache;

class CacheTest extends \PHPUnit_Framework_TestCase
{
    protected $name = 'html';
    protected $data = ['name' => 'Bryse'];
    protected $productID = '123456';

    public function testWrite()
    {
      $cache = new Cache;
      $this->assertTrue($cache->write($this->file(), $this->data, ['type' => 'json']));
    }

    public function testRead()
    {
        $cache = new Cache;
        $this->assertEquals($this->data, $cache->read($this->file(), null, ['type' => 'json']));
    }
  
    public function testExists()
    {
        $cache = new Cache;
        $this->assertEquals(true, $cache->exists($this->file()));
    }

    public function file()
    {
        return $this->productID.'/'.$this->name;
    }
}

