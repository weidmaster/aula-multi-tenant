<?php

/*
 * Define o escopo global por tenant aos modelos do Eloquent
 */

namespace App\Scopes;

use App\Tenant\TenantManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Apply the scope to a given Eloquent query builder
 *
 * @param \Illuminate\Database\Eloquent\Bulder $builder
 * @param Model $model
 * @return void
 */
class TenantScope implements Scope {

    public function apply(Builder $builder, Model $model) {
        $tenantManager = app(TenantManager::class);
        if ($tenantManager->getTenant()) {
            $accountId = $tenantManager->getTenant()->id;
            $builder->where('account_id', $accountId);
        }
    }

}
