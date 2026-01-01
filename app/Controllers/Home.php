<?php

namespace App\Controllers;

use App\Models\StoryAtmosphereModel;

class Home extends BaseController
{
    /**
     * Homepage
     */
    public function index()
    {
        return view('pages/home', [
            'is_logged_in' => session()->get('isLoggedIn')
        ]);
    }

    /**
     * Blog page
     */
    public function blog()
    {
        return view('pages/blog', [
            'is_logged_in' => session()->get('isLoggedIn')
        ]);
    }

    /**
     * Contact page
     */
    public function contact()
    {
        return view('pages/contact', [
            'is_logged_in' => session()->get('isLoggedIn')
        ]);
    }

    /**
     * Login page
     */
    public function login()
    {
        return view('auth/login', [
            'is_logged_in' => session()->get('isLoggedIn')
        ]);
    }

    /**
     * Dashboard (admin)
     */
    public function dashboard()
    {
        return view('admin/dashboard', [
            'is_logged_in' => session()->get('isLoggedIn')
        ]);
    }

    /**
     * About / Story page
     */
    public function about()
    {
        $atmoModel = new StoryAtmosphereModel();

        $atmospheres = $atmoModel->getAtmospheres();

        return view('pages/about', [
            'atmospheres' => $atmospheres,
            'is_logged_in' => session()->get('isLoggedIn')
        ]);
    }
}
