<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Responses\ApiError;

class NotificationController extends Controller
{

    /**
     * Retrieve unread notifications for the authenticated user.
     * 
     * Accepts a `status` query parameter to get read/unread notifications.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function unreadNotifications(Request $request)
    {

        try{
            // Retrieve the authenticated user from the request
            $user = $request->authUser;

            // Check if the status is provided in the request as a query parameter
            if (!$request->has('status')) {
                return ApiError::badRequest('Status not provided');
            }

            // This will convert "true" or "false" strings to their respective boolean values.
            $status = filter_var($request->query('status'), FILTER_VALIDATE_BOOLEAN); 

            // Define the number of notifications to display per page
            $perPage = 100;

            // Get the requested page number from the request query parameter
            $pageNumber = $request->query('page', 1);

            // Retrieve unread notifications for the user, ordered by created_at in descending order
            $notifications = $user->notifications()
                ->where('read', $status)
                ->orderByDesc('created_at')
                ->paginate($perPage, ['*'], 'page', $pageNumber);


            return response()->json([
                'notifications' => $notifications,
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
            ]);

        } catch (Exception $e) {
            return ApiError::internalServerError('Failed to process the request. Please try again later.');
        }

    }

    /**
     * Toggle the read status of the specified notification.
     *
     * Accepts a `status` query parameter to set the read status.
     * 
     * @param  Request  $request
     * @param  int  $notification_id
     * @return \Illuminate\Http\Response
     */
    public function toggleReadStatus(Request $request, $notification_id)
    {
        try{
            // Retrieve the authenticated user from the request
            $user = $request->authUser;

            // Find the notification by ID related to the authenticated user
            $notification = $user->notifications()->find($notification_id);

            // Check if the notification exists
            if (!$notification) {
                return ApiError::badRequest('Notification not found');
            }

            // Check if the status is provided in the request as a query parameter
            if (!$request->has('status')) {
                return ApiError::badRequest('Status not provided');
            }

            // This will convert "true" or "false" strings to their respective boolean values.
            $status = filter_var($request->query('status'), FILTER_VALIDATE_BOOLEAN); 

            // Set the read status of the notification
            $notification->read = $status;
            $notification->save();

            return response()->json(['message' => 'Notification read status updated']);

        } catch (Exception $e) {
            return ApiError::internalServerError('Failed to process the request. Please try again later.');
        }
    }
}
