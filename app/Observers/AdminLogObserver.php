<?php

namespace App\Observers;

use App\Models\AdminLog;

class AdminLogObserver
{
    protected function adminId(): ?int
    {
        return auth('web')->id();
    }

    protected function log($action, $model)
    {
        // منع loop
        if ($model instanceof AdminLog) return;

        AdminLog::create([
            'admin_id' => $this->adminId(),
            'action' => $action,
            'model' => get_class($model),
            'description' => "تم {$action} " . get_class($model),
        ]);
    }

    public function created($model)
    {
        $this->log('create', $model);
    }

    public function updated($model)
    {
        $this->log('update', $model);
    }

    public function deleted($model)
    {
        $this->log('delete', $model);
    }
}
