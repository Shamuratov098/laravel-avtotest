<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

abstract class Controller extends BaseController
{
    /**
     * Share data that is common to all admin views.
     */
    protected function shareCommonData(): void
    {
        view()->share('appName', config('app.name', 'E-Commerce Admin'));
    }

    /**
     * Return a success redirect response with flash message.
     */
    protected function success(string $route, string $message): RedirectResponse
    {
        return redirect()->route($route)->with('success', $message);
    }

    /**
     * Return a success redirect back response with flash message.
     */
    protected function successBack(string $message): RedirectResponse
    {
        return redirect()->back()->with('success', $message);
    }

    /**
     * Return an error redirect response with flash message.
     */
    protected function error(string $route, string $message): RedirectResponse
    {
        return redirect()->route($route)->with('error', $message);
    }

    /**
     * Return an error redirect back response with flash message.
     */
    protected function errorBack(string $message): RedirectResponse
    {
        return redirect()->back()->with('error', $message);
    }

    /**
     * Render admin view with shared layout.
     */
    protected function view(string $view, array $data = []): View
    {
        return view('admin.' . $view, $data);
    }
}
