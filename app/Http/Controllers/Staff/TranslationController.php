<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('staff.translation.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $lang)
    {
        $path = base_path('lang/' . $lang . '.json');

        try {
            $translations = json_decode(file_get_contents($path), true);
        } catch (\Throwable $th) {
            return redirect()->route('staff.lang-translation.index')->withAlert(__('Language Not Found.'));
        }

        return view('staff.translation.edit', compact('translations', 'lang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $lang)
    {
        try {
            $filePath = base_path('lang/' . $lang . '.json');

            $data = file_get_contents($filePath);

            $translations = json_decode($data, true);

            $requestTranslations = $request->translations;

            foreach ($translations as $key => $value) {

                if (isset($requestTranslations[$key])) {
                    $translations[$key] = $requestTranslations[$key];
                } else {
                    $translations[$key] = $value ?? '';
                }
            }

            file_put_contents($filePath, json_encode($translations, JSON_UNESCAPED_UNICODE));

            return redirect()->route('staff.lang-translation.index')->withSuccess('Translation Updated');
        } catch (\Throwable $th) {
            return redirect()->route('staff.lang-translation.index')->withAlert($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
