<?php

if (!function_exists('is_active_route_val')) {
    /**
     * Return the String Value if this is a current route;
     *
     * @param array|string $routeNames
     * @param array|string $firstValues
     * @param array|string $nextValues
     * @return array|string
     */
    function is_active_route_val($routeNames, $firstValues, $nextValues)
    {
        if (!is_array($routeNames)) {
            $routeNames = [$routeNames];
        }

        if (!is_array($firstValues)) {
            $firstValues = [$firstValues];
        }

        if (!is_array($nextValues)) {
            $nextValues = [$nextValues];
        }

        foreach ($routeNames as $key => $routeName) {
            if (\Illuminate\Support\Facades\Route::currentRouteName() === $routeName) {
                return $firstValues[$key] ?? $firstValues[0];
            }
        }

        return $nextValues[0];
    }
}
