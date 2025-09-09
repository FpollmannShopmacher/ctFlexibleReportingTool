<?php

namespace App\Services;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use JsonException;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportService
{
    public function convertJsonToCsv($jsonData): JsonResponse|StreamedResponse
    {
        $data = json_decode($jsonData, true);

        if (empty($data)) {
            return response()->json(['error' => 'No data to export'], 400);
        }

        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="statistics.csv"', 'Pragma' => 'no-cache', 'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0', 'Expires' => '0'];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['key', 'day', 'week', 'month', 'year', 'all']);

            foreach ($data as $key => $values) {
                fputcsv($file, array_merge([$key], $values));
            }

            fclose($file);
        };

        try {
            return Response::streamDownload($callback, 'statistics.csv', $headers);
        } catch (Exception $e) {
            Log::error('CSV export failed: '.$e->getMessage());

            return response()->json(['error' => 'CSV export failed'], 500);
        }
    }

    public function handleJsonDownload(string $jsonObjects): JsonResponse
    {
        $formattedJson = str_contains($jsonObjects, '[]') ? str_replace('[]', '', $jsonObjects) : $jsonObjects;

        try {
            $decodedJson = json_decode($formattedJson, true, 512, JSON_THROW_ON_ERROR);

            return response()->json($decodedJson, 200, [], JSON_PRETTY_PRINT);
        } catch (JsonException $e) {
            Log::error('JSON parsing failed: '.$e->getMessage());

            return response()->json(['error' => 'JSON parsing failed'], 400);
        }
    }

    public function downloadStatisticsPdf(string $jsonObjects)
    {
        $data = json_decode($jsonObjects, true);
        return Pdf::loadView('pdf', ['stats' => $data])->download('statistics.pdf');
    }
}
