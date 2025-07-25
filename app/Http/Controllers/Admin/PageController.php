<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AboutPage\StoreRequest as AboutPageStoreRequest;
use App\Http\Requests\Admin\Advertisement\StoreRequest;
use App\Http\Requests\Admin\AppSection\StoreRequest as AppSectionStoreRequest;
use App\Http\Requests\Admin\ContactPage\StoreRequest as ContactPageStoreRequest;
use App\Http\Requests\Admin\Counter\StoreRequest as CounterStoreRequest;
use App\Http\Requests\Admin\PluginRequest;
use App\Http\Requests\Admin\Policy\StoreRequest as PolicyStoreRequest;
use App\Http\Requests\Admin\Service\StoreRequest as ServiceStoreRequest;
use App\Http\Requests\Admin\Terms\StoreRequest as TermsStoreRequest;
use App\Http\Requests\Admin\WhyChoose\StoreRequest as WhyChooseStoreRequest;
use App\Models\AboutPage;
use App\Models\Advertisement;
use App\Models\AppSection;
use App\Models\ContactPage;
use App\Models\Counter;
use App\Models\Plugin;
use App\Models\Policy;
use App\Models\Service;
use App\Models\Terms;
use App\Models\WhyChooseUS;
use App\Traits\CloudinaryUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PageController extends Controller
{
    use CloudinaryUploadTrait;
    public function AboutPage(){
        $whyChoose = WhyChooseUS::first();
        $about = AboutPage::first();
        return view('admin.pages.about.index', [
            'whyChoose'=>$whyChoose,
            'about'=>$about,
        ]);
    }


    public function aboutStore(AboutPageStoreRequest $request){
        $validated = $request->validated();
        try {
            $imageName = null;
            if ($request->hasFile('image')) {
                $imageName = $this->uploadImageToCloudinary($request->file('image'), 'mightyolu/upload/about-us');
                // $image = $request->file('image');
                // $imageName = time() . '.' . $image->getClientOriginalExtension();
                
                // $manager = new ImageManager(new Driver());
                // $processedImage = $manager->read($image);
                // $processedImage->resize(400, 250);
                // $processedImage->save(public_path('upload/about-us/') . $imageName);
            }
            $existingImage = AboutPage::first();
            $validated['image'] = $imageName['secure_url'] ?? $existingImage->image;
            if (AboutPage::count()) {
                AboutPage::first()->update($validated);
            } else {
                AboutPage::create($validated);
            }
            return back()->with('success', ' Updated successfully');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went worry');
        }
    }

    public function advertisementPage(){
        $advertisement = Advertisement::orderBy('id', 'desc')->get();
        return view('admin.pages.advertisement.index', [
            'advertisements'=>$advertisement
        ]);
    }

    public function advertisementCreate(){
        return view('admin.pages.advertisement.create');
    }

    public function advertisementEdit($id){
        try {
            $advertisement = Advertisement::findOrFail($id);
            return view('admin.pages.advertisement.edit', compact('advertisement'));
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went worry');
        }
    }

    public function advertisementStore(StoreRequest $request){
        $validated = $request->validated();
        try {
            $imageName = null;
            if ($request->hasFile('image')) {
                $imageName = $this->uploadImageToCloudinary($request->file('image'), 'mightyolu/upload/advertisement');
                // $image = $request->file('image');
                // $imageName = time() . '.' . $image->getClientOriginalExtension();
                
                // $manager = new ImageManager(new Driver());
                // $processedImage = $manager->read($image);
                // $processedImage->resize(400, 250);
                // $processedImage->save(public_path('upload/advertisement/') . $imageName);
            }
            $validated['image'] = $imageName['secure_url'];
            Advertisement::updateOrCreate($validated);
            return redirect()->route('admin.advertisement.index')->with('success', 'Successful!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went worry');
        }
    }

    public function advertisementUpdate(StoreRequest $request, $id){
        $validated = $request->validated();
        try {
            $imageName = null;
            if ($request->hasFile('image')) {
                $imageName = $this->uploadImageToCloudinary($request->file('image'), 'mightyolu/upload/advertisement');
                // $image = $request->file('image');
                // $imageName = time() . '.' . $image->getClientOriginalExtension();
                
                // $manager = new ImageManager(new Driver());
                // $processedImage = $manager->read($image);
                // $processedImage->resize(400, 250);
                // $processedImage->save(public_path('upload/advertisement/') . $imageName);
            }
            $advertisement = Advertisement::findOrFail($id);
            $validated['image'] = $imageName['secure_url'] ?? $advertisement->image;
            $advertisement->update($validated);
            return redirect()->route('admin.advertisement.index')->with('success', 'Successful!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went worry');
        }
    }


    public function advertisementDelete($id){
        try{
            $advertisement = Advertisement::findOrFail($id);
            $advertisement->delete();
            return back()->with('success', 'Successful!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went worry');
        }
    }

    public function AppSectionPage(){
        $appsection = AppSection::first();
        return view('admin.pages.appsection.index', compact('appsection'));
    }

    public function AppSectionStore(AppSectionStoreRequest $request){
        $validated = $request->validated();
        try {
            $appsection = AppSection::first();
            $imageName = null;
            if ($request->hasFile('background_image')) {
                $imageName = $this->uploadImageToCloudinary($request->file('background_image'), 'mightyolu/upload/appsection');
                // $image = $request->file('background_image');
                // $imageName = time() . '.' . $image->getClientOriginalExtension();
                
                // $manager = new ImageManager(new Driver());
                // $processedImage = $manager->read($image);
                // $processedImage->resize(1300, 600);
                // $processedImage->save(public_path('upload/appsection/') . $imageName);
            }
            $fileName = null;
            if ($request->hasFile('app_image')) {
                $fileName = $this->uploadImageToCloudinary($request->file('app_image'), 'mightyolu/upload/appsection/image');
                // $image = $request->file('app_image');
                // $fileName = time() . '.' . $image->getClientOriginalExtension();
                
                // $manager = new ImageManager(new Driver());
                // $processedImage = $manager->read($image);
                // $processedImage->resize(700, 600);
                // $processedImage->save(public_path('upload/appsection/image/') . $fileName);
            }
            $validated['background_image'] = $imageName['secure_url'] ?? $appsection->background_image;
            $validated['app_image'] = $fileName['secure_url'] ??  $appsection->app_image;
            if(AppSection::count()){
                AppSection::first()->update($validated);
            }else{
                AppSection::create($validated);
            }
            return back()->with('success', ' Updated successfully');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went worry');
        }
    }

    

    public function ContactPage(){
        $contact = ContactPage::first();
        return view('admin.pages.contact.index', compact('contact'));
    }

    public function contactStore(ContactPageStoreRequest $request){
        $validated = $request->validated();
        try {
            $imageName = null;
           if ($request->hasFile('existing_image')) {
                $imageName = $this->uploadImageToCloudinary($request->file('existing_image'), 'mightyolu/upload/contact');
                // $image = $request->file('existing_image');
                // $imageName = time() . '.' . $image->getClientOriginalExtension();
                
                // $manager = new ImageManager(new Driver());
                // $processedImage = $manager->read($image);
                // $processedImage->resize(485, 343);
                // $processedImage->save(public_path('upload/contact/') . $imageName);
            }
            $contact = ContactPage::first();
            $validated['existing_image'] = $imageName['secure_url'] ?? $contact->existing_image;
            if(ContactPage::count()){
                ContactPage::first()->update($validated);
            }else{
                ContactPage::create($validated);
            }
            return back()->with('success', ' Updated successfully');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went worry');
        }

    }

    public function counterPage(){
        $counters = Counter::orderBy('id', 'desc')->get();
        return view('admin.pages.counter.index', compact('counters'));
    }

    public function counterCreate(){
        return view('admin.pages.counter.create');
    }
    

    public function counterStore(CounterStoreRequest $request){
        $validated = $request->validated();
        try {
            Counter::create($validated);
            return redirect()->route('admin.counter.index')->with('success', 'Counter Added successfully');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went worry');
        }
    }

    public function counterEdit($id){
        $counter = Counter::findOrFail($id);
        return view('admin.pages.counter.edit', compact('counter'));
    }

    public function counterUpdate(CounterStoreRequest $request, $id){
        $validated = $request->validated();
        try {
            $counter = Counter::findOrFail($id);
            $counter->update($validated);
            return redirect()->route('admin.counter.index')->with('success', 'Counter Updated successfully');
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went worry');
        }
    }


    public function counterDelete($id){
        try {
            $counter = Counter::findOrFail($id);
            $counter->delete();
            return back()->with('success', 'Counter Deleted successfully');
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went worry');
        }
    }


   

    public function policy(){
        $policy = Policy::first();
        return view('admin.pages.policy.index', [
            'policy'=> $policy
        ]);
    }

    public function policyStore(PolicyStoreRequest $request){
        $validated = $request->validated();
        try {
            if(Policy::count()){
                Policy::first()->update($validated);
            }else{
                Policy::create($validated);
            }
            return back()->with('success', 'Policy Updated successfully');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went worry');
        }
    }


    public function servicePage(){
        $services = Service::orderBy('id', 'DESC')->get();
        return view('admin.pages.service.index', compact('services'));
    }

    public function serviceCreate(){
        return view('admin.pages.service.create');
    }

    public function serviceEdit($id){
        $service = Service::findOrFail($id);
        return view('admin.pages.service.edit', compact('service'));
    }

    public function serviceStore(ServiceStoreRequest  $request){
        $validated = $request->validated();
        try {
            Service::create($validated);
            return redirect()->route('admin.service.index')->with('Successful! Updated!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went worry');
        }
    }

    public function serviceUpdate(ServiceStoreRequest  $request, $id){
        $validated = $request->validated();
        try{
            $service = Service::findOrFail($id);
            $service->update($validated);
            return redirect()->route('admin.service.index')->with('Successful Updated!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went worry');
        }
    }

    public function serviceDelete($id){
        try{
            $service = Service::findOrFail($id);
            $service->delete();
            return redirect()->route('admin.service.index')->with('Successful Deleted!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went worry');
        }
    }

    

    public function terms(){
        $terms = Terms::first();
        return view('admin.pages.terms.index', compact('terms'));
    }

    public function termStore(TermsStoreRequest  $request){
        $validated = $request->validated();
        try {
            if (Terms::count()) {
                Terms::first()->update($validated);
            } else {
                Terms::create($validated);
            }
            return back()->with('success', 'Successful! Updated!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went worry');
        }
    }

   

     public function whyChooseStore(WhyChooseStoreRequest  $request){
        $validated = $request->validated();
        // dd($validated);
        try {
           $imageName = null;
            if ($request->hasFile('background_image')) {
                $imageName = $this->uploadImageToCloudinary($request->file('background_image'), 'mightyolu/whychoose/background');
                // $image = $request->file('background_image');
                // $imageName = time() . '.' . $image->getClientOriginalExtension();
                
                // $manager = new ImageManager(new Driver());
                // $processedImage = $manager->read($image);
                // $processedImage->resize(350, 450);
                // $processedImage->save(public_path('upload/whychoose/background/') . $imageName);
            }

            $fileName = null;
            if ($request->hasFile('image_one')) {
                $fileName =  $this->uploadImageToCloudinary($request->file('image_one'), 'mightyolu/whychoose/image');
                // $image = $request->file('image_one');
                // $fileName = time() . '.' . $image->getClientOriginalExtension();
                
                // $manager = new ImageManager(new Driver());
                // $processedImage = $manager->read($image);
                // $processedImage->resize(300, 200);
                // $processedImage->save(public_path('upload/whychoose/image/') . $fileName);
            }


            $photoName = null;
            if ($request->hasFile('image_two')) {
                $photoName = $this->uploadImageToCloudinary($request->file('image_two'), 'mightyolu/whychoose');
                // $image = $request->file('image_two');
                // $photoName = time() . '.' . $image->getClientOriginalExtension();
                
                // $manager = new ImageManager(new Driver());
                // $processedImage = $manager->read($image);
                // $processedImage->resize(300, 200);
                // $processedImage->save(public_path('upload/whychoose/') . $photoName);
            }
            $whychoose = WhyChooseUS::first();
            $validated['background_image'] = $imageName['secure_url'] ?? $whychoose->background_image;
            $validated['image_one'] = $fileName['secure_url'] ?? $whychoose->image_one;
            $validated['image_two'] = $photoName['secure_url'] ?? $whychoose->image_two;
            if (WhyChooseUS::count()) {
                WhyChooseUS::first()->update($validated);
            } else {
                WhyChooseUS::create($validated);
            }
            return back()->with('success', 'Successful! Updated!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went worry');
        }
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
