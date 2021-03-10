<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('contacts.index')
            ->with('contacts', Contact::orderBy('created_at', 'desc')->paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts.create')
            ->with('contacts', Contact::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|alpha|max:200',
            'lastname' => 'required|alpha|max:200',
            'phone' => 'required|string|unique:contacts',
        ]);

        Contact::insert([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'phone' => $request->phone,
            'created_at' =>  Carbon::now(),
        ]);

        session()->flash('success', 'Contact created successfully.');

        return redirect(route('contacts.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        return view('contacts.create')
            ->with('contact', $contact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Contact $contact)
    {
        $this->validate($request, [
            'name' => 'required|alpha|max:200',
            'lastname' => 'required|alpha|max:200',
            'phone' => ['required', 'string', Rule::unique('contacts')->ignore($contact->id)],
        ]);

        $data = $request->only(['name', 'lastname', 'phone']);

        $contact->update($data);
        session()->flash('success', 'Contact updated successfully.');
        return redirect(route('contacts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $contact = Contact::where('id', $id)->firstOrFail();

        $contact->delete();
        session()->flash('error', 'Contact deleted successfully');

        return redirect(route('contacts.index'));
    }

    public function xmlUpload(Request $request) {

        $this->validate($request, [
            'xml_file' => 'required|file|mimes:xml',
        ],[
            'xml_file.required' => 'Please upload the contact file.',
            'xml_file.mimes' => 'Please upload a file in XML format.',
        ]);

        //uploaded XML Contacts File (Not Storing the file in database)
        $fileName = $request->xml_file;

        //Storing Contacts
        $xmldata = simplexml_load_file($fileName) or die("Failed to load");
        foreach($xmldata->children() as $contact) {
            Contact::updateOrCreate([
                'name' => $contact->name,
                'lastname' => $contact->lastName,
                'phone' => $contact->phone,
                'created_at' =>  Carbon::now(),
            ]);
        }

        session()->flash('success', 'All contacts from the file created successfully');
        return redirect(route('contacts.index'));
    }
}
