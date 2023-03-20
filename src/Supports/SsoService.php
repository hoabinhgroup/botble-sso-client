<?php

namespace Botble\SsoLogin\Supports;

class SsoService
{
    /**
     * @param string | array $model
     * @return $this
     */
    public function registerModule($model): self
    {
        if (!is_array($model)) {
            $model = [$model];
        }
        config([
            'plugins.sso-login.general.supported' => array_merge(config('plugins.sso-login.general.supported', []), $model),
        ]);

        return $this;
    }

    /**
     * @return array
     */
    public function supportedModules()
    {
        return config('plugins.sso-login.general.supported', []);
    }

    /**
     * @return array
     */
    public function isSupportedModule(string $model): bool
    {
        return in_array($model, $this->supportedModules());
    }
}
