<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class SystemController extends Controller
{
    /**
     * Show the system management dashboard
     */
    public function index()
    {
        $systemInfo = $this->getSystemInfo();
        return view('admin.system.index', compact('systemInfo'));
    }

    /**
     * Clear all caches
     */
    public function clearAllCache()
    {
        try {
            // Clear application cache
            Artisan::call('cache:clear');
            
            // Clear config cache
            Artisan::call('config:clear');
            
            // Clear route cache
            Artisan::call('route:clear');
            
            // Clear view cache
            Artisan::call('view:clear');
            
            // Clear compiled views
            Artisan::call('view:clear');
            
            // Clear event cache
            Artisan::call('event:clear');
            
            return redirect()->back()->with('success', 'All caches cleared successfully!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error clearing caches: ' . $e->getMessage());
        }
    }

    /**
     * Clear application cache only
     */
    public function clearAppCache()
    {
        try {
            Artisan::call('cache:clear');
            Cache::flush();
            
            return redirect()->back()->with('success', 'Application cache cleared successfully!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error clearing application cache: ' . $e->getMessage());
        }
    }

    /**
     * Clear config cache
     */
    public function clearConfigCache()
    {
        try {
            Artisan::call('config:clear');
            
            return redirect()->back()->with('success', 'Config cache cleared successfully!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error clearing config cache: ' . $e->getMessage());
        }
    }

    /**
     * Clear route cache
     */
    public function clearRouteCache()
    {
        try {
            Artisan::call('route:clear');
            
            return redirect()->back()->with('success', 'Route cache cleared successfully!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error clearing route cache: ' . $e->getMessage());
        }
    }

    /**
     * Clear view cache
     */
    public function clearViewCache()
    {
        try {
            Artisan::call('view:clear');
            
            return redirect()->back()->with('success', 'View cache cleared successfully!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error clearing view cache: ' . $e->getMessage());
        }
    }

    /**
     * Optimize application (cache config, routes, views)
     */
    public function optimizeApp()
    {
        try {
            // Clear all caches first
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            
            // Then optimize
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            Artisan::call('view:cache');
            
            return redirect()->back()->with('success', 'Application optimized successfully!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error optimizing application: ' . $e->getMessage());
        }
    }

    /**
     * Clear logs
     */
    public function clearLogs()
    {
        try {
            $logPath = storage_path('logs');
            $files = File::glob($logPath . '/*.log');
            
            foreach ($files as $file) {
                File::delete($file);
            }
            
            return redirect()->back()->with('success', 'Logs cleared successfully!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error clearing logs: ' . $e->getMessage());
        }
    }

    /**
     * Get system information for display in view
     */
    private function getSystemInfo()
    {
        return [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'memory_usage' => memory_get_usage(true),
            'memory_peak' => memory_get_peak_usage(true),
            'cache_driver' => config('cache.default'),
            'session_driver' => config('session.driver'),
            'queue_driver' => config('queue.default'),
        ];
    }
}