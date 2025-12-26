<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\ReviewResource;
use App\Models\Application;
use App\Models\Review;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function applications(Request $request): AnonymousResourceCollection
    {
        $applications = Application::query()
            ->where('user_id', $request->user()->id)
            ->with(['product.category'])
            ->latest()
            ->get();

        return ApplicationResource::collection($applications);
    }

    public function reviews(Request $request): AnonymousResourceCollection
    {
        $reviews = Review::query()
            ->where('user_id', $request->user()->id)
            ->with(['product.category'])
            ->latest()
            ->get();

        return ReviewResource::collection($reviews);
    }
}
