<?php

namespace Tests\Unit;

use App\Http\Controllers\Frontend\CheckoutController;
use App\Models\Product;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CheckoutControllerTest extends TestCase
{
    #[Test]
    public function it_calculates_vendor_commission_and_earning_values_from_the_product_percentage(): void
    {
        $controller = new CheckoutController();

        $product = new Product();
        $product->vendor_id = 7;
        $product->vendor_percentage = 12.5;

        $item = new \stdClass();
        $item->product = $product;
        $item->quantity = 2;
        $item->price = 100;

        $method = new \ReflectionMethod(CheckoutController::class, 'buildVendorItemData');
        $method->setAccessible(true);
        $result = $method->invoke($controller, $item);

        $this->assertSame(7, $result['vendor_id']);
        $this->assertSame(12.5, $result['vendor_percentage']);
        $this->assertSame(25.0, $result['vendor_commission_amount']);
        $this->assertSame(175.0, $result['vendor_earning_amount']);
    }
}
