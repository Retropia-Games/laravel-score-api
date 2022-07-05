<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Project;
use App\Helpers\Encryption;

class EnsureEncryptedDataIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->data && strlen($request->data) < 1) {
            return response()->json([
                'status' => 'Error'
            ], 400);
        }

        $project = Project::where('name', $request->route()->name)
            ->firstOrFail();

        $iv = env("ENCRYPTION_IV");

        $decrypted = trim(Encryption::decrypt($request->data, $project->encryption_key, $iv));
        $data = json_decode($decrypted, true);

        if (is_null($data)) {
            return response()->json([
                'status' => 'Error'
            ], 400);
        }

        // Append project_id
        $data['project_id'] = $project->id;

        $request->attributes->add(['data' => $data]);

        return $next($request);
    }
}
