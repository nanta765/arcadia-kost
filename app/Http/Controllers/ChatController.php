<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    /**
     * Get or create the active open chat session for the current customer.
     */
    public function getOrCreateChat()
    {
        $user = Auth::user();

        // Find an open chat session
        $chat = Chat::where('customer_id', $user->id)
            ->where('status', 'open')
            ->first();

        // Create a new chat session if none exists
        if (!$chat) {
            $chat = Chat::create([
                'customer_id' => $user->id,
                'status' => 'open',
            ]);
        }

        return response()->json([
            'chat_id' => $chat->id,
            'status' => $chat->status,
        ]);
    }

    /**
     * Get all messages for a specific chat.
     */
    public function getMessages(Chat $chat)
    {
        $user = Auth::user();

        // Access control: User must be either the customer of the chat, or a staff/owner
        if ($chat->customer_id !== $user->id && !in_array($user->role, ['owner', 'staff'])) {
            return response()->json(['error' => 'Akses ditolak.'], 403);
        }

        // Fetch messages with sender details
        $messages = ChatMessage::with('sender')
            ->where('chat_id', $chat->id)
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read based on viewer
        if ($user->role === 'customer') {
            // Customer reads staff messages
            ChatMessage::where('chat_id', $chat->id)
                ->where('sender_id', '!=', $user->id)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        } else {
            // Staff reads customer messages
            ChatMessage::where('chat_id', $chat->id)
                ->where('sender_id', $chat->customer_id)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        // Format response
        $formattedMessages = $messages->map(function ($msg) use ($user) {
            return [
                'id' => $msg->id,
                'message' => $msg->message,
                'sender_id' => $msg->sender_id,
                'sender_name' => $msg->sender->name,
                'is_own' => $msg->sender_id === $user->id,
                'formatted_time' => $msg->created_at->format('H:i'),
                'is_read' => $msg->is_read,
            ];
        });

        return response()->json([
            'messages' => $formattedMessages,
            'customer_name' => $chat->customer->name,
            'staff_name' => $chat->staff ? $chat->staff->name : null,
        ]);
    }

    /**
     * Send a message to a specific chat.
     */
    public function sendMessage(Request $request, Chat $chat)
    {
        $user = Auth::user();

        // Access control: User must be either the customer of the chat, or a staff/owner
        if ($chat->customer_id !== $user->id && !in_array($user->role, ['owner', 'staff'])) {
            return response()->json(['error' => 'Akses ditolak.'], 403);
        }

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Create the message
        $message = ChatMessage::create([
            'chat_id' => $chat->id,
            'sender_id' => $user->id,
            'message' => $request->message,
            'is_read' => false,
        ]);

        // If staff replies and the chat has no staff assigned, assign them
        if (in_array($user->role, ['owner', 'staff']) && !$chat->staff_id) {
            $chat->update(['staff_id' => $user->id]);
        }

        // Touch the chat updated_at timestamp to bring it to the top of list
        $chat->touch();

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'message' => $message->message,
                'sender_id' => $message->sender_id,
                'sender_name' => $user->name,
                'is_own' => true,
                'formatted_time' => $message->created_at->format('H:i'),
            ],
        ]);
    }

    /**
     * Get list of chats for staff/owner.
     */
    public function getStaffChats()
    {
        $user = Auth::user();

        // Only staff and owner can access this
        if (!in_array($user->role, ['owner', 'staff'])) {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        // Get chats where the user is staff, or chats that are open and have no staff (available)
        $chats = Chat::where(function ($query) use ($user) {
            $query->where('staff_id', $user->id)
                  ->orWhere(function ($q) {
                      $q->whereNull('staff_id')
                        ->where('status', 'open');
                  });
        })
        ->with(['customer', 'staff'])
        ->latest('updated_at')
        ->get()
        ->map(function ($chat) use ($user) {
            // Determine partner (the other party)
            if ($user->role === 'customer') {
                // For customer, partner is staff (if assigned) or null
                $partner = $chat->staff;
            } else {
                // For staff/owner, partner is customer
                $partner = $chat->customer;
            }

            // Get last message
            $lastMessage = $chat->messages()->latest('created_at')->first();

            // Count unread messages for the user
            $unreadCount = 0;
            if ($user->role === 'customer') {
                // Customer: unread messages from staff
                $unreadCount = $chat->messages()
                    ->where('sender_id', '!=', $user->id)
                    ->where('is_read', false)
                    ->count();
            } else {
                // Staff/Owner: unread messages from customer
                $unreadCount = $chat->messages()
                    ->where('sender_id', $chat->customer_id)
                    ->where('is_read', false)
                    ->count();
            }

            return [
                'id' => $chat->id,
                'partner_id' => $partner ? $partner->id : null,
                'partner_name' => $partner ? $partner->name : null,
                'partner_initials' => $partner ? strtoupper(substr($partner->name, 0, 1)) : '?',
                'is_online' => false, // Simplified; could be based on last seen
                'last_message_time' => $lastMessage ? $lastMessage->created_at->format('H:i') : null,
                'last_message_preview' => $lastMessage ? Str::limit($lastMessage->message, 30) : null,
                'unread_count' => $unreadCount,
            ];
        });

        return response()->json(['chats' => $chats]);
    }
}
