<?php

namespace Dev\Backup\Http\Requests;

use Dev\Support\Http\Requests\Request;

class BackupRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:250'],
            'backup_only_db' => ['nullable', 'boolean'],
        ];
    }
}
