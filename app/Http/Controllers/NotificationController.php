<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Đánh dấu tất cả thông báo của user hiện tại đã đọc
     */
    public function markAsRead(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User không được xác thực'
                ], 401);
            }

            // Đánh dấu tất cả thông báo chưa đọc thành đã đọc
            $user->unreadNotifications->markAsRead();

            return response()->json([
                'success' => true,
                'message' => 'Đã đánh dấu tất cả thông báo đã đọc'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Đánh dấu một thông báo cụ thể đã đọc
     */
    public function markSingleAsRead(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User không được xác thực'
                ], 401);
            }

            $notificationId = $request->input('notification_id');
            
            if (!$notificationId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Thiếu notification_id'
                ], 400);
            }

            // Tìm thông báo và đánh dấu đã đọc
            $notification = $user->notifications()->find($notificationId);
            
            if (!$notification) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy thông báo'
                ], 404);
            }

            $notification->markAsRead();

            return response()->json([
                'success' => true,
                'message' => 'Đã đánh dấu thông báo đã đọc'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
} 