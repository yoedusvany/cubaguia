<?php

namespace App\Http\Controllers;

use App\Contacts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\Util\Json;

class ContactsController extends Controller
{

    /**
     * Get a list of the contacts.
     *
     * @return
     */
    public function index()
    {
        return view('contacts.list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        return DB::table('contacts')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
    }

    /**
     * Send mail .
     *
     * @return \Illuminate\Http\Response
     */
    public function sendMail($email, $subject, $message)
    {
        return "true";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $contact = new Contacts();

        $contact->nombre = $request->name;
        $contact->email = $request->email;
        $contact->subject = $request->subject;
        $contact->message = $request->message;

        $contact->save();

        return $contact;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return Contacts::where('id', $id)->first()->toJson();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contacts  $contacts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contacts $contacts)
    {
        //
    }
}
