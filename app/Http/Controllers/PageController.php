<?php

namespace App\Http\Controllers;

use App\Models\DeliveryPartner;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function deliveryPartners()
    {
        $partners = DeliveryPartner::active()->get();
        return view('pages.delivery-partners', compact('partners'));
    }
}
