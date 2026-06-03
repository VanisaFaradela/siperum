<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        // ==================== WEBSITE ====================
        Setting::set('website_name', 'SIPERUM', 'text', 'website');
        Setting::set('website_description', 'Sistem Informasi Perumahan Terpercaya di Indonesia', 'textarea', 'website');
        Setting::set('website_logo', null, 'image', 'website');
        Setting::set('website_favicon', null, 'image', 'website');
        
        // ==================== OWNER ====================
        Setting::set('owner_name', 'Vanisa Super Admin', 'text', 'owner');
        Setting::set('owner_position', 'CEO & Founder', 'text', 'owner');
        Setting::set('owner_photo', null, 'image', 'owner');
        Setting::set('owner_bio', 'Pendiri dan CEO SIPERUM dengan pengalaman lebih dari 10 tahun di bidang properti dan teknologi informasi.', 'textarea', 'owner');
        
        // ==================== KONTAK ====================
        Setting::set('contact_email', 'info@siperum.com', 'email', 'contact');
        Setting::set('contact_phone', '021-12345678', 'text', 'contact');
        Setting::set('contact_whatsapp', '08123456789', 'text', 'contact');
        Setting::set('contact_address', 'Jl. Contoh No. 123, Jakarta, Indonesia', 'textarea', 'contact');
        Setting::set('contact_map', null, 'textarea', 'contact');
        
        // ==================== SOSIAL MEDIA ====================
        Setting::set('social_facebook', 'https://facebook.com/siperum', 'url', 'social');
        Setting::set('social_instagram', 'https://instagram.com/siperum', 'url', 'social');
        Setting::set('social_twitter', 'https://twitter.com/siperum', 'url', 'social');
        Setting::set('social_youtube', 'https://youtube.com/@siperum', 'url', 'social');
        Setting::set('social_linkedin', 'https://linkedin.com/company/siperum', 'url', 'social');
        
        // ==================== TENTANG KAMI ====================
        Setting::set('about_title', 'Tentang SIPERUM', 'text', 'about');
        Setting::set('about_description', 'SIPERUM (Sistem Informasi Perumahan) adalah platform digital yang membantu mengelola data perumahan dengan mudah dan efisien. Kami menyediakan solusi lengkap untuk pengelolaan perumahan, tipe rumah, berita, galeri, dan lain-lain.', 'html', 'about');
        Setting::set('about_vision', 'Menjadi platform terdepan dalam pengelolaan informasi perumahan di Indonesia.', 'textarea', 'about');
        Setting::set('about_mission', "1. Menyediakan informasi perumahan yang akurat dan terupdate\n2. Memudahkan pengelolaan data perumahan\n3. Meningkatkan pelayanan kepada masyarakat\n4. Menjadi mitra terpercaya dalam bisnis properti", 'textarea', 'about');
        Setting::set('about_image', null, 'image', 'about');
        
        // ==================== HERO SECTION ====================
        Setting::set('hero_title', 'Sistem Informasi Perumahan', 'text', 'hero');
        Setting::set('hero_subtitle', 'Kelola data perumahan dengan mudah dan efisien. Solusi lengkap untuk pengelolaan properti Anda.', 'textarea', 'hero');
        Setting::set('hero_button_text', 'Lihat Perumahan', 'text', 'hero');
        Setting::set('hero_button_link', '/perumahan', 'text', 'hero');
        Setting::set('hero_background', null, 'image', 'hero');
        
        // ==================== FOOTER ====================
        Setting::set('footer_description', 'Sistem Informasi Perumahan terpercaya di Indonesia. Membantu Anda mengelola data perumahan dengan mudah dan efisien.', 'textarea', 'footer');
        Setting::set('footer_copyright', '© 2024 SIPERUM. All rights reserved.', 'text', 'footer');
        
        // ==================== SEO ====================
        Setting::set('seo_title', 'SIPERUM - Sistem Informasi Perumahan', 'text', 'seo');
        Setting::set('seo_description', 'SIPERUM adalah sistem informasi perumahan yang membantu mengelola data perumahan, tipe rumah, berita, galeri dengan mudah.', 'textarea', 'seo');
        Setting::set('seo_keywords', 'perumahan, properti, rumah, sistem informasi, SIPERUM', 'text', 'seo');
        
        $this->command->info('✅ Data setting website berhasil ditambahkan!');
        $this->command->info('📝 Silakan login ke /pengaturan-website untuk mengedit konten.');
    }
}