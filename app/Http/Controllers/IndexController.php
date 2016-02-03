<?php
/**
 * Created by PhpStorm.
 * User: hieunt
 * Date: 2/1/16
 * Time: 6:35 AM
 */
namespace App\Http\Controllers;

use Log;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    function test()
    {
        Log::info("test");
    }

    function test_post(Request $request)
    {
        Log::info(print_r($_POST, true));
    }
}