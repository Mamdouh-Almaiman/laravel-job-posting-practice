<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


class ListingController extends Controller
{

    // show all listings
    public function index()
    {
        return view('listings.index', [ // because we put the index file in the listings folder
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6) // we imported the model file first and then used the Listing class to access the all method
        ]); // filter(request(['tag'])) here we are passing the requested tag to the method scopeFilter (in the controller class), and the varibale is array that's why we are using []
        // which means if anytime the user will be in the index page, when this code runs, if there is a selected tag then do the filter method otherwite just get all the listing by latest
    }

    // show single listing
    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }


    // Show create form
    public function create()
    {
        return view('listings.create');
    }

    // Store listing data
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        /*
        'logo' is the name of the file input field in your HTML form.
        'logos' is the directory inside the storage/app/public folder where the uploaded file will be stored.
         */

        $formFields['user_id'] = Auth::id(); // so this will set the user_id of the listings to the current logged in user

        // we are using the create method from the model class and what it does is store the data in the $fromFields to our database
        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing created successfully!');
        // 'message' will be used in the flash-message component with the same name, so if I want to make diffreant massages for exp one for the error and one for succes then use diffrant names
    }

    //Show edit form
    public function edit(Listing $listing)
    {
        return view('listings.edit', ['listing' => $listing]);
    }


    // Update listing data
    public function update(Request $request, Listing $listing)
    {
        // Make sure logged in user is owner
        if ($listing->user_id != Auth::id()) {
            abort(403, 'Unauthorized Action');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        /*
        'logo' is the name of the file input field in your HTML form.
        'logos' is the directory inside the storage/app/public folder where the uploaded file will be stored.
         */

        // we are using the create method from the model class and what it does is store the data in the $fromFields to our database
        $listing->update($formFields);

        return back()->with('message', 'Listing updated successfully!');
        // 'message' will be used in the flash-message component with the same name, so if I want to make diffreant massages for exp one for the error and one for succes then use diffrant names
    }


    public function destroy(Listing $listing)
    {
        // Make sure logged in user is owner
        if ($listing->user_id != Auth::id()) {
            abort(403, 'Unauthorized Action');
        }
        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully!');
    }


    // Manage listings
    public function manage()
    {
        $current_user = Auth::user(); //get the logged in user
        return view('listings.manage', ['listings' => Auth::user()->listings()->get()]);
    }
    // Had the same issue, it's the PHP intelephense extension in VS Code, must need an update. I changed to v1.8.2 instead of v1.9.5 and that fixed it.

}
