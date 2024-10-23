<?php

namespace App\Routing;

use App\Tenant\TenantManager;
use Illuminate\Routing\Redirector as LaravelRedirector;

/**
 * Sobreescreve o redirect() padrão para utilizar account com multi tenant
 *
 * @author Eduardo
 */
class Redirector extends LaravelRedirector {

    public function routeTenant($name, $params = [], $status = 302, $headers = []) {
        $tenantManager = app(TenantManager::class);
        $tenantParam = $tenantManager->routeParam();
        return $this->route($name, $params + [
                    config('tenant.route_param') => $tenantParam
                        ], $status, $headers);
    }

}
