<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmateraiController extends Controller
{
    function __construct(){
        // environment set
        if(env('APP_ENV')=='production'){
            // E-meterai Production Access On Premise Service
            $API_LOGIN = 'https://backendservice.e-meterai.co.id/api/users/login';
            $API_GENERATE_SERIAL_NUMBER = 'https://stampv2.e-meterai.co.id/chanel/stampv2';
            $API_GENERATE_SERIAL_NUMBER_BULK = 'https://inventory.e-meterai.co.id/api/v2/serialnumber/batch';
            $API_STEMPTING = '{{keystamp}}/adapter/pdfsigning/rest/docSigningZ';
            // API Stamping (Sign Adapter):
            // {{keystamp}}/adapter/pdfsigning/rest/docSigningZ
            // {{keystamp}} merupakan domain dari docker adapter yang di deploy di sisi client
            $API_JENIS_DOCUMENT = 'https://stampv2.e-meterai.co.id/jenisdoc';
            $API_CHECK_SERIAL_NUMBER = 'https://backendservice.e-meterai.co.id/api/chanel/stamp/ext';
            $API_GENERATE_QR = 'https://stampv2.e-meterai.co.id/snqr/qrimage';
            $API_CHECK_BATCH_ID ='https://stampv2.e-meterai.co.id/snqr/status-batch';
            $API_GET_SN_QR_IMAGE = 'https://stampv2.e-meterai.co.id/snqr';
            $API_CHECK_SALDO = 'https://backendservice.e-meterai.co.id/function/saldopos';
            $API_CHECK_SALDO_PEMUNGUT = 'https://backendservice.e-meterai.co.id/sale/saldo-scm?idLoc=[idPemungut]&db=true';
            //idPemungut didapat dari response API Login pada response body “Id” dengan “description”:“PEMUNGUT”
            $API_UPDATE_DATA_STEMTING = 'https://stampv2.e-meterai.co.id/stamping/update-data/[SerialNumber]';
            //Serial Number dengan status NOT-STAMP yang telah tergenerate, dan akan diupdate
            $API_CHECK_DAFTAR_SN = 'https://stampv2.e-meterai.co.id/chanel/sale/stamp/ext/[UserID]';
        }else{
              // E-meterai Staging Access On Premise Service
              $API_LOGIN = 'https://backendservicestg.e-meterai.co.id/api/users/login';
              //Login dilakukan untuk mendapatkan token JWT dan berlaku selama 1x24 jam
              $API_GENERATE_SERIAL_NUMBER = 'https://stampv2stg.e-meterai.co.id/chanel/stampv2';
              $API_GENERATE_SERIAL_NUMBER_BULK = 'https://inventorystg.e-meterai.co.id/api/v2/serialnumber/batch';
              $API_STEMPTING = '{{keystamp}}/adapter/pdfsigning/rest/docSigningZ';
              // API Stamping (Sign Adapter):
              // {{keystamp}}/adapter/pdfsigning/rest/docSigningZ
              // {{keystamp}} merupakan domain dari docker adapter yang di deploy di sisi client
              $API_JENIS_DOCUMENT = 'https://stampv2stg.e-meterai.co.id/jenisdoc';
              $API_CHECK_SERIAL_NUMBER = 'https://backendservicestg.e-meterai.co.id/api/chanel/stamp/ext';
              $API_GENERATE_QR = 'https://stampv2stg.e-meterai.co.id/snqr/qrimage';
              $API_CHECK_BATCH_ID ='https://stampv2stg.e-meterai.co.id/snqr/status-batch';
              $API_GET_SN_QR_IMAGE = 'https://stampv2stg.e-meterai.co.id/snqr';
              $API_CHECK_SALDO = 'https://backendservicestg.e-meterai.co.id/function/saldopos';
              $API_CHECK_SALDO_PEMUNGUT = 'https://backendservicestg.e-meterai.co.id/sale/saldo-scm?idLoc=[idPemungut]&db=true';
              //idPemungut didapat dari response API Login pada response body “Id” dengan “description”:“PEMUNGUT”
              $API_UPDATE_DATA_STEMTING = 'https://stampv2stg.e-meterai.co.id/stamping/update-data/[SerialNumber]';
              //Serial Number dengan status NOT-STAMP yang telah tergenerate, dan akan diupdate
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(['success'=>'API']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
