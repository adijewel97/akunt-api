<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;
use Exception;
use PDOException;

class TestOracleControler extends Controller
{
    public function index()
    {
        $data = DB::select('select * from BPBL.TRANS_PENETAPAN_MOBILE');
        // return DB::select("SELECT mycursor(5) AS mfrc FROM dual");
        if ($data) {
            return ApiFormatter::createApi(
                200,
                'Succes',
                'Tampil Data',
                $data
            );
        } else {
            return ApiFormatter::createApi(
                400,
                'Error',
                'Gagal Tidak Ada Data'
            );
        }
    }

    public function testfunctioncur()
    {
        // try {
        //$data = DB::select("select BPBL.PKG_PROSES_NIDI.GET_STATUS_NIDI_GRID ('0', '32', '333444555', '444555','555' ,:TMPCUR_OUT,pesan) from dual");
        // GET_STATUS_NIDI_GRID (vPilihan varchar2, vKdProvinsi varchar2,  vnokontrak in varchar2,vnobadoc in varchar2,vnobalit varchar2,
        //                      out_data OUT sys_refcursor, pesan OUT VARCHAR2)
        $vpilihan       = '0';
        $vKdProvinsi    = '32';
        $vnokontrak     = '333444555';
        $vnobadoc       = '444555';
        $vnobalit       = '555';

        $vTMPCUR_OUT = '';
        $vpesan      = '';

        $pdo    = DB::getPdo();
        $stmt   = $pdo->prepare("begin BPBL.PKG_PROSES_NIDI.GET_STATUS_NIDI_GRID (:pilihan, :KdProvinsi, :nokontrak,:nobadoc ,:nobalit ,:TMPCUR_OUT,:pesan); end;");

        $stmt->bindParam(':pilihan', $vpilihan,          PDO::PARAM_STR, 50);
        $stmt->bindParam(':KdProvinsi', $vKdProvinsi,    PDO::PARAM_STR, 2);
        $stmt->bindParam(':nokontrak', $vnokontrak,      PDO::PARAM_STR, 10);
        $stmt->bindParam(':nobadoc', $vnobadoc,          PDO::PARAM_STR, 10);
        $stmt->bindParam(':nobalit', $vnobalit,          PDO::PARAM_STR, 10);
        $stmt->bindParam(':TMPCUR_OUT', $vTMPCUR_OUT,    PDO::PARAM_STMT, 2000);
        $stmt->bindParam(':pesan', $vpesan,              PDO::PARAM_INPUT_OUTPUT);
        $stmt->execute();

        // dd($vTMPCUR_OUT);

        return ApiFormatter::createApi(
            200,
            'Succes',
            'Tampil Data ' . $vpesan,
            $vTMPCUR_OUT
        );
    }

    public function testfunctioncur2()
    {
        $vTMPCUR_OUT = [];
        $vpesan      = '';
        // $mydata      = [];

        try {

            $pdo    = DB::getPdo();
            $stmt   = $pdo->prepare('begin BPBL.PKG_MONITORING_LAPORAN.COMBO_TAHUN_PENGERJAAN_BPBL ( :TMPCUR_OUT, :pesan); end;');

            // $stmt->bindParam(':TMPCUR_OUT', $vTMPCUR_OUT,    PDO::PARAM_STMT);
            $stmt->bindParam(':TMPCUR_OUT', $vTMPCUR_OUT,    PDO::PARAM_STMT);
            $stmt->bindParam(':pesan', $vpesan,              PDO::PARAM_INPUT_OUTPUT, 1000);
            $stmt->execute();
            // $stmt->fetchAll();

            oci_execute($vTMPCUR_OUT, OCI_DEFAULT);
            oci_fetch_all($vTMPCUR_OUT, $mydata, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
            oci_free_cursor($vTMPCUR_OUT);

            if ($mydata) {
                return ApiFormatter::createApi(
                    200,
                    'Sukses',
                    $vpesan,
                    $mydata
                );
            } else {
                return ApiFormatter::createApi(
                    400,
                    'Error',
                    'Gagal Tidak Ada Data'
                );
            }
        } catch (\Exception  $e) {
            // dd($e->getMessage());
            return ApiFormatter::createApi(
                400,
                'Error',
                'Gagal Tidak Ada Data : ' . $e->getMessage()
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
