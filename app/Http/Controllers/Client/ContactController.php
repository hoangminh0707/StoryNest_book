<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
{
    $contacts = Contact::all(); // hoặc Contact::select('id', 'full_name', 'email', 'phone', 'address')->get();
    return view('contacts.index', compact('contacts'));
}
}
