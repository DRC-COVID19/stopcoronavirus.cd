<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Asana\Client;


class BugTrackerController extends Controller
{
    private $client= null;
    private static $ASANA_PERSONAL_ACCESS_TOKEN ='1/1201337579622176:27020d37454f7274f0e1cdbac25b2997';

    public function __construct()
    {
       $this->client = Client::accessToken(self::$ASANA_PERSONAL_ACCESS_TOKEN,[
           'headers'                    =>
           [
            'asana-disable' => 'string_ids'
           ],
           'log_asana_change_warnings'  => false
       ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $me = $this->client->users->getUser("me");
      
        $workspaceGid = $me->workspaces[0]->gid;
        return response()->json(['me'=> $this->client->users->getUser("me")],200);
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
        //
    }
}
