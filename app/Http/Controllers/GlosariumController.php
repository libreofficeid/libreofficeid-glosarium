<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Toastr;
use App\Models\Glosarium;
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
        // $padanan = \DB::table('glosarium')->where('source', 'REGEXP', "([[:<:]]|^)".$lema."([[:>:]]|$)" )->orderBy('source','asc')->paginate();
        $padanan = Glosarium::where('source','LIKE', $lema."%")->orderBy('source','asc')->paginate();
        // $padanan = \DB::table('glosarium')->where('source', 'LIKE', $lema."%" )->orderBy('source','asc')->paginate();
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
            return view('glosarium.create')->renderSections()['content'];
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
            $validator = \Validator::make($request->all(),
            [
                'asal'=>'required|unique:glosarium,source',
                'padanan'=> 'required',
            ]);
            if ($validator->fails())
            {
                return response()->json(['errors'=>$validator->errors()->all()]);
            }
            $kata = new Glosarium([
                "source" => $request->get('asal'),
                "translated" => $request->get('padanan'),
                "created_by" => Auth::user()->id
            ]);
            $kata->save();
            // Toastr::success('Berhasil menambahkan padanan baru');
            return response()->json(['status'=>'Berhasil menambahkan padanan baru']);
            // return redirect()->route('home');
            // return redirect('/home')->with('status', 'Berhasil menambahkan padanan baru');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lema = Glosarium::find($id)->source;
        $padanan = Glosarium::where('source','like','%'.$lema.'%')->orderBy('source','asc')->paginate();
        // $padanan = \DB::table('glosarium')->where('source', 'REGEXP', "([[:<:]]|^)".$lema."([[:>:]]|$)" )->orderBy('source','asc')->paginate();
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
        if (Auth::check()) {
            $data = Glosarium::find($id);
            return view('glosarium.edit',compact('data'))->renderSections()['content'];
        }
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
        if (Auth::check()) {
            $request->validate([
                'asal'=>'required',
                'padanan'=> 'required',
              ]);
            $kata = Glosarium::find($id);
            $kata->source = $request->get('asal');
            $kata->translated = $request->get('padanan');
            $kata->created_by = Auth::user()->id;
            $kata->save();
            Toastr::success('Berhasil memperbarui data');
            return redirect()->route('home');
        }
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
            Toastr::success('Berhasil menghapus data');
            return redirect()->route('home');
            // return redirect('/home')->with('status', 'Berhasil menghapus data ');
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
        Toastr::success('Berhasil mengimpor data dari CSV!');
        return redirect()->route('home');
        // return redirect('/home')->with('status', 'Berhasil mengimpor data dari CSV!');

    }

    // override pesan validasi
    public function messages()
    {
        return [
            'unique' => 'Kata asal sudah terdaftar, ',
        ];
    }

}
