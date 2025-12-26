<?php

namespace App\Http\Controllers\Api;

use App\Enums\ApplicationStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ApplicationStoreRequest;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function show(Request $request, Product $product): ApplicationResource
    {
        $application = Application::query()
            ->where('product_id', $product->id)
            ->where('user_id', $request->user()->id)
            ->latest()
            ->first();

        return ApplicationResource::make($application);
    }

    public function cancel(Request $request, Product $product): JsonResponse
    {
        $application = Application::query()
            ->where('product_id', $product->id)
            ->where('user_id', $request->user()->id)
            ->latest()
            ->firstOrFail();

        $application->update([
            'status' => ApplicationStatusEnum::CANCELED_BY_USER->value,
        ]);

        return response()->json([
            'message' => 'Заявка отменена.',
            'application' => ApplicationResource::make($application),
        ]);
    }

    public function store(ApplicationStoreRequest $request, Product $product): JsonResponse
    {
        $applicationList = Application::query()
            ->where('product_id', $product->id)
            ->where('status', ApplicationStatusEnum::ACTIVE->value)
            ->latest()
            ->exists();

        if ($applicationList) {
            abort(409, 'Товар уже используется в активной заявке');
        }

        $application = Application::create([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
            'status' => ApplicationStatusEnum::PENDING->value,
            'comment' => $request->input('comment'),
            'manager_note' => null,
            'amount' => $product->price,
            'is_paid' => false,
        ]);

        return response()->json([
            'message' => 'Заявка успешно отправлена.',
            'application' => ApplicationResource::make($application),
        ], 201);
    }
}
