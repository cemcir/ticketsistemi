<?php

namespace App\Http\Controllers\Web\Frontend;

use App\Business\Abstract\IProductService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductsController extends Controller
{
    private IProductService $productService;

    function __construct(IProductService $productService)
    {
        $this->productService = $productService;
    }

    public function GetByCategoryLink(string $link):View
    {
        $data = $this->productService->GetByCategoryLink($link)->Data();
        return view('frontend.product.getall',compact('data'));
    }

}
