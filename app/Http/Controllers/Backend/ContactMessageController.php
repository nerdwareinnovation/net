<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class ContactMessageController extends Controller
{
    public function index()
    {
        try {
            $messages = ContactMessage::latest()->get();
            return view('backend.contact-messages.index', compact('messages'));
        } catch (Exception $e) {
            Log::error("Error fetching Contact Messages: " . $e->getMessage());
            return back()->with('error', 'Failed to load Contact Messages.');
        }
    }

    public function show($id)
    {
        try {
            $message = ContactMessage::findOrFail($id);
            // Mark as read
            if (!$message->is_read) {
                $message->is_read = true;
                $message->save();
            }
            return view('backend.contact-messages.show', compact('message'));
        } catch (Exception $e) {
            Log::error("Error fetching Contact Message: " . $e->getMessage());
            return redirect()->route('admin.contact-messages.index')
                ->with('error', 'Contact Message not found.');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $message = ContactMessage::findOrFail($id);
            $message->delete();
            DB::commit();

            return redirect()
                ->route('admin.contact-messages.index')
                ->with('success', 'Contact Message deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Contact Message delete failed: " . $e->getMessage());
            return redirect()->route('admin.contact-messages.index')
                ->with('error', 'Failed to delete Contact Message.');
        }
    }

    public function markAsRead($id)
    {
        try {
            $message = ContactMessage::findOrFail($id);
            $message->is_read = true;
            $message->save();

            return redirect()->back()->with('success', 'Message marked as read.');
        } catch (Exception $e) {
            Log::error("Error marking message as read: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to mark message as read.');
        }
    }
}

