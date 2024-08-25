<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WaterLevel;
use App\Models\WaterQuality;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WaterLevelController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function getWaterLevel()
    {
        $latestWaterLevel = WaterLevel::latest()->first();
        $latestWaterQuality = WaterQuality::latest()->first();

        if (!$latestWaterLevel || !$latestWaterQuality) {
            return response()->json([
                'level' => null,
                'ph_air' => null,
                'kekeruhan_air' => null,
                'status' => 'No data available'
            ]);
        }

        $level = $latestWaterLevel->level;
        $ph_air = $latestWaterQuality->ph_air;
        $kekeruhan_air = $latestWaterQuality->kekeruhan_air;
        $status = $this->getLevelStatus($level);

        return response()->json([
            'level' => $level,
            'ph_air' => $ph_air,
            'kekeruhan_air' => $kekeruhan_air,
            'status' => $status
        ]);
    }

    public function store(Request $request)
    {
        \Log::info('Request Data: ', $request->all());

        // Validate and store data based on the presence of fields
        if ($request->has('level') && !$request->has('ph_air') && !$request->has('kekeruhan_air')) {
            // Format 1: { "level": 123 }
            $request->validate([
                'level' => 'required|numeric'
            ]);

            // Simpan data level air
            $waterLevel = new WaterLevel();
            $waterLevel->level = $request->level;
            $waterLevel->created_at = Carbon::now('Asia/Jakarta');
            $waterLevel->save();

            $this->checkAndSendNotification($waterLevel);
            return response()->json([
                'message' => 'Water level recorded successfully',
                'data' => [
                    'water_level' => $waterLevel
                ]
            ]);
        } elseif ($request->has('ph_air') && $request->has('kekeruhan_air')) {
            // Format 2: { "ph_air": 7.0, "kekeruhan_air": 50 }
            $request->validate([
                'ph_air' => 'required|numeric',
                'kekeruhan_air' => 'required|numeric'
            ]);

            // Simpan data kualitas air
            $waterQuality = new WaterQuality();
            $waterQuality->ph_air = $request->ph_air;
            $waterQuality->kekeruhan_air = $request->kekeruhan_air;
            $waterQuality->created_at = Carbon::now('Asia/Jakarta');
            $waterQuality->save();

            return response()->json([
                'message' => 'Water quality recorded successfully',
                'data' => [
                    'water_quality' => $waterQuality
                ]
            ]);
        } else {
            // Invalid request format
            return response()->json([
                'message' => 'Invalid request format'
            ], 400);
        }
    }

    public function getWaterLevelData()
    {
        $latestWaterLevel = WaterLevel::latest()->first();
        $latestWaterQuality = WaterQuality::latest()->first();

        if (!$latestWaterLevel || !$latestWaterQuality) {
            return response()->json([
                'level' => null,
                'ph_air' => null,
                'kekeruhan_air' => null,
                'status' => 'No data available',
                'chart_data' => []
            ]);
        }

        $level = $latestWaterLevel->level;
        $ph_air = $latestWaterQuality->ph_air;
        $kekeruhan_air = $latestWaterQuality->kekeruhan_air;
        $status = $this->getLevelStatus($level);

        $chartData = WaterLevel::select('level', DB::raw('DATE_FORMAT(created_at, "%H:%i:%s") as time'))
            ->orderBy('created_at', 'desc')
            ->take(15)
            ->get()
            ->sortBy('created_at');

        $data = [];
        foreach ($chartData as $chartDatum) {
            $data[] = [
                'time' => $chartDatum->time,
                'level' => $chartDatum->level,
            ];
        }

        return response()->json([
            'level' => $level,
            'ph_air' => $ph_air,
            'kekeruhan_air' => $kekeruhan_air,
            'status' => $status,
            'chart_data' => $data
        ]);
    }

    public function getWaterQualityData()
    {
        // Ambil data pH air dan kekeruhan air terbaru
        $latestWaterQuality = WaterQuality::latest()->first();

        // Cek apakah data ada
        if (!$latestWaterQuality) {
            return response()->json([
                'ph_air' => null,
                'kekeruhan_air' => null,
                'status' => 'No data available',
                'timestamp' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
            ]);
        }

        $ph_air = $latestWaterQuality->ph_air;
        $kekeruhan_air = $latestWaterQuality->kekeruhan_air;
        $status = $this->getWaterQualityStatus($ph_air, $kekeruhan_air);

        return response()->json([
            'ph_air' => $ph_air,
            'kekeruhan_air' => $kekeruhan_air,
            'status' => $status,
            'timestamp' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
        ]);
    }

    public function getWaterQualityStatus($ph_air, $kekeruhan_air)
    {
        if ($kekeruhan_air >= 50 && $kekeruhan_air <= 300 && $ph_air >= 6.5 && $ph_air <= 8.5) {
            return "Layak Minum";
        } else {
            return "Tidak Layak Minum";
        }
    }

    public function history(Request $request)
    {
        // Water Level Query
        $waterLevelQuery = WaterLevel::orderBy('created_at', 'desc');

        if ($request->has('date') && $request->input('date')) {
            $date = Carbon::parse($request->input('date'))->format('Y-m-d');
            $waterLevelQuery->whereDate('created_at', $date);
        }

        if ($request->has('start_time') && $request->input('start_time')) {
            $startTime = Carbon::parse($request->input('start_time'))->format('H:i:s');
            $waterLevelQuery->whereTime('created_at', '>=', $startTime);
        }

        if ($request->has('end_time') && $request->input('end_time')) {
            $endTime = Carbon::parse($request->input('end_time'))->format('H:i:s');
            $waterLevelQuery->whereTime('created_at', '<=', $endTime);
        }

        if ($request->has('status') && $request->input('status')) {
            $status = $request->input('status');
            $waterLevelQuery->where('status', $status);
        }

        $waterLevels = $waterLevelQuery->get()->transform(function ($waterLevel, $key) {
            $ketinggianAir = 84 - $waterLevel->level;
            $volume = $this->calculateVolume($ketinggianAir);

            $waterLevel->tanggal = Carbon::parse($waterLevel->created_at)->format('Y-m-d');
            $waterLevel->waktu = Carbon::parse($waterLevel->created_at)->timezone('Asia/Jakarta')->format('H:i:s');
            $waterLevel->ketinggian_air = round($ketinggianAir, 2);
            $waterLevel->volume = round($volume, 2);
            $waterLevel->status = $this->getLevelStatus($waterLevel->level);
            return $waterLevel;
        });

        // Water Quality Query
        $waterQualityQuery = WaterQuality::orderBy('created_at', 'desc');
        $waterQualities = $waterQualityQuery->get()->transform(function ($waterQuality, $key) {
            $waterQuality->tanggal = Carbon::parse($waterQuality->created_at)->format('Y-m-d');
            $waterQuality->waktu = Carbon::parse($waterQuality->created_at)->timezone('Asia/Jakarta')->format('H:i:s');
            $waterQuality->status = $this->getWaterQualityStatus($waterQuality->ph_air, $waterQuality->kekeruhan_air);
            return $waterQuality;
        });

        return view('history', [
            'waterLevels' => $waterLevels,
            'waterQualities' => $waterQualities,
        ]);
    }




    private function getLevelStatus($level)
    {
        $maxHeight = 84; // Tinggi maksimum sumur dalam meter

        if ($level < 0.40 * $maxHeight) {
            return "AMAN"; // H < 33.6 meter
        } elseif ($level < 0.60 * $maxHeight) {
            return "RAWAN"; // 33.6 ≤ H < 50.4 meter
        } elseif ($level < 0.80 * $maxHeight) {
            return "KRITIS"; // 50.4 ≤ H < 67.2 meter
        } else {
            return "RUSAK"; // H ≥ 67.2 meter
        }
    }

    private function checkAndSendNotification($waterLevel)
    {
        $level = $waterLevel->level;
        $maxHeight = 84; // Tinggi maksimum sumur dalam meter

        if ($level >= 0.60 * $maxHeight && $level < 0.80 * $maxHeight) {
            // Notifikasi untuk level KRITIS
            $message = "*[PERHATIAN] Ketinggian Air Kritis*\n--------------------\nSumur PAM Sagara di Desa Sindangkerta\n\nKetinggian air sumur telah mencapai level kritis:\n- Jarak dari permukaan tanah ke permukaan air : {$level} meter\n\nMohon segera cek kondisi sumur untuk memastikan pasokan air tetap tersedia.\n\nTerima kasih.";
            $this->sendNotificationMultipleTimes($message, 1);
        } elseif ($level >= 0.80 * $maxHeight) {
            // Notifikasi untuk level RUSAK
            $message = "*[PERHATIAN] Ketinggian Air RUSAK*\n--------------------\nSumur PAM Sagara di Desa Sindangkerta\n\nKetinggian air sumur telah mencapai level rusak:\n- Jarak dari permukaan tanah ke permukaan air: {$level} meter\n\nMohon segera ambil langkah yang telah dipersiapkan karena sumur sudah tidak layak digunakan.\n\nTerima kasih.";
            $this->sendNotificationMultipleTimes($message, 1);
        }
    }


    private function sendNotificationMultipleTimes($message, $times)
    {
        for ($i = 0; $i < $times; $i++) {
            $this->sendWhatsAppNotification($message);
        }
    }

    private function sendWhatsAppNotification($message)
    {
        $apiKey = 'MzsBRot-qygPthpnnvmE'; // Ganti dengan API key Fonnte Anda
        $phoneNumber = '089622116268'; // Nomor WhatsApp tujuan

        // Prepare data for WhatsApp notification
        $postData = json_encode([
            'target' => $phoneNumber,
            'message' => $message,
            'countryCode' => '62' // Optional: adjust according to your needs
        ]);

        // Send WhatsApp notification using cURL
        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $postData,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: ' . $apiKey,
                    'Content-Type: application/json'
                ),
            )
        );

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            \Log::error('Error sending WhatsApp notification: ' . $err);
        } else {
            \Log::info('WhatsApp notification sent successfully. Response: ' . $response);
        }
    }
    public function downloadReport(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        if (!$startDate || !$endDate) {
            return redirect()->back()->withErrors('Please provide both start and end dates.');
        }

        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        $data = WaterLevel::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'asc')
            ->get();

        $fileName = 'report-' . Carbon::now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $columns = ['No', 'Tanggal', 'Waktu', 'Jarak', 'Ketinggian Air', 'Volume', 'pH Air', 'Kekeruhan Air', 'Status'];

        $callback = function () use ($data, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($data as $index => $record) {
                $ketinggianAir = 84 - $record->level; // Calculate water level
                $volume = $this->calculateVolume($ketinggianAir); // Calculate volume

                $row = [
                    $index + 1,
                    Carbon::parse($record->created_at)->format('Y-m-d'),
                    Carbon::parse($record->created_at)->format('H:i:s'),
                    $record->level . ' Meter',
                    $ketinggianAir . ' Meter',
                    $volume . ' Liter',
                    $record->ph_air, // pH Air
                    $record->kekeruhan_air . ' PPM',
                    $this->getLevelStatus($record->level),
                ];
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function getChartData(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        if (!$startDate || !$endDate) {
            return response()->json(['error' => 'Please provide both start and end dates.'], 400);
        }

        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        $data = WaterLevel::select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(level) as average_level'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => Carbon::parse($item->date)->format('Y-m-d'),
                    'average_level' => $item->average_level,
                ];
            });

        return response()->json($data);
    }
    private function calculateVolume($height)
    {
        $radius = 0.075; // 82.5 mm diubah menjadi meter
        $volumeInCubicMeters = 3.141592653589793 * pow($radius, 2) * $height; // Volume dalam meter kubik
        $volumeInLiters = $volumeInCubicMeters * 1000; // Ubah ke liter
        return $volumeInLiters;
    }

    public function searchByStatus(Request $request)
    {
        $status = $request->input('status');

        // Query database for the status
        $allLevels = WaterLevel::where('status', $status)->get();

        return view('history', compact('allLevels'));
    }

    public function getLatestData()
    {
        $latestLevel = WaterLevel::latest()->first();
        $latestQuality = WaterQuality::latest()->first();

        return response()->json([
            'level' => $latestLevel->level ?? null,
            'ph_air' => $latestQuality->ph_air ?? null,
            'kekeruhan_air' => $latestQuality->kekeruhan_air ?? null,
            'status' => $this->getLevelStatus($latestLevel->level ?? null),
            'timestamp' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
        ]);
    }
}
