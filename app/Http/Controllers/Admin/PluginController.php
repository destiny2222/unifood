<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PluginRequest;
use App\Models\Plugin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PluginController extends Controller
{
    public function index(){
        return view('admin.plugin.index');
    }
    
    public function  pluginStore(PluginRequest $request){
    try {
        if (Plugin::count()) {
            Plugin::first()->update($request->validated());
        }else{
            Plugin::create($request->validated());
        }
        return back()->with('success', 'Updated successfully');
    } catch (\Exception $exception) {
        Log::error($exception->getMessage());
        return back()->with('error', 'An error occurred');
    }
}
}
