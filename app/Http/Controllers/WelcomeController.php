<?php

namespace App\Http\Controllers;

use App\Services\MediumService;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Fortify\Features;

class WelcomeController extends Controller
{
    public function __construct(private readonly MediumService $mediumService) {}

    public function __invoke(): Response
    {
        return Inertia::render('Welcome', [
            'canRegister' => Features::enabled(Features::registration()),
            'mediumPosts' => $this->mediumService->getPosts(),
        ]);
    }
}
