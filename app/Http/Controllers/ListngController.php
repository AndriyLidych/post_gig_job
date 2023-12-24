<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use Illuminate\Validation\Rule;


class ListngController extends Controller
{//всі лісти
    public function  index(Request $request){

        return view('listings.index', [

            'listings' => Listing::latest()->filter(request(['tag','search']))->simplePaginate(4)
        ]);

    }
    //один
    public function  show(Listing $listing){
        return view('listings.show', [
            'listing' =>$listing
        ]);

    }
    //показ створення форми
    public function  create(){
        return view('listings.create');
    }
    //store listing data
    public function store(Request $request){
       $formFields= $request->validate([
           'title'=>'required',
          'company'=>['required',Rule::unique('listings','company')],
           'location'=>'required',
           'website'=>'required',
           'email'=>['required','email'],
           'tags'=>'required',
           'description'=>'required'
       ]);
       if($request->hasFile('logo')){
           $formFields['logo'] = $request->file('logo')->store('logos','public');
       }

        Listing::create($formFields);


       return redirect('/')->with('message','Listing created ');



    }
    //показ форми редагування
    public function  edit(Listing $listing){
        return view('listings.edit',['listing' => $listing]);
    }

    //update listing data
    public function update(Request $request, Listing $listing){
        $formFields= $request->validate([
            'title'=>'required',
            'company'=>['required'],
            'location'=>'required',
            'website'=>'required',
            'email'=>['required','email'],
            'tags'=>'required',
            'description'=>'required'
        ]);
        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos','public');
        }

        $listing->create($formFields);


        return back()->with('message','Listing updated ');



    }
    //удаляю карточку з лістінга
    public function  destroy(Listing $listing){
        $listing->delete();
        return redirect('/')->with('message','Listing Deleted Success');

    }
}
