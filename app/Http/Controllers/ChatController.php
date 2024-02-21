<?php

namespace App\Http\Controllers;

use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use App\Models\DocProfile;
use App\Models\Symptoms;
use App\Models\DocFieldSpecialization;
use App\Models\Specialzation;
use DB;
use PHPUnit\Event\TestRunner\EventFacadeSealedSubscriber;

 class ChatController extends Controller
{
    public function fetchResponse(Request $request)
{
    try {
        // Get user message
        $userMessage = $request->input('userMessage');

        // Fetch health-related keywords and their IDs from the database
        $healthKeywords = Symptoms::all(['id', 'symptoms']);

        // Check if the user's message contains health-related keywords
        $matchingKeywords = [];
        foreach ($healthKeywords as $keyword) {
            $containsKeyword = strpos(strtolower($userMessage), strtolower($keyword->symptoms)) !== false;

            if ($containsKeyword) {
                $matchingKeywords[] = $keyword->symptoms;
            }
        }

        $response = null; // Initialize $response variable
        $responseContent = ''; // Initialize $responseContent variable

        if (!empty($matchingKeywords)) {
            // Assuming you want to use the first matching keyword for the OpenAI request
            $selectedKeyword = $matchingKeywords[0];

            // Use $selectedKeyword in the OpenAI request
            $response = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'how can i assist you today?'],
                    ['role' => 'user', 'content' => $userMessage],
                ],
            ]);
            Log::info('OpenAI API Response: ' . json_encode($response));

            // Fetch specialization name based on the symptom
            $specializationName = DB::table('symptoms')
            ->join('doc_field_specilizations', 'symptoms.id', '=', 'doc_field_specilizations.symptom_id')
            ->join('specializations', 'doc_field_specilizations.specialization_id', '=', 'specializations.id')
            ->where('symptoms.symptoms', $selectedKeyword)
            ->value('specializations.specializations');

            Log::info($specializationName);
            // Fetch doctors with the specified specialization
            $specialization = DB::table('doc_field_specilizations')
                ->join('specializations', 'doc_field_specilizations.specialization_id', '=', 'specializations.id')
                ->join('doc_profiles', 'specializations.id', '=', 'doc_profiles.specializations_id')
                ->join('symptoms', 'symptoms.id', '=', 'doc_field_specilizations.symptom_id')
                ->where('symptoms.symptoms', $selectedKeyword)
                ->get();




            if ($specialization->isNotEmpty()) {
                $recommendedDoctors = [];

                foreach ($specialization as $data) {
                    // Determine specialization name based on the symptom or use a default value
                    $doctorSpecializationName = $specializationName ?: strtoupper($data->specializations);

                    $doctorInfo = "<br>Doctor: " . strtoupper("{$data->firstname} {$data->middlename} {$data->lastname}") . "\nSpecialization: " . $doctorSpecializationName . "\n";
                    $doctorInfo .= "\n\n <button><a href='" . route('user.viewDoctorsCreds', ['id' => $data->u_id]) . "' id='view-profile-link'>View</a> </button> <br>\n";

                    $recommendedDoctors[] = $doctorInfo;
                }

                $responseContent = "Recommended Doctors based on your symptoms:\n" . implode("\n", $recommendedDoctors) . "\n\n";
            } else {
                // Handle the case where no doctors with the specified specialization are found
                $responseContent = "As of now, there are no registered specialists in the system for the provided symptom.\nYou can still checkout or seek an appointment with our available doctors.";
            }
        } else {
            // Handle the case where no matching keywords are found
            $responseContent = [
                "Sorry for the inconvenience! I, NotBAyMaX, was programmed to answer health-related content only.",
                "Please try asking something about how you are feeling, any SYMPTOMS?",
                "Thank you for understanding! But here you can still see the list of available doctors and their schedules."
            ];
        }

        $systemResponse = [
            $response ? $response->choices[0]->message->content : 'Default system message',
            is_array($responseContent) ? implode("\n", $responseContent) : $responseContent
        ];

        return response()->json(['response' => $systemResponse]);
    } catch (\Exception $e) {
        Log::error('Error making OpenAI API request: ' . $e->getMessage());
        return response()->json(['error' => 'Error making OpenAI API request'], 500);
    }
}




}
