<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Lib\Webspice;
use App\Models\AppFooterLogo;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class AppFooterLogoController extends Controller
{
    public $webspice;
    protected $app_footer_logos;
    public $tableName;
    public function __construct(AppFooterLogo $app_footer_logos, Webspice $webspice)
    {
        $this->webspice = $webspice;
        $this->app_footer_logos = $app_footer_logos;
        $this->tableName = 'tbl_logos';
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        #permission verfy
        $this->webspice->permissionVerify('app_footer_logo.view');

        if ($request->get('status') == 'archived') {
            $fileTag = 'Archived ';
            $query = $this->app_footer_logos->orderBy('deleted_at', 'desc');
            $query->onlyTrashed();
        } else {
            $query = $this->app_footer_logos->orderBy('sl_order', 'asc');
        }

        $app_footer_logos =  $query->paginate(7);

        return view('app_footer_logo.index', compact('app_footer_logos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        #permission verfy
        $this->webspice->permissionVerify('app_footer_logo.create');

        return view('app_footer_logo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        # permission verfy
        $this->webspice->permissionVerify('app_footer_logo.create');

        $request->validate(
            [
                'app_footer_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]
        );

        $imageFile = $request->file('app_footer_logo');
        $imageData = base64_encode(file_get_contents($imageFile->getRealPath()));

        $base64Image = 'data:' . mime_content_type($imageFile->getRealPath()) . ';base64,' . $imageData;
        $exist = AppFooterLogo::where('logo_base64', $base64Image)->first();
        if ($exist) {
            $this->webspice->message('error', "This image already exists! Please select another one.");
            return redirect()->back();
        }

        $logoFileName = "";
        if ($request->hasFile('app_footer_logo')) {
            $logo = $request->app_footer_logo;
            $logoFileName = time() . "-logo-" . Webspice::sanitizeFileName($logo->getClientOriginalName());
        }
        try {
            # Move Uploaded File
            $destinationPath = 'uploads/app_footer_logo';
          
            // Resize and save the image
            /*
            $resizedImage = Image::make($imageFile)->resize(200, 200)->encode('jpg', 80); 
            $uploadOk = $resizedImage->save(base_path($destinationPath . '/' . $logoFileName));
            */
            $resizedImage = Image::make($imageFile)->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $uploadOk = $resizedImage->save(base_path($destinationPath . '/' . $logoFileName));
            //$uploadOk = $logo->move($destinationPath, $logoFileName);
            if ($uploadOk) {
                $AppFooterLogo = new AppFooterLogo();
                $AppFooterLogo->logo_base64 = $base64Image;
                $AppFooterLogo->logo_url = env('APP_URL') . "/" . $destinationPath . '/' . $logoFileName;
                $AppFooterLogo->logo = $logoFileName;
                $AppFooterLogo->status = 7;
                $AppFooterLogo->created_at = $this->webspice->now('datetime24');
                $AppFooterLogo->created_by = $this->webspice->getUserId();
                $AppFooterLogo->save();
            }
        } catch (Exception $e) {
            $this->webspice->insertOrFail('error', $e->getMessage());
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        # permission verfy
        $this->webspice->permissionVerify('app_footer_logo.edit');
        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $editInfo = $this->app_footer_logos->find($id);

        return view('app_footer_logo.edit', compact('editInfo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        # permission verfy
        $this->webspice->permissionVerify('app_footer_logo.edit');

        # decrypt value
        $id = $this->webspice->encryptDecrypt('decrypt', $id);

        $request->validate(
            [
                'app_footer_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]
        );

        $imageFile = $request->file('app_footer_logo');
        if ($imageFile) {
            // Read the image file content
            $imageData = base64_encode(file_get_contents($imageFile->getRealPath()));
            // Save base64 image to the database

            $base64Image = 'data:' . mime_content_type($imageFile->getRealPath()) . ';base64,' . $imageData;
            $exist = AppFooterLogo::where('logo_base64', $base64Image)->where('id', '<>', $id)->first();
            if ($exist) {
                $this->webspice->message('error', "This image already exists! Please select another one.");
                return redirect()->back();
            }

            $logoFileName = "";
            if ($request->hasFile('app_footer_logo')) {
                $logo = $request->app_footer_logo;
                $logoFileName = time() . "-logo-" . Webspice::sanitizeFileName($logo->getClientOriginalName());
            }


            try {
                # Move Uploaded File
                $destinationPath = 'uploads/app_footer_logo';
                // dd($destinationPath);
                /*
                $resizedImage = Image::make($imageFile)->resize(200, 200)->encode('jpg', 80); 
                $uploadOk = $resizedImage->save(base_path($destinationPath . '/' . $logoFileName));
                */
                $resizedImage = Image::make($imageFile)->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $uploadOk = $resizedImage->save(base_path($destinationPath . '/' . $logoFileName));
                //$uploadOk = $logo->move($destinationPath, $logoFileName);
                if ($uploadOk) {
                    $AppFooterLogo = $this->app_footer_logos->find($id);
                    if (File::exists(base_path($destinationPath . '/' . $AppFooterLogo->logo))) {
                        File::delete(base_path($destinationPath . '/' . $AppFooterLogo->logo));
                    }
                    $AppFooterLogo->logo_base64 = $base64Image;
                    $AppFooterLogo->logo_url = env('APP_URL') . "/" . $destinationPath . '/' . $logoFileName;
                    $AppFooterLogo->logo = $logoFileName;
                    $AppFooterLogo->updated_at = $this->webspice->now('datetime24');
                    $AppFooterLogo->updated_by = $this->webspice->getUserId();
                    $AppFooterLogo->save();
                }
            } catch (Exception $e) {
                $this->webspice->updateOrFail('error', $e->getMessage());
                return back();
            }
        }
        return redirect('app_footer_logos');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        # permission verfy
        $this->webspice->permissionVerify('app_footer_logo.delete');

        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $AppFooterLogo = $this->app_footer_logos->findOrFail($id);
            if (!is_null($AppFooterLogo)) {
                $AppFooterLogo->status = -7;
                $AppFooterLogo->save();
                $AppFooterLogo->delete();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return back();
    }

    public function forceDelete($id)
    {
        return response()->json(['error' => 'Unauthenticated.'], 401);
        #permission verfy
        $this->webspice->permissionVerify('app_footer_logo.force_delete');
        try {
            #decrypt value
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $AppFooterLogo = AppFooterLogo::withTrashed()->findOrFail($id);
            $destinationPath = 'uploads/app_footer_logo';
            if (File::exists(base_path($destinationPath . '/' . $AppFooterLogo->logo))) {
                File::delete(base_path($destinationPath . '/' . $AppFooterLogo->logo));
            }
            $AppFooterLogo->forceDelete();
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->back();
    }
    public function restore($id)
    {
        #permission verfy
        $this->webspice->permissionVerify('app_footer_logo.restore');
        try {
            $id = $this->webspice->encryptDecrypt('decrypt', $id);
            $AppFooterLogo = AppFooterLogo::withTrashed()->findOrFail($id);
            if ($AppFooterLogo) {
                $AppFooterLogo->status = 7;
                $AppFooterLogo->save();
                $AppFooterLogo->restore();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('app_footer_logos.index');
    }

    public function restoreAll()
    {
        #permission verfy
        $this->webspice->permissionVerify('app_footer_logo.restore');
        try {
            $AppFooterLogos = AppFooterLogo::onlyTrashed()->get();
            foreach ($AppFooterLogos as $v) {
                $v->status = 7;
                $v->save();
                $v->restore();
            }
        } catch (Exception $e) {
            $this->webspice->message('error', $e->getMessage());
        }
        return redirect()->route('app_footer_logos.index');
    }
}
