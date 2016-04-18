<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use WC_API_Client;
use WC_API_Client_Exception;
use WC_API_Client_Resource_Customers;

class GaranCustomerController extends Controller
{
    protected $resource_avaliable = false;
    protected $resource;
    public function __construct(){
        $domain = "http://demoshop.garan24.ru";
        $consumer_key = "ck_a060e095bdafdc57d95fb4df2d19aa9a2d671a91";
        $consumer_secret = "cs_4bbfa365ae1850f93f1144ebe666302315831ff0";
        $options = [
            'debug'           => true,
        	'return_as_array' => false,
        	'validate_url'    => false,
        	'timeout'         => 30,
            'ssl_verify'      => false
        ];
        try {
            $client = new WC_API_Client( $domain, $consumer_key,$consumer_secret, $options );
            $this->resource = new WC_API_Client_Resource_Customers($client);
            $this->resource_avaliable = true;
        } catch ( WC_API_Client_Exception $e ) {

            echo $e->getMessage() . PHP_EOL;
            echo $e->getCode() . PHP_EOL;

            if ( $e instanceof WC_API_Client_HTTP_Exception ) {

                print_r( $e->get_request() );
                print_r( $e->get_response() );
            }
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!$this->resource_avaliable) return "{}";
        return $this->resource->get()->http->response->body;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        if(!$this->resource_avaliable) return "{}";
        return $this->resource->get_by_email($id)->http->response->body;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
