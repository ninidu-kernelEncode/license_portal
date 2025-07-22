<?php
use App\Models\Log;

function create_log(string $action, string $description = null, $model = null)
{
    Log::create([
        'user_id'     => auth()->id(),
        'action'      => $action,
        'description' => $description,
        'model'       => $model ? class_basename($model) : null,
        'model_id'    => $model->id ?? null,
        'ip_address'  => request()->ip(),
        'user_agent'  => request()->userAgent(),
    ]);
}
