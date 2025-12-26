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
        $requestedStartDate = $request->date('rental_start_date')->toDateString();
        $requestedEndDate = $request->date('rental_end_date')->toDateString();

        $hasDateConflict = Application::query()
            ->where('product_id', $product->id)
            ->where('status', ApplicationStatusEnum::ACTIVE->value)
            ->where(function ($query) use ($requestedStartDate, $requestedEndDate) {
                $query
                    ->whereNull('rental_start_date')
                    ->orWhereNull('rental_end_date')
                    ->orWhere(function ($query) use ($requestedStartDate, $requestedEndDate) {
                        $query
                            ->whereDate('rental_start_date', '<=', $requestedEndDate)
                            ->whereDate('rental_end_date', '>=', $requestedStartDate);
                    });
            })
            ->exists();

        if ($hasDateConflict) {
            abort(409, 'Товар уже в аренде на выбранные даты');
        }

        $application = Application::create([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
            'status' => ApplicationStatusEnum::PENDING->value,
            'comment' => $request->input('comment'),
            'rental_start_date' => $requestedStartDate,
            'rental_end_date' => $requestedEndDate,
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
