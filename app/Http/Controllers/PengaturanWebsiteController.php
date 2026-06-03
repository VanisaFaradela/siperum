<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaturanWebsiteController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::guard('admin')->check()) {
                return redirect()->route('login');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $website_name = Setting::get('website_name');
        $website_description = Setting::get('website_description');
        $website_logo = Setting::get('website_logo');
        
        $owner_name = Setting::get('owner_name');
        $owner_position = Setting::get('owner_position');
        $owner_photo = Setting::get('owner_photo');
        $owner_bio = Setting::get('owner_bio');
        
        $contact_email = Setting::get('contact_email');
        $contact_phone = Setting::get('contact_phone');
        $contact_whatsapp = Setting::get('contact_whatsapp');
        $contact_address = Setting::get('contact_address');
        
        $social_facebook = Setting::get('social_facebook');
        $social_instagram = Setting::get('social_instagram');
        $social_twitter = Setting::get('social_twitter');
        $social_youtube = Setting::get('social_youtube');
        
        $about_title = Setting::get('about_title');
        $about_description = Setting::get('about_description');
        $about_vision = Setting::get('about_vision');
        $about_mission = Setting::get('about_mission');
        $about_image = Setting::get('about_image');
        
        $hero_title = Setting::get('hero_title');
        $hero_subtitle = Setting::get('hero_subtitle');
        $hero_button_text = Setting::get('hero_button_text');
        $hero_button_link = Setting::get('hero_button_link');
        $hero_background = Setting::get('hero_background');
        
        $footer_description = Setting::get('footer_description');
        $footer_copyright = Setting::get('footer_copyright');
        
        return view('pengaturan-website.index', compact(
            'website_name', 'website_description', 'website_logo',
            'owner_name', 'owner_position', 'owner_photo', 'owner_bio',
            'contact_email', 'contact_phone', 'contact_whatsapp', 'contact_address',
            'social_facebook', 'social_instagram', 'social_twitter', 'social_youtube',
            'about_title', 'about_description', 'about_vision', 'about_mission', 'about_image',
            'hero_title', 'hero_subtitle', 'hero_button_text', 'hero_button_link', 'hero_background',
            'footer_description', 'footer_copyright'
        ));
    }

    public function updateWebsite(Request $request)
    {
        Setting::set('website_name', $request->website_name);
        Setting::set('website_description', $request->website_description);
        
        if ($request->hasFile('website_logo')) {
            $logo = $request->file('website_logo');
            $namaLogo = time() . '_logo_' . $logo->getClientOriginalName();
            $tujuanAdmin = public_path('uploads/settings');
            $tujuanFrontend = 'C:/laragon/www/perumahan-web/public/uploads/settings';
            $this->saveFileToAdminAndFrontend($logo, $tujuanAdmin, $tujuanFrontend, $namaLogo);
            Setting::set('website_logo', 'uploads/settings/' . $namaLogo, 'image', 'website');
        }
        
        return redirect()->route('pengaturan-website.index')->with('success', 'Data website berhasil diperbarui!');
    }

    public function updateOwner(Request $request)
    {
        Setting::set('owner_name', $request->owner_name);
        Setting::set('owner_position', $request->owner_position);
        Setting::set('owner_bio', $request->owner_bio);
        
        if ($request->hasFile('owner_photo')) {
            $photo = $request->file('owner_photo');
            $namaPhoto = time() . '_owner_' . $photo->getClientOriginalName();
            $tujuanAdmin = public_path('uploads/settings');
            $tujuanFrontend = 'C:/laragon/www/perumahan-web/public/uploads/settings';
            $this->saveFileToAdminAndFrontend($photo, $tujuanAdmin, $tujuanFrontend, $namaPhoto);
            Setting::set('owner_photo', 'uploads/settings/' . $namaPhoto, 'image', 'owner');
        }
        
        return redirect()->route('pengaturan-website.index')->with('success', 'Data owner berhasil diperbarui!');
    }

    public function updateKontak(Request $request)
    {
        Setting::set('contact_email', $request->contact_email);
        Setting::set('contact_phone', $request->contact_phone);
        Setting::set('contact_whatsapp', $request->contact_whatsapp);
        Setting::set('contact_address', $request->contact_address);
        
        return redirect()->route('pengaturan-website.index')->with('success', 'Data kontak berhasil diperbarui!');
    }

    public function updateSosialMedia(Request $request)
    {
        Setting::set('social_facebook', $request->social_facebook);
        Setting::set('social_instagram', $request->social_instagram);
        Setting::set('social_twitter', $request->social_twitter);
        Setting::set('social_youtube', $request->social_youtube);
        
        return redirect()->route('pengaturan-website.index')->with('success', 'Sosial media berhasil diperbarui!');
    }

    public function updateTentangKami(Request $request)
    {
        Setting::set('about_title', $request->about_title);
        Setting::set('about_description', $request->about_description);
        Setting::set('about_vision', $request->about_vision);
        Setting::set('about_mission', $request->about_mission);
        
        if ($request->hasFile('about_image')) {
            $image = $request->file('about_image');
            $namaImage = time() . '_about_' . $image->getClientOriginalName();
            $tujuanAdmin = public_path('uploads/settings');
            $tujuanFrontend = 'C:/laragon/www/perumahan-web/public/uploads/settings';
            $this->saveFileToAdminAndFrontend($image, $tujuanAdmin, $tujuanFrontend, $namaImage);
            Setting::set('about_image', 'uploads/settings/' . $namaImage, 'image', 'about');
        }
        
        return redirect()->route('pengaturan-website.index')->with('success', 'Tentang Kami berhasil diperbarui!');
    }

    public function updateHero(Request $request)
    {
        Setting::set('hero_title', $request->hero_title);
        Setting::set('hero_subtitle', $request->hero_subtitle);
        Setting::set('hero_button_text', $request->hero_button_text);
        Setting::set('hero_button_link', $request->hero_button_link);
        
        if ($request->hasFile('hero_background')) {
            $image = $request->file('hero_background');
            $namaImage = time() . '_hero_' . $image->getClientOriginalName();
            $tujuanAdmin = public_path('uploads/settings');
            $tujuanFrontend = 'C:/laragon/www/perumahan-web/public/uploads/settings';
            $this->saveFileToAdminAndFrontend($image, $tujuanAdmin, $tujuanFrontend, $namaImage);
            Setting::set('hero_background', 'uploads/settings/' . $namaImage, 'image', 'hero');
        }
        
        return redirect()->route('pengaturan-website.index')->with('success', 'Hero section berhasil diperbarui!');
    }

    public function updateFooter(Request $request)
    {
        Setting::set('footer_description', $request->footer_description);
        Setting::set('footer_copyright', $request->footer_copyright);
        
        return redirect()->route('pengaturan-website.index')->with('success', 'Footer berhasil diperbarui!');
    }
}