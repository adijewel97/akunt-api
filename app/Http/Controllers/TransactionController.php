<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $transaction = Transaction::orderBy('ID', 'ASC')->get();
        // $response = [
        //     'message' => 'list transaksi order by time',
        //     'data' => $transaction
        // ];

        if ($transaction) {
            return ApiFormatter::createApi(
                200,
                'Succes',
                $transaction
            );
        } else {
            return ApiFormatter::createApi(
                400,
                'Gagal Tidak Ada Data'
            );
        }
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
        try {
            $customMessage = [
                'title.required'  => "Title Masih Kosong",
                'title.max'       => "Title Terlalau Panjang",
                'title.unique'    => "Title Sudah Ada untuk : " . $request->title,
                'amount.required' => "Nilai Rupaiah masih Kosong",
            ];

            $rules = [
                'id'        => 'integer|exists:master_advert_bundles',
                'title'     => ['required', 'unique:transactions', 'max:255'],
                'amount'    => ['required']
            ];


            // $validate = validation($request->all(), $rules);
            $validate = Validator::make($request->all(), $rules, $customMessage);
            if ($validate->fails()) {
                return  ApiFormatter::createApi(200,   $validate->errors()->first());
            }

            $transaction = Transaction::create([
                'title' => $request->title,
                'amount' => $request->amount,
                'time' => $request->time,
                'type' => $request->type
            ]);

            $data = Transaction::where('id', '=', $request->id)->get();
            if ($data) {
                return ApiFormatter::createApi(200, 'Succes Insert Data', $transaction);
            } else {
                return ApiFormatter::createApi(400, 'Gagal Insert Data Sudah Ada.');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'Gagal DB ' . $error->getMessage());
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
        //
        try {
            // $data = Transaction::findOrFail($id);
            $data = Transaction::where('id', '=', $id)->get();
            if ($data) {
                return ApiFormatter::createApi(200, 'Succes', $data);
            } else {
                return ApiFormatter::createApi(400, 'Gagal Tampilkan Data tidak Ditemukan');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'Gagal Tampilkan Data DB ' . $error->getMessage());
        }
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
        try {
            $customMessage = [
                'title.required'  => "Title Masih Kosong",
                'title.max'       => "Title Terlalau Panjang",
                'title.unique'    => "Title Sudah Ada untuk : " . $request->title,
                'amount.required' => "Nilai Rupaiah masih Kosong",
            ];

            $rules = [
                'id'        => 'integer|exists:master_advert_bundles',
                'title'     => ['required', 'unique:transactions', 'max:255'],
                'amount'    => ['required']
            ];


            // $validate = validation($request->all(), $rules);
            $validate = Validator::make($request->all(), $rules, $customMessage);
            if ($validate->fails()) {
                return  ApiFormatter::createApi(200,   $validate->errors()->first());
            }

            $data = Transaction::find($id);

            if (!$data) {
                return ApiFormatter::createApi(200, 'Gagal update Id Tidak ditemukan ' . $id);
            }

            $transaction = $data->update([
                'title' => $request->title,
                'amount' => $request->amount,
                'time' => $request->time,
                'type' => $request->type
            ]);


            $data = Transaction::where('id', '=', $request->id)->get();
            if ($data) {
                return ApiFormatter::createApi(200, 'Succes Update Data.', $data);
            } else {
                return ApiFormatter::createApi(400, 'Gagal Update Data Sudah Ada.');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'Gagal DB ' . $error->getMessage());
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
        $data = Transaction::find($id);

        if (!$data) {
            return ApiFormatter::createApi(200, 'Gagal Delete Id Tidak ditemukan : ' . $id);
        }

        $data->delete();
        return ApiFormatter::createApi(200, 'Sukses Delete Data ID ' . $id);
    }
}
