<?php

namespace Tests\Unit;

use App\Product;
use PHPUnit\Framework\TestCase;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductTest extends TestCase
{

    
  private $product;

  public function setUp(): void

  {
    parent::setUp();
    parent::tearDown();

    $this->product = new Product();

    $this->product->category = 'Tshirt';
    $this->product->price_ht = 1.20;

  }

   public function testCategory()
   {
      $this->assertEquals('Tshirt', $this->product->category);
   }

   public function testName()
   {
      $this->assertNull($this->product->name);
   }

   public function testPrice()
   {
      $this->assertEquals(1.20, $this->product->price_ht);
   }
}
