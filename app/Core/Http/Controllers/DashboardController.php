<?php

namespace App\Core\Http\Controllers;

use App\Core\Enums\OrderStatus;
use App\Core\Models\Currency;
use App\Core\Models\Language;
use App\Modules\Payments\Enums\PaymentStatusEnum;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the authenticated user's dashboard.
     */
    public function __invoke(Request $request)
    {
        $user = $request->user()->fresh()->loadMissing(['currency']);

        $twoFactorEnabled = $user->hasEnabledTwoFactorAuthentication();
        $emailVerified = (bool) $user->email_verified_at;

        $orderStatusCounts = $user->orders()
            ->selectRaw('status, COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $ordersPending = (int) ($orderStatusCounts[OrderStatus::PENDING->value] ?? 0);
        $ordersProcessing = (int) ($orderStatusCounts[OrderStatus::PROCESSING->value] ?? 0);
        $ordersCompleted = (int) ($orderStatusCounts[OrderStatus::COMPLETED->value] ?? 0);
        $ordersCancelled = (int) ($orderStatusCounts[OrderStatus::CANCELLED->value] ?? 0);
        $ordersRefunded = (int) ($orderStatusCounts[OrderStatus::REFUNDED->value] ?? 0);

        $ordersTotal = (int) $orderStatusCounts->sum();
        $ordersInProgress = $ordersPending + $ordersProcessing;
        $ordersClosed = $ordersCompleted + $ordersCancelled + $ordersRefunded;

        $paymentSummary = $user->payments()
            ->where('status', PaymentStatusEnum::PAID->value)
            ->selectRaw('COALESCE(SUM(amount), 0) as total_amount, COUNT(*) as total_count')
            ->first();

        $paymentsCompletedTotal = (float) ($paymentSummary?->total_amount ?? 0);
        $paymentsCompletedCount = (int) ($paymentSummary?->total_count ?? 0);
        $lastPayment = $user->payments()->latest()->first();

        return view('dashboard', [
            'title' => 'لوحة التحكم',
            'user' => $user,
            'twoFactorEnabled' => $twoFactorEnabled,
            'emailVerified' => $emailVerified,
            'ordersPending' => $ordersPending,
            'ordersProcessing' => $ordersProcessing,
            'ordersCompleted' => $ordersCompleted,
            'ordersCancelled' => $ordersCancelled,
            'ordersRefunded' => $ordersRefunded,
            'ordersTotal' => $ordersTotal,
            'ordersInProgress' => $ordersInProgress,
            'ordersClosed' => $ordersClosed,
            'languages' => Language::select('id', 'name', 'code')->orderBy('name')->get(),
            'currencies' => Currency::select('id', 'name', 'code')->orderBy('name')->get(),
            'paymentsCompletedTotal' => $paymentsCompletedTotal,
            'paymentsCompletedCount' => $paymentsCompletedCount,
            'lastPayment' => $lastPayment,
        ]);
    }
}
