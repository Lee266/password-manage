<?php

namespace App\Http\Controllers\Admin\Meeting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Models\Meeting;

class MeetingListController extends Controller
{
    private $perpage = 10;

    public function validationData($data, $type = null){
        // ------------------------------------------------------------------
        // Set validation
        // ------------------------------------------------------------------
        return Validator::make($data, [
            'title'                         => 'required|string|max:255',
            'user_id'                       => 'required|exists:users,id',
            'meeting_date'                  => 'required',
            'location'                      => 'nullable|max:255',
            'location_image_url'            => 'nullable|max:255',
            // --------------------------------------------------------------
        ],
        [
            'title.required'                => __('meeting.title').__('meeting.required'),
            'title.max'                     => "最大255文字を入力してください",
            // --------------------------------------------------------------
            'user_id.required'              => __('meeting.user').__('meeting.required'),
            'user_id.exists'                => "現在のIDのユーザーデータはありません",
            // --------------------------------------------------------------
            'meeting_date.required'         => __('meeting.date').__('meeting.required'),
            // --------------------------------------------------------------
            'location.required'             => __('meeting.location').__('meeting.required'),
            'location.max'                  => "最大255文字を入力してください",
            // --------------------------------------------------------------
            'location_image_url.required'   => __('meeting.image_url').__('meeting.required'),
            'location_image_url.max'        => "最大255文字を入力してください",
            // --------------------------------------------------------------
        ]);
        // ------------------------------------------------------------------
    }

    public function filter(Request $request)
    {
        // Default configs
        $page = (int) $request->page ?? 1;

        // Base query
        // Select only columns from main table
        $query = Meeting::select('meetings.*')->with('user');

        // Search

        // Paginated result
        $result = simplePaginate($query, $page, $this->perpage);
        return response()->json($result);
    }

    public function resources()
    {
        // Add your resource data here
        // Usually for select options, etc

        $result = new \stdClass;

        return response()->json($result);
    }

    public function csvDownload(Request $request) {
        $data = $request->data;

        // ------------------------------------------------------------------
        //  Get template of csv
        // ------------------------------------------------------------------
        $url = public_path('csv/meeting-register-batch.csv');

        // ------------------------------------------------------------------
        //  open Handle of csv
        // ------------------------------------------------------------------
        $handle = fopen($url, 'w+');

        // ------------------------------------------------------------------
        //  set 1st line (header) of csv)
        // ------------------------------------------------------------------
        $csvArrHeader = [
            __('meeting.title'),
            __('meeting.user'),
            __('meeting.date'),
            __('meeting.location'),
            __('meeting.image_url'),
        ];

        // if there is no CONVERT_CSV var in .env, convert to SJIS-win
        if(empty(env('CONVERT_CSV'))){
            fputcsv($handle, mb_convert_encoding($csvArrHeader, 'SJIS-win', 'UTF-8'));
        }
        else{
            fputcsv($handle, $csvArrHeader);
        }

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return response()->download($url,'download_meeting_template.csv', $headers);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $data = new \stdClass;

        $status = true;
        $messageArray = [];

        try {
            // ------------------------------------------------------------------
            // Make default column name to index of array
            // ------------------------------------------------------------------
            $columnDb = [
                // --------------------------------------------------------------
                0   => "title",
                1   => "user_id",
                2   => "meeting_date",
                3   => "location",
                4   => "location_image_url",
                // --------------------------------------------------------------
            ];
            // ------------------------------------------------------------------

            // --------------------------------------------------------------
            // Validate file
            // --------------------------------------------------------------
            $rules = [
                'csv' => 'required|mimes:csv,txt'
            ];
            // --------------------------------------------------------------
            $messages = [
                'mimes'    => 'CSV形式ではないので取り込みできません。'
            ];
            // --------------------------------------------------------------

            if(isset($request->csv) && $request->csv!=="null"){

                // --------------------------------------------------------------
                // $request->validate($rules,$messages);
                $validator = Validator::make($request->all(), $rules, $messages);

                // --------------------------------------------------------------
                // If condition validation
                // --------------------------------------------------------------
                if($validator->fails()){
                    // ----------------------------------------------------------
                    $messageArray[] = (object)[
                        'line'  => null,
                        'error' => $validator->getMessageBag(),
                    ];
                    // ----------------------------------------------------------
                    return response()->json([
                        'status'    => false,
                        'message'   => $messageArray,
                    ], 400); // 400 being the HTTP code for an invalid request
                    // ----------------------------------------------------------
                }
                // --------------------------------------------------------------

                // --------------------------------------------------------------
                // Set Array
                // --------------------------------------------------------------
                $file = $request->csv;
                $dataArr = $this->csvToArray($file);
                // --------------------------------------------------------------

                // --------------------------------------------------------------
                // Check data if erray empty
                // --------------------------------------------------------------
                if(!$dataArr){
                    // ----------------------------------------------------------
                    $messageArray[] = (object)[
                        'line'  => null,
                        'error' => (object)[ 'errors' => [__('label.FAILED_CREATE_MESSAGE')] ],
                    ];
                    // ----------------------------------------------------------
                    $data->status = false;
                    $data->array = [];
                    $data->message = __('label.FAILED_CREATE_MESSAGE');
                    // ----------------------------------------------------------
                    return response()->json($data);
                    // ----------------------------------------------------------
                }
                // --------------------------------------------------------------

                $checkData = [];
                // --------------------------------------------------------------
                for( $i = 0; $i < count($dataArr); $i++ ){
                    // ----------------------------------------------------------
                    $line = $i + 1;
                    $setDataArr[$i] = [];
                    // ----------------------------------------------------------

                    // ----------------------------------------------------------
                    for( $arr = 0; $arr <= 4; $arr++ ){
                        // ------------------------------------------------------
                        $setDataArr[$i][$columnDb[$arr]] = $dataArr[$i][$arr];
                        // ------------------------------------------------------
                        if($dataArr[$i][$arr] == '' || $dataArr[$i][$arr] == null){
                            $setDataArr[$i][$columnDb[$arr]] = null;
                        }

                        // ------------------------------------------------------
                        // Set data date
                        // ------------------------------------------------------
                        if($arr == 2){
                            $date = $dataArr[$i][$arr];
                            if (str_contains($date, "'")) {
                                $date = str_replace("'","",$date);
                            }
                            $date = Carbon::parse($date);
                            $setDate = $dataArr[$i][$arr] ? $date->format('Y/m/d') : null;
                            $setDataArr[$i]['meeting_date'] = $setDate ? $setDate : null;
                        }
                    // ------------------------------------------------------

                    }
                    // ----------------------------------------------------------
                    // Set validate data
                    // ----------------------------------------------------------
                    $validator = $this->validationData($setDataArr[$i]);
                    // ----------------------------------------------------------

                    // ----------------------------------------------------------
                    // If condition
                    // ----------------------------------------------------------
                    if($validator->fails()){
                        $status = false;
                        $messageArray[] = (object)[
                            'line'  => $line,
                            'error' => $validator->getMessageBag()->toArray(),
                        ];
                    }
                    // ----------------------------------------------------------

                    array_push($checkData, $setDataArr[$i]);
                }
                // --------------------------------------------------------------

                // --------------------------------------------------------------
                // Send error response (400) if have status false
                // --------------------------------------------------------------
                if($status == false){
                    return response()->json([
                        'status'    => $status,
                        'array'     => [],
                        'message'   => $messageArray,
                    ], 400);
                }

                $insert = Meeting::insert($checkData);
            }

            //if evertying is fine
            DB::commit();
            return successResponse();
        } catch (Exception $e) {
            //rollback when error
            DB::rollback();
            // --------------------------------------------------------------
            $messageArray[] = (object)[
                'line'  => null,
                'error' => (object)[ 'errors' => [__('label.FAILED_CREATE_MESSAGE')] ],
            ];
            // --------------------------------------------------------------
            $data->array = [];
            $data->status = false;
            $data->message = $messageArray;
            // --------------------------------------------------------------
            return response()->json($data, 400);
            // --------------------------------------------------------------
        }
    }

