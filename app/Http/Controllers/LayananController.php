<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;

class LayananController extends Controller
{
    public function index()
    {
        $services = Layanan::all();
        return view('log-layanan', compact('services'));
    }
    public function submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'service' => 'required|string',
            'details' => 'required|string',
        ]);

        $services = new Layanan();
        $services->email = $request->email;
        $services->name = $request->name;
        $services->address = $request->address;
        $services->phone = $request->phone;
        $services->service = $request->service;
        $services->details = $request->details;
        $services->save();

        return redirect()->back()->with('success', 'Form submitted successfully!');
    }
}
