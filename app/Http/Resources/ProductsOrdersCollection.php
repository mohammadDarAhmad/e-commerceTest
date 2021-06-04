<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductsOrdersCollection extends ResourceCollection
{
    public $collects = ProductsOrdersResource::class;

}
