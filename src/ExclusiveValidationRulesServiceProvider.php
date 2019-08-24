<?php

namespace Thedavefulton\LaravelExclusiveValidationRules;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ExclusiveValidationRulesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        Validator::extendImplicit('required_exclusive', function ($attribute, $value, $parameters, $validator) {
            $validator->requireParameterCount(1, $parameters, 'required_exclusive');

            $data = $validator->getData();
            $count = collect($parameters)
                ->filter(function ($parameter) use ($data) {
                    return array_key_exists($parameter, $data);
                })
                ->filter(function ($parameter) use ($validator, $data) {
                    return $validator->validateRequired($parameter, $data[$parameter]);
                })->count();

            if (! $validator->validateRequired($attribute, $value)) {
                return $count === 1;
            }

            if ($validator->validateRequired($attribute, $value)) {
                return $count === 0;
            }
        });

        Validator::replacer('required_exclusive', function ($message, $attribute, $rule, $parameters) {
            // dd($message, $attribute, $rule, $parameters);
            $fields = collect($parameters)
                ->push($attribute)
                ->sort()
                ->implode(', ');

            return "You must submit exactly one of: {$fields}";
        });

        Validator::extendImplicit('optional_exclusive', function ($attribute, $value, $parameters, $validator) {
            $validator->requireParameterCount(1, $parameters, 'required_exclusive');

            $data = $validator->getData();
            $count = collect($parameters)
                ->filter(function ($parameter) use ($data) {
                    return array_key_exists($parameter, $data);
                })
                ->filter(function ($parameter) use ($validator, $data) {
                    return $validator->validateRequired($parameter, $data[$parameter]);
                })->count();

            if (! $validator->validateRequired($attribute, $value)) {
                return $count === 0 || $count === 1;
            }

            if ($validator->validateRequired($attribute, $value)) {
                return $count === 0;
            }
        });

        Validator::replacer('optional_exclusive', function ($message, $attribute, $rule, $parameters) {
            // dd($message, $attribute, $rule, $parameters);
            $fields = collect($parameters)
                ->push($attribute)
                ->sort()
                ->implode(', ');

            return "You must submit exactly one or none of: {$fields}";
        });
    }
}
