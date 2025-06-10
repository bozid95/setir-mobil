<?php

require_once 'vendor/autoload.php';

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🧪 TESTING INSTALLMENT ROUTE\n";
echo "=" . str_repeat("=", 50) . "\n\n";

try {
    // Test 1: Check if route exists
    echo "1️⃣ Testing route existence...\n";

    try {
        $url = route('filament.admin.resources.installments.index');
        echo "   ✅ Route exists: {$url}\n";
    } catch (\Exception $e) {
        echo "   ❌ Route does not exist: " . $e->getMessage() . "\n";

        // Try alternative routes
        $alternativeRoutes = [
            'filament.admin.resources.installments.list',
            'filament.admin.resources.installment.index',
            'filament.admin.installments.index'
        ];

        foreach ($alternativeRoutes as $route) {
            try {
                $url = route($route);
                echo "   ✅ Alternative route found: {$route} -> {$url}\n";
                break;
            } catch (\Exception $e) {
                echo "   ❌ Alternative route {$route} not found\n";
            }
        }
    }

    // Test 2: Check if InstallmentResource is loaded
    echo "\n2️⃣ Testing InstallmentResource class...\n";

    if (class_exists('App\Filament\Resources\InstallmentResource')) {
        echo "   ✅ InstallmentResource class exists\n";

        $reflection = new ReflectionClass('App\Filament\Resources\InstallmentResource');
        echo "   📁 File: " . $reflection->getFileName() . "\n";

        // Check methods
        if ($reflection->hasMethod('getPages')) {
            $pages = $reflection->getMethod('getPages');
            $pages->setAccessible(true);
            $pagesArray = $pages->invoke(null);
            echo "   📄 Pages configured:\n";
            foreach ($pagesArray as $name => $page) {
                echo "      - {$name}: " . get_class($page) . "\n";
            }
        }
    } else {
        echo "   ❌ InstallmentResource class not found\n";
    }

    // Test 3: Manual URL construction
    echo "\n3️⃣ Testing manual URL construction...\n";

    $manualUrl = url('/admin/installments');
    echo "   🔗 Manual URL: {$manualUrl}\n";

    $manualUrlWithFilter = url('/admin/installments?tableFilters[finance_id][value]=1');
    echo "   🔗 Manual URL with filter: {$manualUrlWithFilter}\n";

    // Test 4: Check all registered routes
    echo "\n4️⃣ Searching for installment-related routes...\n";

    $router = app('router');
    $routes = $router->getRoutes()->getRoutes();

    $installmentRoutes = [];
    foreach ($routes as $route) {
        $name = $route->getName();
        $uri = $route->uri();

        if ($name && (strpos($name, 'installment') !== false || strpos($uri, 'installment') !== false)) {
            $installmentRoutes[] = [
                'name' => $name,
                'uri' => $uri,
                'methods' => implode('|', $route->methods())
            ];
        }
    }

    if (!empty($installmentRoutes)) {
        echo "   ✅ Found installment routes:\n";
        foreach ($installmentRoutes as $route) {
            echo "      - {$route['methods']} {$route['uri']} [{$route['name']}]\n";
        }
    } else {
        echo "   ❌ No installment routes found\n";
    }

    echo "\n🎯 RECOMMENDATION:\n";
    if (!empty($installmentRoutes)) {
        echo "   ✅ Use manual URL construction: url('/admin/installments')\n";
        echo "   ✅ Or fix the exact route name based on found routes above\n";
    } else {
        echo "   ❌ InstallmentResource may not be properly registered\n";
        echo "   🔧 Check AdminPanelProvider resource discovery\n";
    }
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "📍 File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}
