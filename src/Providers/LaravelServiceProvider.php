<?php

namespace Diviky\LaravelFormComponents\Providers;

use Diviky\LaravelFormComponents\FormDataBinder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class LaravelServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->console();
        }

        $this->bootBalde();

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'form-components');
    }

    protected function bootBalde(): self
    {
        $framework = config('form-components.framework');
        $prefix = config('form-components.prefix');

        Blade::directive('bind', function (mixed $bind) {
            return '<?php app(\Diviky\LaravelFormComponents\FormDataBinder::class)->bind(' . $bind . '); ?>';
        });

        Blade::directive('bound', function (string $name) {
            return '<?php echo app(\Diviky\LaravelFormComponents\FormDataBinder::class)->boundValue(' . $name . '); ?>';
        });

        Blade::directive('endbind', function () {
            return '<?php app(\Diviky\LaravelFormComponents\FormDataBinder::class)->pop(); ?>';
        });

        Blade::directive('wire', function (string|bool $modifier) {
            return '<?php app(\Diviky\LaravelFormComponents\FormDataBinder::class)->wire(' . $modifier . '); ?>';
        });

        Blade::directive('endwire', function () {
            return '<?php app(\Diviky\LaravelFormComponents\FormDataBinder::class)->endWire(); ?>';
        });

        Collection::make(config('form-components.components'))->each(
            function (array $component, string $alias) use ($prefix, $framework): void {
                $alias = $component['alias'] ?? $alias;
                if (isset($component['class'])) {
                    Blade::component($alias, $component['class'], $prefix);
                } else {
                    Blade::component(str_replace('{framework}', $framework, $component['view']), $alias, $prefix);
                }
            }
        );

        return $this;
    }

    protected function console(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/config.php' => config_path('form-components.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../resources/views' => base_path('resources/views/vendor/form-components'),
        ], 'views');
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'form-components');

        $this->app->singleton(FormDataBinder::class, fn () => new FormDataBinder);
    }
}
