@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Yellowtail&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<div class="font-['Plus_Jakarta_Sans'] bg-[#FFFCF9] text-[#0F0D0C] antialiased">

    <x-navbar :company="$company" />

    {{-- HERO --}}
    <section id="home" class="min-h-dvh grid grid-cols-1 lg:grid-cols-2 overflow-x-hidden">
        {{-- Image --}}
        <div class="relative overflow-hidden bg-[#0F0D0C] min-h-65 xs:min-h-[320px] sm:min-h-100 lg:min-h-0 order-first lg:order-last">
            @php $featured = $products[0] ?? null; @endphp
            @if($featured)
                <img src="{{ $featured['image'] ?? 'https://images.unsplash.com/photo-1604147706283-d7119b5b822c?auto=format&fit=crop&w=900&q=80' }}"
                     alt="{{ $featured['name'] }}"
                     class="absolute inset-0 w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                <div class="absolute bottom-6 left-6 sm:bottom-10 sm:left-10 bg-[#F28C52] px-5 py-3 sm:px-8 sm:py-5 text-white shadow-2xl max-w-[calc(100%-3rem)]">
                    <p class="text-[10px] font-semibold tracking-[.15em] uppercase opacity-80">Produk Unggulan</p>
                    <p class="font-['Yellowtail'] font-black text-[1.4rem] sm:text-[1.8rem] mt-0.5 truncate">{{ $featured['name'] }}</p>
                </div>
            @endif
        </div>

        {{-- Text Content --}}
        <div class="flex flex-col justify-center px-5 xs:px-7 sm:px-12 lg:px-16 py-12 sm:py-20 lg:py-24 bg-[#FFFCF9] order-last lg:order-first">
            <div class="flex items-center gap-3 mb-6 sm:mb-8">
                <span class="w-8 h-[1.5px] bg-[#F28C52]"></span>
                <span class="text-[10px] sm:text-[11px] font-semibold tracking-[.18em] uppercase text-[#F28C52]">Distributor Resmi</span>
            </div>
            <h1 class="font-['Plus_Jakarta_Sans'] font-bold text-[clamp(1.9rem,6vw,3.6rem)] leading-[.95] tracking-tight text-[#0F0D0C] mb-4 sm:mb-5">
                Solusi Distribusi<br><span class="text-[#F28C52]">Terpercaya</span>
            </h1>
            <p class="text-sm sm:text-base font-light text-[#7A7067] leading-[1.75] max-w-md mb-3 sm:mb-4">
                {{ $company['company_name'] ?? 'PT Daya' }} adalah perusahaan distribusi yang berfokus pada penyaluran berbagai kategori produk berkualitas dari produsen terpercaya kepada reseller, toko, dan mitra bisnis.
            </p>
            <p class="text-xs sm:text-sm font-semibold text-[#0F0D0C] max-w-md mb-7 sm:mb-8 leading-[1.6]">
                Kami memastikan produk sampai ke mitra bisnis dengan kualitas terjaga, distribusi tepat waktu, dan dukungan responsif bagi partner.
            </p>
            <div class="flex flex-col xs:flex-row items-start xs:items-center gap-4 sm:gap-5 mb-10 sm:mb-14">
                <a href="#about" class="inline-flex items-center gap-2 bg-[#F28C52] text-white text-xs sm:text-sm font-semibold tracking-wider uppercase px-7 sm:px-9 py-3.5 sm:py-4 hover:bg-[#B04E1F] transition-all duration-200 shadow-[0_8px_32px_rgba(212,98,42,.28)] hover:-translate-y-0.5 no-underline w-full xs:w-auto justify-center xs:justify-start">
                    Jadi Mitra ↗
                </a>
                <a href="#contact" class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold tracking-wider uppercase text-[#0F0D0C] border-b-[1.5px] border-[#0F0D0C] py-3 hover:text-[#F28C52] hover:border-[#F28C52] transition-colors duration-200 no-underline">
                    Kontak
                </a>
            </div>
            <div class="flex flex-wrap gap-5 sm:gap-10 pt-6 sm:pt-8 border-t border-[#E8E0D8]">
                @foreach([['50+','Mitra Aktif'],['10+','Kota Terjangkau'],['1000+','Produk/Bulan']] as [$val,$lab])
                    <div class="min-w-20">
                        <p class="font-['Plus_Jakarta_Sans'] font-bold text-lg sm:text-2xl tracking-tight text-[#0F0D0C]">{{ $val }}</p>
                        <p class="text-[9px] sm:text-[11px] font-semibold text-[#7A7067] uppercase tracking-widest mt-1">{{ $lab }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- TICKER --}}
    <div class="bg-[#F28C52] h-10 sm:h-11 overflow-hidden flex items-center" aria-hidden="true">
        <div id="ticker-track" class="flex whitespace-nowrap">
            @foreach(range(1,2) as $_)
                @foreach([($company['company_name'] ?? 'PT Daya'),'Distributor Resmi','Logistik Terpadu','25+ Kota Indonesia','Layanan Mitra 24/7','Kualitas Premium'] as $item)
                    <span class="inline-flex items-center gap-6 sm:gap-8 text-[11px] sm:text-[12px] font-semibold tracking-[.14em] uppercase text-white px-7 sm:px-10">
                        {{ $item }}
                        <span class="w-1 h-1 rounded-full bg-white/50 inline-block"></span>
                    </span>
                @endforeach
            @endforeach
        </div>
    </div>

    {{-- ABOUT --}}
    <section id="about" class="py-16 sm:py-20 bg-[#FAF7F4]">
        <div class="max-w-350 mx-auto px-5 xs:px-6 lg:px-12">
            <div class="flex items-center gap-3 mb-4 reveal">
                <span class="w-7 h-[1.5px] bg-[#F28C52]"></span>
                <span class="text-[10px] sm:text-[11px] font-semibold tracking-[.18em] uppercase text-[#F28C52]">Tentang Kami</span>
            </div>
            <h2 class="font-['Plus_Jakarta_Sans'] font-bold text-[clamp(1.6rem,3vw,2.5rem)] leading-[1.05] tracking-tight text-[#0F0D0C] mb-8 sm:mb-12 reveal">
                Mitra Distribusi Strategis<br>yang Anda Percaya
            </h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12 lg:gap-20 items-center">
                <div class="relative reveal">
                    <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&w=700&q=80"
                         alt="Operasional"
                         class="w-full aspect-4/3 sm:aspect-5/5 object-cover block">
                </div>
                <div class="pt-0 lg:pt-8">
                    <p class="text-sm sm:text-base font-light text-[#7A7067] leading-[1.75] max-w-xl mb-6 sm:mb-8 reveal">
                        {{ $company['company_name'] ?? 'PT Daya' }} didirikan untuk menjadi penghubung antara produsen produk berkualitas dan pasar yang lebih luas. Sistem distribusi yang efisien dan jaringan mitra yang terus berkembang membuat kami mampu menghadirkan produk terbaik kepada konsumen melalui reseller dan toko mitra.
                    </p>
                    <div class="mb-4">
                        @foreach([
                            ['01','Sistem distribusi terorganisir yang memastikan pengiriman konsisten sesuai jadwal.'],
                            ['02','Dukungan partner bagi reseller dan toko untuk memastikan proses pemesanan mudah.'],
                            ['03','Pelacakan kualitas untuk memastikan produk tetap terjaga selama pengiriman.'],
                            ['04','Kolaborasi langsung dengan produsen terpercaya.'],
                        ] as [$num,$text])
                            <div class="flex items-start gap-4 py-3 border-b border-[#E8E0D8] first:border-t reveal">
                                <span class="font-['Plus_Jakarta_Sans'] font-bold text-sm text-[#F28C52] min-w-6 mt-0.5">{{ $num }}</span>
                                <span class="text-[14px] sm:text-[15px] text-[#2E2926] leading-[1.6]">{{ $text }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mb-6 sm:mb-8 grid gap-3 sm:gap-4 grid-cols-1 sm:grid-cols-3">
                        @foreach([
                            ['Misi', 'Menyediakan distribusi produk yang cepat dan terpercaya.'],
                            ['Visi', 'Menjadi distributor terpercaya yang mendukung produk lokal berkualitas.'],
                            ['Komitmen', 'Menjaga kualitas produk sepanjang proses distribusi.'],
                        ] as [$label, $text])
                            <div class="rounded-2xl border border-slate-200 bg-white p-5 sm:p-4 text-center reveal">
                                <p class="text-xs font-semibold uppercase tracking-[.3em] text-[#F28C52]">{{ $label }}</p>
                                <p class="text-[13px] text-[#2E2926] leading-[1.6] mt-2">{{ $text }}</p>
                            </div>
                        @endforeach
                    </div>
                    <a href="#contact" class="inline-flex items-center justify-center xs:justify-start gap-2 bg-[#F28C52] text-white text-xs sm:text-sm font-semibold tracking-wider uppercase px-7 sm:px-9 py-3.5 sm:py-4 hover:bg-[#B04E1F] transition-all duration-200 shadow-[0_8px_32px_rgba(212,98,42,.28)] hover:-translate-y-0.5 no-underline reveal w-full xs:w-auto">
                        Daftar Sebagai Mitra ↗
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- PRODUCT --}}
    <section id="product" class="py-16 sm:py-20 bg-[#FFFCF9]">
        <div class="max-w-350 mx-auto px-5 xs:px-6 lg:px-12 mb-6 sm:mb-8 text-left">
            <div class="flex items-center gap-3 mb-4 reveal">
                <span class="w-7 h-[1.5px] bg-[#F28C52]"></span>
                <span class="text-[10px] sm:text-[11px] font-semibold tracking-[.18em] uppercase text-[#F28C52]">Produk Kami</span>
            </div>
            <h2 class="font-['Plus_Jakarta_Sans'] font-bold text-[clamp(1.6rem,3vw,2.6rem)] leading-[1.1] tracking-tight text-[#0F0D0C] mb-4 sm:mb-6 reveal">Koleksi Produk Pilihan</h2>
            <p class="text-base sm:text-lg font-light text-[#7A7067] leading-[1.8] max-w-5xl reveal">
                Kami menghadirkan rangkaian produk berkualitas tinggi dari produsen terpercaya yang telah melalui seleksi ketat. Setiap produk menjamin standar kualitas yang tinggi, mutu bahan premium, serta kemasan yang praktis untuk kebutuhan pasar modern saat ini.
            </p>
        </div>
        
        <div class="max-w-350 mx-auto px-5 xs:px-6 lg:px-12 relative group">
            <div class="swiper product-swiper overflow-hidden">
                <div class="swiper-wrapper">
                    @forelse($products as $product)
                        <div class="swiper-slide h-auto">
                            <article class="group/card relative overflow-hidden bg-[#0F0D0C] cursor-pointer reveal h-full">
                                <img src="{{ $product['image'] ?? 'https://via.placeholder.com/900x600' }}" 
                                     alt="{{ $product['name'] }}"
                                     class="w-full aspect-3/2 object-cover opacity-60 group-hover/card:opacity-45 group-hover/card:scale-105 transition-all duration-700 block">
                                <div class="absolute inset-0 bg-linear-to-t from-[#0F0D0C]/90 via-transparent to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-5 sm:p-6 text-white">
                                    <div class="flex flex-wrap gap-1.5 sm:gap-2 mb-3 sm:mb-4">
                                        @if(isset($product['brand']))
                                            <span class="text-[9px] sm:text-[10px] font-bold tracking-[.12em] uppercase bg-[#F28C52] text-white px-2 py-1">{{ $product['brand'] }}</span>
                                        @endif
                                        @if(isset($product['code']))
                                            <span class="text-[9px] sm:text-[10px] font-bold tracking-[.12em] uppercase bg-white/20 text-white px-2 py-1">{{ $product['code'] }}</span>
                                        @endif
                                    </div>
                                    <h3 class="font-['Plus_Jakarta_Sans'] font-bold text-[1.1rem] sm:text-[1.3rem] leading-tight mb-1.5 sm:mb-2 tracking-tight">{{ $product['name'] }}</h3>
                                    <p class="text-xs sm:text-sm font-light opacity-80 leading-[1.6] max-w-sm mb-0">
                                        {{ $product['sku'] ?? 'Produk Berkualitas' }}
                                    </p>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="swiper-slide py-20 text-center text-[#7A7067]">
                            <p>Belum ada produk yang tersedia saat ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
            
            {{-- Navigation Buttons --}}
            <button class="product-prev hidden sm:flex absolute top-1/2 -left-3 lg:-left-6 -translate-y-1/2 z-10 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white shadow-xl items-center justify-center text-[#0F0D0C] hover:bg-[#F28C52] hover:text-white transition-all duration-300 md:opacity-0 md:group-hover:opacity-100 md:group-hover:left-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button class="product-next hidden sm:flex absolute top-1/2 -right-3 lg:-right-6 -translate-y-1/2 z-10 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white shadow-xl items-center justify-center text-[#0F0D0C] hover:bg-[#F28C52] hover:text-white transition-all duration-300 md:opacity-0 md:group-hover:opacity-100 md:group-hover:right-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        {{-- Mobile swipe hint --}}
        <p class="text-center text-[11px] text-[#7A7067] mt-4 sm:hidden tracking-wide">← Geser untuk melihat lebih banyak →</p>
    </section>

    {{-- DISTRIBUTION --}}
    <section id="distribution" class="py-16 sm:py-20 bg-[#0F0D0C]">
        <div class="max-w-350 mx-auto px-5 xs:px-6 lg:px-12">
            <div class="flex items-center gap-3 mb-4 reveal">
                <span class="w-7 h-[1.5px] bg-[#F28C52]"></span>
                <span class="text-[10px] sm:text-[11px] font-semibold tracking-[.18em] uppercase text-[#F28C52]">Alur Distribusi</span>
            </div>
            <h2 class="font-['Plus_Jakarta_Sans'] font-bold text-[clamp(1.5rem,3vw,2.4rem)] leading-[1.05] tracking-tight text-white mb-3 sm:mb-4 reveal">
                Dari Produsen<br>Hingga Pelanggan
            </h2>
            <p class="text-base sm:text-lg font-light text-white/50 leading-[1.75] max-w-lg mb-8 sm:mb-10 reveal">Sistem logistik terintegrasi memastikan produk sampai dengan cepat, aman, dan terjaga kualitasnya.</p>
            <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-10 lg:gap-0 relative">
                <div class="hidden lg:block absolute top-6 left-[12.5%] right-[12.5%] h-px bg-white/10"></div>
                @foreach([
                    ['I','Produsen','Produk diproduksi dengan standar kualitas tinggi dan proses kontrol yang ketat.'],
                    ['II', ($company['company_name'] ?? 'PT Daya'), 'Distributor resmi yang menerima, menyimpan, dan mendistribusikan produk ke mitra.'],
                    ['III','Reseller','Reseller dan toko mitra menerima stok untuk penjualan ulang di wilayah masing-masing.'],
                    ['IV','Pelanggan','Konsumen akhir menerima produk dengan kualitas yang tetap terjaga sesuai standar.'],
                ] as [$num,$title,$desc])
                    <div class="text-center px-2 sm:px-4 reveal">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 border border-[#F28C52] flex items-center justify-center font-['Plus_Jakarta_Sans'] font-bold text-[1rem] sm:text-[1.1rem] text-[#F28C52] mx-auto mb-4 sm:mb-6 bg-[#0F0D0C] relative z-10">{{ $num }}</div>
                        <h3 class="font-['Plus_Jakarta_Sans'] font-bold text-base sm:text-lg text-white mb-2">{{ $title }}</h3>
                        <p class="text-[12px] sm:text-[13px] text-white/50 leading-[1.65]">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- WHY --}}
    <section id="why" class="py-16 sm:py-20 bg-[#FAF7F4]">
        <div class="max-w-350 mx-auto px-5 xs:px-6 lg:px-12">
            <div class="flex items-center gap-3 mb-4 reveal">
                <span class="w-7 h-[1.5px] bg-[#F28C52]"></span>
                <span class="text-[10px] sm:text-[11px] font-semibold tracking-[.18em] uppercase text-[#F28C52]">Keunggulan Kami</span>
            </div>
            <h2 class="font-['Plus_Jakarta_Sans'] font-bold text-[clamp(1.5rem,3vw,2.4rem)] leading-[1.05] tracking-tight text-[#0F0D0C] mb-3 sm:mb-4 reveal">
                Mengapa Memilih<br>{{ $company['company_name'] ?? 'PT Daya' }}?
            </h2>
            <p class="text-base sm:text-lg font-light text-[#7A7067] leading-[1.75] max-w-lg mb-6 sm:mb-8 reveal">
                Kami menggabungkan kecepatan, transparansi, dan layanan mitra proaktif untuk distribusi produk yang dapat diandalkan.
            </p>
            <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-4 divide-y xs:divide-y-0 xs:divide-x lg:divide-x divide-[#E8E0D8] border border-[#E8E0D8]">
                @foreach([
                    ['★','Distribusi Andal','PT Daya memastikan proses distribusi berjalan konsisten dan tepat waktu.'],
                    ['◆','Jaminan Kualitas','Produk berasal dari produsen terpercaya dengan mutu yang selalu terjaga.'],
                    ['→','Dukungan Mitra','Kami mendukung mitra bisnis dengan sistem distribusi yang memudahkan pengadaan produk.'],
                    ['✦','Pengiriman Cepat','Pengiriman efisien memastikan produk sampai ke mitra tanpa keterlambatan.'],
                ] as $i => [$icon,$title,$desc])
                    <div class="bg-[#FAF7F4] hover:bg-white transition-colors duration-200 p-6 sm:p-8 lg:p-10 reveal
                        {{ $i < 2 ? 'xs:border-b xs:lg:border-b-0' : '' }}
                        {{ $i === 0 || $i === 2 ? 'lg:border-b-0' : '' }}
                        border-[#E8E0D8]">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 bg-[#F28C52] flex items-center justify-center text-white text-sm sm:text-base mb-5 sm:mb-6">{{ $icon }}</div>
                        <h4 class="font-['Plus_Jakarta_Sans'] font-bold text-sm sm:text-base text-[#0F0D0C] mb-2 sm:mb-3 tracking-tight">{{ $title }}</h4>
                        <p class="text-xs sm:text-sm font-light text-[#7A7067] leading-[1.7]">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CONTACT --}}
    <section id="contact" class="grid grid-cols-1 lg:grid-cols-2">
        <div class="bg-[#0F0D0C] px-6 xs:px-8 sm:px-12 lg:px-16 py-14 lg:py-16 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-7 h-[1.5px] bg-[#F5A673]"></span>
                    <span class="text-[10px] sm:text-[11px] font-semibold tracking-[.18em] uppercase text-[#F5A673]">Hubungi Kami</span>
                </div>
                <h2 class="font-['Plus_Jakarta_Sans'] font-bold text-[clamp(1.6rem,3vw,2.5rem)] leading-[1.05] tracking-tight text-white mb-3 sm:mb-4">
                    Mari Memulai Kemitraan
                </h2>
                <p class="text-sm sm:text-base font-light text-white/55 leading-[1.75] max-w-sm mb-4">
                    Sampaikan kebutuhan distribusi Anda atau jadwalkan pertemuan untuk melihat sampel produk kami secara langsung.
                </p>
                <div class="space-y-3 sm:space-y-4">
                    @foreach([
                        ['Alamat', $company['company_address'] ?? 'Jakarta, Indonesia'],
                        ['WhatsApp', $company['company_phone_display'] ?? '+62 811-1234-5678'],
                        ['Email', $company['company_email'] ?? 'info@ptdaya.co.id']
                    ] as [$label,$val])
                        <div class="border-t border-white/10 pt-3 sm:pt-4">
                            <p class="text-[10px] font-bold tracking-[.18em] uppercase text-[#F28C52] mb-1">{{ $label }}</p>
                            <p class="text-[14px] sm:text-[15px] text-white/80 font-light wrap-break-words">{{ $val }}</p>
                        </div>
                    @endforeach
                </div>
                <a href="https://wa.me/{{ $company['company_phone_wa'] ?? '6281112345678' }}"
                   target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center justify-center xs:justify-start gap-3 mt-8 sm:mt-10 bg-[#F28C52] text-white text-[12px] sm:text-[13px] font-bold tracking-[.06em] uppercase px-7 sm:px-9 py-3.5 sm:py-4 hover:bg-[#B04E1F] transition-all duration-200 shadow-xl hover:-translate-y-0.5 no-underline w-full xs:w-auto">
                    Chat lewat WhatsApp ↗
                </a>
            </div>
        </div>
        <div class="overflow-hidden min-h-65 xs:min-h-[300px] sm:min-h-100 lg:min-h-125 group">
            @php
                $mapAddress = $company['company_address'] ?? 'Jakarta, Indonesia';
                $mapUrl = "https://maps.google.com/maps?q=" . urlencode($mapAddress) . "&t=&z=13&ie=UTF8&iwloc=&output=embed";
            @endphp
            <iframe
                src="{{ $mapUrl }}"
                class="w-full h-full border-0 block contrast-110 transition-all duration-700"
                allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Lokasi {{ $company['company_name'] ?? 'PT Daya' }}">
            </iframe>
        </div>
    </section>

    <x-footer :company="$company" />

</div>

<style>
    @keyframes ticker { from { transform: translateX(0); } to { transform: translateX(-50%); } }
    #ticker-track { animation: ticker 30s linear infinite; }

    .reveal { opacity: 0; transform: translateY(24px); transition: opacity .65s ease, transform .65s ease; }
    .reveal.visible { opacity: 1; transform: none; }

    .swiper-slide { height: auto !important; }

    @media (min-width: 475px) {
        .flex-col.xs\:flex-row { flex-direction: row; }
        .xs\:gap-6 { gap: 1.5rem; }
        .w-full.xs\:w-auto { width: auto; }
        .justify-center.xs\:justify-start { justify-content: flex-start; }
        .xs\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .xs\:divide-y-0 > * + * { border-top-width: 0; }
        .xs\:divide-x > * + * { border-left-width: 1px; }
        .xs\:border-b { border-bottom-width: 1px; }
        .xs\:px-7 { padding-left: 1.75rem; padding-right: 1.75rem; }
        .xs\:px-8 { padding-left: 2rem; padding-right: 2rem; }
        .xs\:min-h-\[300px\] { min-height: 300px; }
        .xs\:min-h-\[320px\] { min-height: 320px; }
        .xs\:justify-start { justify-content: flex-start; }
    }

    @media (hover: none) {
        .product-prev,
        .product-next {
            opacity: 1 !important;
        }
    }

    html, body {
        overflow-x: hidden;
    }

    section#home > div:first-child {
        padding-left: max(1.25rem, env(safe-area-inset-left));
        padding-right: max(1.25rem, env(safe-area-inset-right));
    }
    section#contact > div:first-child {
        padding-left: max(1.5rem, env(safe-area-inset-left));
        padding-right: max(1.5rem, env(safe-area-inset-right));
        padding-bottom: max(3.5rem, env(safe-area-inset-bottom));
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.getElementById('navbar');
        if (navbar) {
            window.addEventListener('scroll', () => {
                navbar.classList.toggle('shadow-[0_4px_32px_rgba(0,0,0,.07)]', window.scrollY > 40);
            }, { passive: true });
        }

        // --- 2. SMOOTH SCROLL ---
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                const t = document.querySelector(a.getAttribute('href'));
                if (t) { e.preventDefault(); t.scrollIntoView({ behavior: 'smooth' }); }
            });
        });

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        new Swiper('.product-swiper', {
            slidesPerView: 1,
            spaceBetween: 16,
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.product-next',
                prevEl: '.product-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                480: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                640: {
                    slidesPerView: 2,
                    spaceBetween: 24,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 24,
                },
            }
        });
    });
</script>

@endsection