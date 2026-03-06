<header id="navbar"
    class="fixed inset-x-0 top-0 z-50 bg-[#FFFCF9]/95 backdrop-blur border-b border-[#E8E0D8] transition-shadow duration-300">

    <div class="flex items-center justify-between px-5 sm:px-6 lg:px-12 h-14 sm:h-16">
        <a href="#home" class="flex items-center gap-3 no-underline shrink-0">
            <img src="{{ !empty($company['company_logo']) ? $company['company_logo'] : asset('img/logo-daya.jpg') }}"
                alt="{{ $company['company_name'] ?? 'PT Daya Logo' }}"
                class="h-7 sm:h-8 w-auto object-contain max-w-35 sm:max-w-45">
        </a>

        {{-- Desktop Nav --}}
        <nav class="hidden md:flex items-center gap-6 lg:gap-8">
            @foreach(['about' => 'Tentang', 'product' => 'Produk', 'distribution' => 'Distribusi', 'contact' => 'Kontak'] as $href => $label)
                <a href="#{{ $href }}"
                    class="text-[12px] lg:text-[13px] font-semibold text-[#7A7067] hover:text-[#0F0D0C] transition-colors duration-200 relative group no-underline uppercase tracking-wider whitespace-nowrap">
                    {{ $label }}
                    <span
                        class="absolute -bottom-0.5 left-0 w-0 h-[1.5px] bg-[#F28C52] transition-all duration-300 group-hover:w-full"></span>
                </a>
            @endforeach
        </nav>

        <div class="flex items-center gap-3">
            <a href="#contact"
                class="hidden md:inline-flex items-center gap-2 bg-[#0F0D0C] text-[11px] font-bold tracking-widest uppercase px-5 py-2.5 hover:bg-[#F28C52] transition-colors duration-200 no-underline text-white whitespace-nowrap">
                Hubungi Kami ↗
            </a>

            {{-- Mobile Toggle --}}
            <button id="mobile-menu-toggle"
                class="md:hidden flex flex-col justify-center gap-1.25 w-10 h-10 p-2 focus:outline-none"
                aria-label="Toggle menu" aria-expanded="false">
                <span class="w-5 h-0.5 bg-[#0F0D0C] transition-all duration-300 origin-center" id="bar-1"></span>
                <span class="w-5 h-0.5 bg-[#0F0D0C] transition-all duration-300" id="bar-2"></span>
                <span class="w-5 h-0.5 bg-[#0F0D0C] transition-all duration-300 origin-center" id="bar-3"></span>
            </button>
        </div>
    </div>

    {{-- Mobile Dropdown --}}
    <div id="mobile-menu" class="md:hidden overflow-hidden transition-all duration-300 ease-in-out"
        style="max-height: 0;">
        <nav class="border-t border-[#E8E0D8] bg-[#FFFCF9]">
            @foreach(['about' => 'Tentang', 'product' => 'Produk', 'distribution' => 'Distribusi', 'contact' => 'Kontak'] as $href => $label)
                <a href="#{{ $href }}"
                    class="mobile-nav-link flex items-center justify-between px-6 py-4 text-[12px] font-bold uppercase tracking-widest text-[#0F0D0C] hover:text-[#F28C52] hover:bg-[#FAF7F4] border-b border-[#E8E0D8] last:border-b-0 transition-colors duration-150 no-underline">
                    {{ $label }}
                    <span class="text-[#F28C52] text-base leading-none">→</span>
                </a>
            @endforeach
            <div class="px-6 py-4 bg-[#FAF7F4]">
                <a href="#contact"
                    class="mobile-nav-link flex items-center justify-center gap-2 bg-[#F28C52] text-[11px] font-bold tracking-widest uppercase px-5 py-3 text-white no-underline hover:bg-[#B04E1F] transition-colors duration-200 w-full">
                    Hubungi Kami ↗
                </a>
            </div>
        </nav>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('mobile-menu-toggle');
        const menu = document.getElementById('mobile-menu');
        const bar1 = document.getElementById('bar-1');
        const bar2 = document.getElementById('bar-2');
        const bar3 = document.getElementById('bar-3');
        const links = document.querySelectorAll('.mobile-nav-link');
        let isOpen = false;

        function openMenu() {
            isOpen = true;
            menu.style.maxHeight = menu.scrollHeight + 'px';
            toggle.setAttribute('aria-expanded', 'true');
            bar1.style.transform = 'translateY(5.5px) rotate(45deg)';
            bar2.style.opacity = '0';
            bar3.style.transform = 'translateY(-5.5px) rotate(-45deg)';
        }

        function closeMenu() {
            isOpen = false;
            menu.style.maxHeight = '0';
            toggle.setAttribute('aria-expanded', 'false');
            bar1.style.transform = '';
            bar2.style.opacity = '';
            bar3.style.transform = '';
        }

        toggle.addEventListener('click', () => isOpen ? closeMenu() : openMenu());
        links.forEach(link => link.addEventListener('click', closeMenu));
        window.addEventListener('resize', () => { if (window.innerWidth >= 768 && isOpen) closeMenu(); }, { passive: true });
        document.addEventListener('keydown', e => { if (e.key === 'Escape' && isOpen) closeMenu(); });
    });
</script>