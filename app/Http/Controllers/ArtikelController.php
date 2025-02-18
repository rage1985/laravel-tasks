<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Store;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;
use Yajra\DataTables\DataTables;
use Dcblogdev\MsGraph\Facades\MsGraph;


class ArtikelController extends Controller
{
    /**
     * Methods for Article Views
     *
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        #$user_id = Auth::id();
        #$user = User::findorFail($user_id);
        #$partner = $user->partner->get();
        #if ($partner->partner_id == 0){
        #    $stores = $stores::all();
        #}
        #else{
        #    #$stores = $partner->stores->get();
        #}


        $stores = Store::all()->toArray();

        return view('Artikel.index')->with('stores', $stores);

    }

    public function getarticle($id)
    {
        #$user_id = Auth::id();
        #$user = User::findorFail($user_id);
        #$partner = $user->partner->get();
        #if ($partner->partner_id == 0){
        #    $stores = $stores::all();
        #}
        #else{
        #    #$stores = $partner->stores->get();
        #}


        $stores = Store::all()->toArray();

        return view('Artikel.index')->with('stores', $stores);

    }

    public function ajax()
    {

        $Artikel_DB = Artikel::where('store_id', '=', $store_id)->first();
        $filepath = public_path('import');
        $basename = "_Deklaration_LMIV.csv";
        $fullpath = $filepath . $store_id . $basename;

        $Artikel_CSV = Reader::createFromPath($fullpath);



        $dt = Datatables::of($All_Artikel)
            ->make(true);
        if (!$dt->isEmpty()) {
            return $dt;
        }
        else{
            return view('dashoard')->with($All_Artikel);
        }

    }

    public function getajax($store_id)
    {

        $Artikel_DB = Artikel::where('store_id', '=', $store_id);
        $filepath = public_path('import');
        $basename = "_Deklaration_LMIV.csv";
        $fullpath = $filepath . $store_id . $basename;

        $Artikel_CSV = Reader::createFromPath($fullpath);



        $dt = Datatables::of($All_Artikel)
            ->make(true);
        if (!$dt->isEmpty()) {
            return $dt;
        }
        else{
            return view('dashoard')->with($All_Artikel);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function download()
    {
        $user = Auth::user();
        $stores = Stores::where('partner_id', '=', $user->partner_id);
        MsGraph::files()->createFolder('Sato', $path = '\Dokumente');
        foreach ($stores as $store){
            MsGraph::files()->createFolder($store->store_name, $path = '\Dokumente\Sato\/');
        }
        #MsGraph::files()->upload($name, $uploadPath, $path = '\Dokumente');
        return view('artikel.index');

    }

    public function download_FX3()
    {

        $client = Onedrive::client(
            env('AZURE_CLIENT_ID', ''),
            [
                // Restore the previous state while instantiating this client to proceed
                // in obtaining an access token.
                'state' => $_SESSION['onedrive.client.state'],
            ]
        );

        // Obtain the token using the code received by the OneDrive API.
        $client->obtainAccessToken(env('AZURE_CLIENT_SECRET', ''), $_GET['code']);

        // Persist the OneDrive client' state for next API requests.
        $_SESSION['onedrive.client.state'] = $client->getState();

        // Past this point, you can start using file/folder functions from the SDK, eg:
        $file = $client->getRoot()->upload('hello.txt', 'Hello World!');
        echo $file->download();
        // => Hello World!

        $file->delete();

        return view('artikel.index');

    }

    public function makelabel()
    {

    }
}
