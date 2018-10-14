<?php

namespace App\Http\Controllers\Api\Clients;

use App\Jenisblog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogAPIController extends Controller
{
    public function loadBlogType()
    {
        $blogType = Jenisblog::all()->toArray();

        return $blogType;
    }
}
