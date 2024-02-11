<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class listingController extends Controller
{
    //show all listings
    public function index(){
        // dd(request('tag'));
        return view('listings.index',[
            'heading'=>'Latest Listings',
            'listings'=>Listing::Latest()->filter(request(['tag','search']))->paginate(4)
        ]);
    }

    // show single listing
    public function show(Listing $listing){
        return view('listings.show',[
            'listing'=>$listing
        ]); 
    }

    // show create form
    public function create(){
        return view('listings.create');
    }


    // store Listing Data
    public function store(Request $request){
        $Formfields=$request->validate([
            'title'=>'required',
            'company'=>['required',Rule::unique('listings','company')], 
            'location'=>'required',
            'website'=>'required',
            'email'=>['required','email'],
            'tags'=>'required',
            'description'=>'required'
   
        ]
    );


    if($request->hasFile('logo')){
        $Formfields['logo']=$request->file('logo')->store('logos','public');
    }

    $Formfields['user_id']=auth()->id();

        Listing::create($Formfields);
        return redirect('/')->with('success','Listing created successfully');
    }


    // show edit form
    public function edit(Listing $listing){
        return view('listings.edit',['listing'=>$listing]);
    }
    

    // update listing data
    public function update(Request $request, Listing $listing){

        //ensure logged in user is owner
        if($listing->user_id !=auth()->id()){
            abort(403,"unauthorized action");
        }

        $Formfields=$request->validate([
            'title'=>'required',
            'company'=>'required', 
            'location'=>'required',
            'website'=>'required',
            'email'=>['required','email'],
            'tags'=>'required',
            'description'=>'required'
   
        ]
    );


    if($request->hasFile('logo')){
        $Formfields['logo']=$request->file('logo')->store('logos','public');
    }

        $listing->update($Formfields);
        return back()->with('success','Listing updated successfully');
    }


    // delete listing
    public function destroy(Listing $listing){
        if($listing->user_id !=auth()->id()){
            abort(403,"unauthorized action");
        }
        
        $listing->delete();
        return redirect('/')->with('success','listing deleted successfully');

    }

    public function manage(){
        return view('Listings.manage',[
            'listings'=>auth()->user()->listings()->get()]);
    }

}
