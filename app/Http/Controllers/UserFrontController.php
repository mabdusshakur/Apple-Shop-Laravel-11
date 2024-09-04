<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class UserFrontController extends Controller
{
    function homePage(): View
    {
        return view('user.pages.home-page');
    }

    function loginPage(): View
    {
        return view('user.pages.login-page');
    }

    function verifyOtpPage(): View
    {
        return view('user.pages.verify-page');
    }

    function profilePage(): View
    {
        return view('user.pages.profile-page');
    }

    function wishListPage(): View
    {
        return view('user.pages.wish-list-page');
    }
    function cartListPage(): View
    {
        return view('user.pages.cart-list-page');
    }

    function productDetailsPage(): View
    {
        return view('user.pages.details-page');
    }
    function policyPage(): View
    {
        return view('user.pages.policy-page');
    }
    function productByBrandPage(): View
    {
        return view('user.pages.product-by-brand-page');
    }
    function productByCategoryPage(): View
    {
        return view('user.pages.product-by-category-page');
    }

}