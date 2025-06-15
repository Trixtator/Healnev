<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\McuRegistration; // Pastikan model ini sesuai dengan model Anda
use App\Models\Order; // Pastikan model ini sesuai dengan model Anda
use App\Models\User; // Pastikan model ini sesuai dengan model Anda

class AdminController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $orders = Order::with(['user', 'paket.rumahsakit'])
        ->when($search, function ($query, $search) {
            return $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        })
        ->orderBy('created_at', 'desc')
        ->paginate(15); // <= INI

    return view('admin.index', compact('orders'));
}

    public function updateStatus(Request $request, $id)
    {
        $registrations = McuRegistration::find($id);
        $registrations->status = $request->status;
        $registrations->save();

        return redirect()->route('admin.index')->with('success', 'Status updated successfully.');
    }

    public function users(Request $request)
{
    $users = User::latest()->paginate(10); // pagination 10 per page
    return view('user.index', compact('users'));

}

public function userList(Request $request)
    {
        $users = User::latest()->paginate(10); // Pagination 10 per page
        return view('user.index', compact('users'));
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }


}
