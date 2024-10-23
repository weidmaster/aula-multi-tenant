<?php

namespace App\Scopes;

use App\Tenant\TenantManager;
use Illuminate\Database\Eloquent\Model;

/*
 * Possibilita isolar o escopo da model por tenant
 */

trait TenantModels {

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new TenantScope());

        //evento antes de criar o model
        static::creating(function(Model $model) {
            $tenantManager = app(TenantManager::class);
            if ($tenantManager->getTenant()) {
                $accountId = $tenantManager->getTenant()->id;
                $model->account_id = $accountId;
            }
        });
    }

}
