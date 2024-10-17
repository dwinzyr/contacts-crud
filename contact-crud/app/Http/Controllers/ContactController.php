<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Tampilkan daftar kontak dan fitur pencarian
    public function index(Request $request)
    {
        $search = $request->input('search');
        $contacts = Contact::when($search, function($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%")
                         ->orWhere('address', 'like', "%{$search}%");
        })->get();

        return view('contacts.index', compact('contacts', 'search'));
    }

    // Tampilkan form untuk membuat kontak baru
    public function create()
    {
        return view('contacts.create');
    }

    // Simpan data kontak yang baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:contacts',
            'phone' => 'required',
            'address' => 'required',
        ]);

        Contact::create($validated);

        return redirect()->route('contacts.index')->with('success', 'Contact created successfully.');
    }

    // Tampilkan detail kontak untuk diedit
    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    // Perbarui kontak yang sudah ada
    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:contacts,email,' . $contact->id,
            'phone' => 'required',
            'address' => 'required',
        ]);

        $contact->update($validated);

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully.');
    }

    // Hapus kontak
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully.');
    }
}
