<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Constants;
use App\Http\Responses\ApiError;

class DashboardController extends Controller
{

    /**
     * Retrieve statistical data related to the authenticated user for the dashboard.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dashboardStats(Request $request)
    {
        try{
            // Retrieve the authenticated user from the request
            $user = $request->authUser;

            // Calculate the total revenue from donations for the past 30 days
            $totalDonationRevenue = $user->donations()
                ->where('created_at', '>=', now()->subDays(30))
                ->sum('amount');

            // Calculate the total revenue from subscriptions for the past 30 days
            $totalSubscriptionRevenue = $user->subscribers()
                ->where('subscribers.created_at', '>=', now()->subDays(30))
                ->join('subscription_tiers', 'subscribers.subscription_tier_id', '=', 'subscription_tiers.id')
                ->sum('subscription_tiers.price');

            // Calculate the total revenue from merch sales for the past 30 days
            $totalMerchRevenue = $user->merch_sales()
                ->where('created_at', '>=', now()->subDays(30))
                ->sum('amount');

            // Count the total number of followers gained in the past 30 days
            $totalFollowersGained = $user->followers()
                ->where('created_at', '>=', now()->subDays(30))
                ->count();

            // Retrieve the top selling items for the past 30 days
            $topItems = $user->merch_sales()
                ->select('items.name', \DB::raw('CONVERT(SUM(amount), DECIMAL(10,2)) as total_sales'))
                ->join('items', 'merch_sales.item_id', '=', 'items.id')
                ->where('merch_sales.created_at', '>=', now()->subDays(30))
                ->groupBy('items.name')
                ->orderByDesc('total_sales')
                ->limit(3)
                ->get();

            // To scale this up, we need to create another entity for currencies,
            // as of now using USD
            return response()->json([
                'revenue' => [
                    'donations' => (float) $totalDonationRevenue,
                    'subscriptions' => (float) $totalSubscriptionRevenue,
                    'merch_sales' => (float) $totalMerchRevenue,
                ],
                'followers_gained' => (int) $totalFollowersGained, // assuming followers gained is an integer
                'top_items' => $topItems,
                'currency' => Constants::PRIMARY_CURRENCY
            ]);
        } catch (JWTException $e) {
            return ApiError::internalServerError('Failed to process the request. Please try again later.');
        }

    }

}
