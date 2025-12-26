<?php

namespace App\Http\Controllers\Api;

use App\Enums\ApplicationStatusEnum;
use App\Enums\ReviewStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Reviews\StoreReviewRequest;
use App\Http\Requests\Api\ReviewStoreRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Application;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReviewController extends Controller
{
    public function index(Product $product): AnonymousResourceCollection
    {
        $reviews = Review::query()
            ->where('product_id', $product->id)
            ->where('status', ReviewStatusEnum::APPROVED->value)
            ->with('user')
            ->latest()
            ->get();

        return ReviewResource::collection($reviews);
    }

    public function store(ReviewStoreRequest $request, Product $product): JsonResponse
    {
        $user = $request->user();
        $application = Application::query()
            ->where('product_id', $product->id)
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        if (!$application || $application->status !== ApplicationStatusEnum::RETURNED) {
            return response()->json([
                'message' => 'Оставить отзыв можно только после готовой заявки.',
            ], 403);
        }

        $review = Review::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
            'status' => ReviewStatusEnum::PENDING->value,
        ]);

        return response()->json([
            'message' => 'Отзыв отправлен на модерацию.',
            'review' => ReviewResource::make($review->load('user')),
        ], 201);
    }
}
