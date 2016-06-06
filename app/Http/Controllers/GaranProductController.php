<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use WC_API_Client;
use WC_API_Client_Exception;
use WC_API_Client_Resource_Customers;

class GaranProductController extends Controller{
    protected $resource_avaliable = false;
    protected $resource;
    public function __construct(){
        $domain = "https://garan24.ru";
        $consumer_key = "ck_7575374a55d17741f3999e8c98725c6471030d6c";
        $consumer_secret = "cs_89f95570b4bd18759b8501cd16e4756ab03a544c";
        $options = [
            'debug'           => true,
        	'return_as_array' => false,
        	'validate_url'    => false,
        	'timeout'         => 30,
            'ssl_verify'      => false
        ];
        try {
            $client = new WC_API_Client( $domain, $consumer_key,$consumer_secret, $options );
            $this->resource = new WC_API_Client_Resource_Products($client);
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
    public function create(Request $rq)
    {
        $res = ["code"=>"0","message"=>""];
        if(!$this->resource_avaliable) return json_encode($res);
        try{
            $customer = [
                "customer"=>[
                    "email"=>$rq->input("email"),
                    "password"=>$rq->input("email"),
                    "username"=>$rq->input("email")
                ]
            ];
            $res = $this->resource->create($customer)->http->response->body;
        }catch ( WC_API_Client_Exception $e ) {
            $res["code"] = $e->getCode();
            $res["message"] = $e->getMessage();
            if ( $e instanceof WC_API_Client_HTTP_Exception ) {
                $res["request"] = $e->get_request();
                $res["response"] = $e->get_response();
            }
        }
        return $res;
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
        $res = ["code"=>"0","message"=>""];
        if(!$this->resource_avaliable) return json_encode($res);
        try{
            $res = $this->resource->get($id)->http->response->body;
        }catch ( WC_API_Client_Exception $e ) {
            $res["code"] = $e->getCode();
            $res["message"] = $e->getMessage();
            if ( $e instanceof WC_API_Client_HTTP_Exception ) {
                $res["request"] = $e->get_request();
                $res["response"] = $e->get_response();
            }
        }
        return $res;
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
