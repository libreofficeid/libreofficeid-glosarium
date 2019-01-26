<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Glosarium;
use Auth;

class GlosariumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_kata = Glosarium::orderBy('source','asc')->get();
        return view('glosarium.index', compact('list_kata'));
    }

    public function search(Request $request)
    {
        $lema = $request->input('lema');
        $padanan = \DB::table('glosarium')->where('source', 'REGEXP', "([[:<:]]|^)".$lema."([[:>:]]|$)" )->orderBy('source','asc')->paginate();
        return view('glosarium.search', compact('padanan', 'lema'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::check()) {
            return view('glosarium.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::check()) {
            // validate input
            
            // store to db
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $lema
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lema = Glosarium::find($id)->source;
        $padanan = \DB::table('glosarium')->where('source', 'REGEXP', "([[:<:]]|^)".$lema."([[:>:]]|$)" )->orderBy('source','asc')->paginate();;
        return view('glosarium.search', compact('padanan', 'lema'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // if (Auth::check()) {
            $data = Glosarium::find($id);
            // dd($data);
            return view('glosarium.edit',compact('data'))->renderSections()['content'];
        // }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::check()){
            Glosarium::destroy($id);
            return redirect('/home')->with('status', 'Berhasil menghapus data ');
        }
    }

    public function upload(Request $request)
    {
        if (Auth::check())
            {
        // getfile
        $upload = $request->file('uploadfile');
        $filepath = $upload->getRealPath();
        // readfile
        $file = fopen($filepath,'r');
        $header = fgetcsv($file);
        $escapedHeader = [];
        // validate header
        foreach ($header as $key => $value) {
            $lheader = strtolower($value);
            $escapedItem = preg_replace('/[^a-z]/','',$lheader);
            array_push($escapedHeader,$escapedItem);
        }
        // loop to other colummns
        while ($columns = fgetcsv($file)) {
            if($columns[0] == ""){
                continue;
            }
            $data = array_combine($escapedHeader,$columns);

            $kata_asal = $data['source'];
            $padanan = $data['translated'];
            // store to db
            $glosarium = Glosarium::firstOrNew(['source'=>$kata_asal, 'translated'=>$padanan]);
            $glosarium->created_by = Auth::user()->id;
            $glosarium->save();
            }
        }
        return redirect('/home')->with('status', 'Berhasil mengimpor data dari CSV!');

    }

}
