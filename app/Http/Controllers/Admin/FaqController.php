<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Faq\StoreRequest;

class FaqController extends Controller
{
    public function index(){
        $faq = Faq::orderBy('id', 'desc')->get();
        return view('admin.faq.index',[
            'faqs' => $faq,
        ]);
    }

    public function create(){
        return view('admin.faq.create');
    }

    public function store(StoreRequest $request){
        $validated = $request->validated();
        try {
            Faq::create($validated);
            return redirect()->route('admin.faq.index')->with('success', 'FAQ added successfully');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->route('admin.faq.index')->with('error', 'Something went wrong, please try again later');
        }
    }

    public function edit($id){
        $faq = Faq::find($id);
        return view('admin.faq.edit', compact('faq'));
    }

    public function update(StoreRequest $request, $id){
        $validated = $request->validated();
        try {
            $faq = Faq::findOrFail($id);
            $faq->update($validated);
            return redirect()->route('admin.faq.index')->with('success', 'FAQ updated successfully');
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return redirect()->route('admin.faq.index')->with('error', 'Something went wrong, please try again later');
        }
    }

    public function destroy($id){
        try {
            $faq = Faq::findOrFail($id);
            $faq->delete();
            return redirect()->route('admin.faq.index')->with('success', 'FAQ deleted successfully');

        }catch (\Exception $e){
            Log::error($e->getMessage());
            return redirect()->route('admin.faq.index')->with('error', 'Something went wrong, please try again later');
        }
    }
}
