<?php

namespace Database\Seeders;

use App\Models\Inventory;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // KAMERA & LENSA
            ['nama_alat' => 'Camera DSLR - Canon 7D', 'kategori' => 'Kamera', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => 'Disimpan di drybox'],
            ['nama_alat' => 'Camera Profesional - SONY NX5R NX-CAM Full HD', 'kategori' => 'Kamera', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Camera - Sony HXR-MC 1500', 'kategori' => 'Kamera', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Lensa - Canon EF 50mm', 'kategori' => 'Lensa', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Lensa - Canon EF-S 18-135mm', 'kategori' => 'Lensa', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Tripod Camera - Takara Hydro A18 Professional Video Tripod', 'kategori' => 'Kamera', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Tripod Camera - Takara ROVER 66 Professional', 'kategori' => 'Kamera', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Tripod Camera - Takara Seri Lama', 'kategori' => 'Kamera', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Tripod Camera - Sonita ST-650', 'kategori' => 'Kamera', 'stok_total' => 2, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Tripod Camera - Takara Spirit-1', 'kategori' => 'Kamera', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Tripod Camera - Excell Hero 200', 'kategori' => 'Kamera', 'stok_total' => 3, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Tripod Camera - Excell Power Sraf', 'kategori' => 'Kamera', 'stok_total' => 2, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Tripod Camera - Takara Eco 196A', 'kategori' => 'Kamera', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Tripod Camera Kecil (Tanpa Merek)', 'kategori' => 'Kamera', 'stok_total' => 3, 'kondisi' => 'Baik', 'catatan' => 'Ukuran kecil'],
            ['nama_alat' => 'Roller - Takara DL-20DA', 'kategori' => 'Kamera', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Roller - Excell RSDO 200', 'kategori' => 'Kamera', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Roller - Excell', 'kategori' => 'Kamera', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Tripod Camera - King Jay VT-1500', 'kategori' => 'Kamera', 'stok_total' => 1, 'kondisi' => 'Rusak', 'catatan' => 'Kakinya lepas'],
            ['nama_alat' => 'Tripod Camera Rusak (Tanpa Merek)', 'kategori' => 'Kamera', 'stok_total' => 1, 'kondisi' => 'Rusak', 'catatan' => 'Kepalanya rusak'],

            // LIGHTING / PENCAHAYAAN
            ['nama_alat' => 'Lampu LED - Latour 29W JYLED-500S', 'kategori' => 'Lighting', 'stok_total' => 6, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Light Stand - EXCELL', 'kategori' => 'Lighting', 'stok_total' => 2, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Lighting Studio - Tronic Fresno LED1000', 'kategori' => 'Lighting', 'stok_total' => 2, 'kondisi' => 'Baik', 'catatan' => 'Include stand'],
            ['nama_alat' => 'Flash Lighting - Tronic LEAD ECO', 'kategori' => 'Lighting', 'stok_total' => 3, 'kondisi' => 'Baik', 'catatan' => 'Include stand dan softbox'],
            ['nama_alat' => 'Trigger Lighting - One Triggered Two', 'kategori' => 'Lighting', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => '2 receiver, 1 transmitter'],
            ['nama_alat' => 'Neon Lighting (Tanpa Merek)', 'kategori' => 'Lighting', 'stok_total' => 3, 'kondisi' => 'Baik', 'catatan' => 'Merah, Biru, Putih'],
            ['nama_alat' => 'Neon Lighting - RGB LED Light', 'kategori' => 'Lighting', 'stok_total' => 2, 'kondisi' => 'Baik', 'catatan' => 'RGB warna-warni'],

            // AUDIO
            ['nama_alat' => 'Headphone - dBE Headphone and Microphone', 'kategori' => 'Audio', 'stok_total' => 3, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Wireless Mic - Saramonic Blink 500', 'kategori' => 'Audio', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Wireless Mic - Hollyland Lark M2 Mic Wireless Kamera', 'kategori' => 'Audio', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Zoom Recorder - Zoom H4nSP', 'kategori' => 'Audio', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => 'Harus pakai memori 8GB/16GB'],
            ['nama_alat' => 'Mixer Audio - Behringer XENYX 1202FX', 'kategori' => 'Audio', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Soundcard Audio - Focusrite Scarlett 18i8', 'kategori' => 'Audio', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => 'Line Ins: 8, Line Outs: 4'],
            ['nama_alat' => 'Audio Phantom - Phantom Power 48V', 'kategori' => 'Audio', 'stok_total' => 2, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Audio Splitter - Stereo Headphone Amplifier', 'kategori' => 'Audio', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => '1 input, 4 channel output'],
            ['nama_alat' => 'Audio Amplifier - MicroAMP Mini Headphone', 'kategori' => 'Audio', 'stok_total' => 2, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Headset Microphone - Behringer HLC 660M', 'kategori' => 'Audio', 'stok_total' => 2, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Mic Boom', 'kategori' => 'Audio', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],

            // PERKABELAN, LIVE BROADCAST & AKSESORI
            ['nama_alat' => 'HDMI Cable Fiber Optic - Bafo 30m, 50m', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 2, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'HDMI Cable - Unitek 20m', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 2, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Kabel SDI + Power Listrik - RG6 (10m, 15m, 20m, 25m, 30m)', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 5, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Kabel Power (Tanpa Merk)', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 10, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Kabel Mini HDMI to HDMI - Vention 1m', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 3, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Kabel Mini HDMI to USB - Vention 1m', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Kabel LAN - 30m', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Kabel Micro HDMI to HDMI - Vention', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 3, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Kabel Mini HDMI to HDMI - Vention 2m', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 2, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Kabel Mini HDMI to HDMI - Vention 3m', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Kabel Mini HDMI to HDMI - Vention 15m', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 2, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Kabel Mini HDMI to HDMI - Hotron 1,7m', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Kabel Mini HDMI to HDMI - M-Tech 1,5m', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Kabel Mini HDMI to HDMI - Tanpa Merk 1m', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Kabel Mini HDMI to HDMI - Tanpa Merk 1,5m', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Kabel Mini HDMI to HDMI - Tanpa Merk 1,7m', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Display Port - 1,7m', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 2, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'HDMI Capture Card to USB - EZCAP', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'HDMI Capture Card to USB (Mini) - Acasis', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 3, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Video Transmitter - Hollyland Mars 300 Pro Wireless Video', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Video Mixer - ATEM Blackmagic Television Studio HD', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => '4 input HDMI, 4 input SDI'],
            ['nama_alat' => 'HDMI Splitter - Vention 1 in 4 out', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'HDMI Switcher - Vention AFL 2 in 1 out', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Converter HDMI to SDI - Magnus 1080p', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Converter SDI to HDMI - Netline 1080p', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'HDMI to LAN Converter - Vention HDMI Extender over LAN', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => 'Max 50M LAN'],
            ['nama_alat' => 'Stream Deck - Control Pad Sades Ryunix', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Dummy Battery Kit - SONY A6400 Kingma', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Dummy Battery Kit - Canon DC Coupler', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Dummy Battery Kit - SONY A7', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'HDMI Converter - Vention 3 in 1 HDMI', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'USB Hub - Vention 4 input', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'USB Hub - Vention 4 input with Type-C', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Intercom - Magnustek Intercom 5 Unit Communication', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Battery - Sony NP-F770', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 8, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'HT Handy Talky - BAOFENG BF-888S', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 5, 'kondisi' => 'Perlu Servis', 'catatan' => 'Include headset dll, rusak 1 unit'],
            ['nama_alat' => 'Charger Battery NP970 - Kingma 3 input', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 1, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Tas Kamera - Tas Handcam SONY', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 2, 'kondisi' => 'Baik', 'catatan' => null],
            ['nama_alat' => 'Tas Stand dan Tripod - Panjang', 'kategori' => 'Kabel/Aksesori', 'stok_total' => 2, 'kondisi' => 'Perlu Servis', 'catatan' => 'Yang satu agak rusak karena umur'],
        ];

        foreach ($items as $item) {
            Inventory::updateOrCreate(
                ['nama_alat' => $item['nama_alat']],
                [
                    'kategori' => $item['kategori'],
                    'stok_total' => $item['stok_total'],
                    'stok_tersedia' => $item['stok_total'],
                    'kondisi' => $item['kondisi'],
                    'catatan' => $item['catatan'],
                ]
            );
        }
    }
}