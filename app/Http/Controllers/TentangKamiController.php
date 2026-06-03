<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TentangKamiController extends Controller
{
    public function edit()
    {
        // Cek login
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }

        // Ambil data dari database
        $about_title = Setting::get('about_title', 'Tentang SIPERUM');
        $about_description = Setting::get('about_description', '');
        $about_vision = Setting::get('about_vision', '');
        $about_mission = Setting::get('about_mission', '');
        $about_image = Setting::get('about_image', '');
        
        $website_name = Setting::get('website_name', 'SIPERUM');
        $owner_name = Setting::get('owner_name', '');
        $owner_position = Setting::get('owner_position', '');
        $owner_bio = Setting::get('owner_bio', '');
        $owner_photo = Setting::get('owner_photo', '');
        
        $contact_email = Setting::get('contact_email', '');
        $contact_phone = Setting::get('contact_phone', '');
        $contact_whatsapp = Setting::get('contact_whatsapp', '');
        $contact_address = Setting::get('contact_address', '');
        
        $social_facebook = Setting::get('social_facebook', '');
        $social_instagram = Setting::get('social_instagram', '');
        $social_twitter = Setting::get('social_twitter', '');
        $social_youtube = Setting::get('social_youtube', '');
        
        return view('tentang-kami.edit', compact(
            'about_title', 'about_description', 'about_vision', 'about_mission', 'about_image',
            'website_name', 'owner_name', 'owner_position', 'owner_bio', 'owner_photo',
            'contact_email', 'contact_phone', 'contact_whatsapp', 'contact_address',
            'social_facebook', 'social_instagram', 'social_twitter', 'social_youtube'
        ));
    }

    public function update(Request $request)
    {
        // Cek login
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }

        // Update About
        Setting::set('about_title', $request->about_title);
        Setting::set('about_description', $request->about_description);
        Setting::set('about_vision', $request->about_vision);
        Setting::set('about_mission', $request->about_mission);
        
        // Update Website
        Setting::set('website_name', $request->website_name);
        
        // Update Owner
        Setting::set('owner_name', $request->owner_name);
        Setting::set('owner_position', $request->owner_position);
        Setting::set('owner_bio', $request->owner_bio);
        
        // Update Kontak
        Setting::set('contact_email', $request->contact_email);
        Setting::set('contact_phone', $request->contact_phone);
        Setting::set('contact_whatsapp', $request->contact_whatsapp);
        Setting::set('contact_address', $request->contact_address);
        
        // Update Sosial Media
        Setting::set('social_facebook', $request->social_facebook);
        Setting::set('social_instagram', $request->social_instagram);
        Setting::set('social_twitter', $request->social_twitter);
        Setting::set('social_youtube', $request->social_youtube);
        
        // Upload gambar about
        if ($request->hasFile('about_image')) {
            $image = $request->file('about_image');
            $namaImage = time() . '_about_' . $image->getClientOriginalName();
            $tujuanAdmin = 'C:/laragon/www/uploads/settings';
            $tujuanFrontend = 'C:/laragon/www/perumahan-web/public/uploads/settings';
            $this->saveFileToAdminAndFrontend($image, $tujuanAdmin, $tujuanFrontend, $namaImage);
            Setting::set('about_image', 'uploads/settings/' . $namaImage);
        }
        
        // Upload foto owner
        if ($request->hasFile('owner_photo')) {
            $photo = $request->file('owner_photo');
            $namaPhoto = time() . '_owner_' . $photo->getClientOriginalName();
            $tujuanAdmin = 'C:/laragon/www/uploads/settings';
            $tujuanFrontend = 'C:/laragon/www/perumahan-web/public/uploads/settings';
            $this->saveFileToAdminAndFrontend($photo, $tujuanAdmin, $tujuanFrontend, $namaPhoto);
            Setting::set('owner_photo', 'uploads/settings/' . $namaPhoto);
        }
        
        return redirect()->route('tentang-kami.edit')
            ->with('success', 'Data berhasil diperbarui!');
    }
}