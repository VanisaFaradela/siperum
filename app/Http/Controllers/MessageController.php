<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $message = Message::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%")
                             ->orWhere('subjek', 'like', "%{$search}%");
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $totalMessage = Message::count();
        $totalBelumDibaca = Message::where('status', 'belum_dibaca')->count();
        $totalSudahDibaca = Message::where('status', 'sudah_dibaca')->count();

        return view('message.index', compact(
            'message', 'totalMessage', 'totalBelumDibaca', 'totalSudahDibaca',
        ));
    }

    public function show(Message $message)
    {
        if ($message->status == 'belum_dibaca') {
            $message->update([
                'status' => 'sudah_dibaca',
                'dibaca_pada' => now()
            ]);
        }

        return view('message.show', compact('message'));
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()->route('message.index')
            ->with('success', 'Pesan berhasil dihapus!');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        Message::whereIn('id', $ids)->delete();

        return response()->json(['success' => true]);
    }
}