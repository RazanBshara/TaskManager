<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Rule;
 

class RuleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('CheckPermission');
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rule = Rule::orderBy('created_at','desc')->paginate(10);
        return view('rule.index')->with('rule', $rule);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('rule.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
           // 'createdby' => 'required'          
        ]);

        // Create Rule
        $rule = new Rule;
        $rule->name = $request->input('name');
        $rule->description = $request->input('description');

        $user_id = auth()->user()->id;
        $rule->userid = $user_id;           

        $rule->save();

        return redirect('/rule')->with('success', 'rule Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rule = Rule::find($id);
        return view('rule.show')->with('rule', $rule);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rule = Rule::find($id);
        
        //Check if Rule exists before deleting
        if (!isset($rule)){
            return redirect('/rule')->with('error', 'No rule Found');
        }

        return view('rule.edit')->with('rule', $rule);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            //'createdby' => 'required'          
        ]);      

        $rule = Rule::find($id);

        // Update Rule
        $rule->name = $request->input('name');
        $rule->description = $request->input('description');       

        $rule->save();

        return redirect('/rule')->with('success', 'rule Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rule = rule::find($id);
        
        //Check if Drink exists before deleting
        if (!isset($rule)){
            return redirect('/rule')->with('error', 'No rule Found');
        }
        
        $rule->delete();

        return redirect('/rule')->with('success', 'rule Removed');
    }
}