    // ----------------------------------------------------------------------
    //  Convert csv to array
    // ----------------------------------------------------------------------
    private function csvToArray($filename = '', $delimiter = ','){
        // ------------------------------------------------------------------
        if (!file_exists($filename) || !is_readable($filename))
            return false;
        // ------------------------------------------------------------------
        $data = array();
        // if there is no CONVERT_CSV var in .env, convert to UTF-8 (from exported SJIS-win CSV file)
        if(empty(env('CONVERT_CSV'))){
            // change from sjis-win to utf-8
            $sjis = file_get_contents($filename);
            $utf8 = mb_convert_encoding($sjis, 'UTF-8', 'SJIS-win');
            file_put_contents('csv/meeting-import-with-utf8.csv', $utf8);

            if (($handle = fopen('csv/meeting-import-with-utf8.csv', 'r')) !== false)
            {
                $header = false;
                while (($row = fgetcsv($handle, 100000, $delimiter)) !== false)
                {
                    if($header) $data[] = $row;
                    $header = true;
                }
                fclose($handle);
            }
        }
        else {
            if (($handle = fopen($filename, 'r')) !== false)
            {
                $header = false;
                while (($row = fgetcsv($handle, 100000, $delimiter)) !== false)
                {
                    if($header) $data[] = $row;
                    $header = true;
                }
                fclose($handle);
            }
        }
        // ------------------------------------------------------------------
        return $data;
        // ------------------------------------------------------------------
    }
    // ----------------------------------------------------------------------

    public function exportCsv(Request $request) {
        $data = $request->all();

        //  Get template of csv
        $url = public_path('csv/meeting-import-with-utf8.csv');

        //  open Handle of csv
        $handle = fopen($url, 'w+');

        //  set 1st line (header) of csv)
        $csvArrHeader = [
            __('meeting.title'),
            __('meeting.user'),
            __('meeting.date'),
            __('meeting.location'),
            __('meeting.image_url'),
        ];

        // if there is no CONVERT_CSV var in .env, convert to SJIS-win
        if(empty(env('CONVERT_CSV'))){
            fputcsv($handle, mb_convert_encoding($csvArrHeader, 'SJIS-win', 'UTF-8'));
        }
        else{
            fputcsv($handle, $csvArrHeader);
        }

        //  generate necesarry data
        // ----------------------------------------------------------------------
        $meetingData = Meeting::all();

        foreach($meetingData as $result) {
            $csvArr = [
                0 => $result->title ?? '',
                1 => $result->user_id ?? '',
                2 => $result->meeting_date ?? '',
                3 => $result->location ?? '',
                4 => $result->location_image_url ?? '',
            ];

            // if there is no CONVERT_CSV var in .env, convert to SJIS-win
            if(empty(env('CONVERT_CSV'))){
                //fputcsv($handle, mb_convert_encoding($csvArr, 'SJIS-win', 'UTF-8'));
                fputcsv($handle, $csvArr);
            }
            else{
                fputcsv($handle, $csvArr);
            }
        }

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return response()->download($url, 'meeting_export.csv', $headers);

    }

    public function destroy($id)
    {
        Meeting::where('id', $id)->delete();
        return response()->json(true);
    }

}
