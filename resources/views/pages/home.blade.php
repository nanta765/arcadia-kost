<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->user()->id ?? '' }}">
    <title>Arcadia Kost Lombok — Hunian Nyaman di Pulau Seribu Masjid</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                        serif: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        lmk: {
                            sand:    '#F5EFE4',
                            sandlt:  '#e2e3e7',
                            stone:   '#E2D9CC',
                            teal:    '#A65437',
                            teallt:  '#3D8A93',
                            ocean:   '#1A4F55',
                            terra:   '#B86B3A',
                            rinjani: '#1E3528',
                            gold:    '#C9A252',
                            muted:   '#8A7F72',
                            dark:    '#171410',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Poppins', sans-serif; background: #e2e3e7; color: #171410; overflow-x: hidden; }

        /* Sasak motif stripe */
        .sasak-stripe {
            height: 5px;
            background: repeating-linear-gradient(
                90deg,
                #A65437 0px, #A65437 10px,
                #C9A252 10px, #C9A252 20px,
                #B86B3A 20px, #B86B3A 30px,
                #e2e3e7 30px, #e2e3e7 40px
            );
        }

        /* Nav */
        nav {
            position: sticky; top: 0; z-index: 100;
            background: rgba(250,246,239,0.94);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid #E2D9CC;
        }
        .nav-inner {
            max-width: 1200px; margin: 0 auto; padding: 0 2rem;
            height: 66px; display: flex; align-items: center; justify-content: space-between;
        }
        .nav-logo { font-family:'Poppins',sans-serif; font-size:1.4rem; font-weight:700; color:#1E3528; text-decoration:none; }
        .nav-logo span { color:#A65437; }
        .nav-links { display:flex; gap:4px; list-style:none; }
        .nav-links a { padding:0.4rem 1rem; border-radius:100px; font-size:0.8rem; font-weight:500; color:#8A7F72; text-decoration:none; transition:all 0.2s; }
        .nav-links a:hover, .nav-links a.active { background:#A65437; color:#fff; }
        .btn { display:inline-block; padding:0.55rem 1.35rem; border-radius:100px; font-size:0.82rem; font-weight:600; text-decoration:none; cursor:pointer; border:none; transition:all 0.25s; }
        .btn-teal { background:#A65437; color:#fff; }
        .btn-teal:hover { background:#1A4F55; }
        .btn-ghost { background:transparent; border:1.5px solid #A65437; color:#A65437; }
        .btn-ghost:hover { background:#A65437; color:#fff; }

        /* Section wrapper */
        .wrap { max-width:1200px; margin:0 auto; padding:5rem 2rem; }
        .wrap-sm { max-width:1200px; margin:0 auto; padding:3.5rem 2rem; }

        /* Section label */
        .stag { display:inline-flex; align-items:center; gap:0.5rem; font-size:0.7rem; font-weight:600; letter-spacing:0.14em; text-transform:uppercase; color:#A65437; margin-bottom:0.6rem; }
        .stag::before { content:''; display:block; width:20px; height:1.5px; background:#A65437; }
        .stitle { font-family:'Poppins',sans-serif; font-size:clamp(1.8rem,3vw,2.6rem); font-weight:700; color:#171410; line-height:1.2; margin-bottom:0.6rem; }
        .ssub { font-size:0.92rem; color:#8A7F72; font-weight:300; line-height:1.8; max-width:460px; }

        /* Hero */
        .hero { max-width:1200px; margin:0 auto; padding:5rem 2rem 4rem; display:grid; grid-template-columns:1fr 1fr; gap:4rem; align-items:center; }
        .hero-eyebrow { display:inline-flex; align-items:center; gap:0.6rem; font-size:0.7rem; font-weight:600; letter-spacing:0.14em; text-transform:uppercase; color:#A65437; margin-bottom:1.2rem; }
        .hero-eyebrow::before { content:''; width:22px; height:1.5px; background:#A65437; display:block; }
        .hero h1 { font-family:'Poppins',sans-serif; font-size:clamp(2.8rem,4.5vw,4rem); font-weight:700; line-height:1.15; color:#171410; margin-bottom:1.2rem; }
        .hero h1 em { font-style:italic; color:#A65437; }
        .hero-desc { font-size:0.98rem; color:#8A7F72; font-weight:300; line-height:1.8; margin-bottom:2rem; max-width:400px; }

        /* Hero visual */
        .hero-visual { position:relative; }
        .hero-photo { border-radius:20px; overflow:hidden; aspect-ratio:5/4; position:relative; }
        .hero-photo img { width:100%; height:100%; object-fit:cover; }
        .hero-photo-sm { position:absolute; bottom:-20px; left:-20px; width:150px; aspect-ratio:4/3; border-radius:14px; overflow:hidden; border:4px solid #e2e3e7; box-shadow:0 8px 24px rgba(0,0,0,0.12); }
        .hero-photo-sm img { width:100%; height:100%; object-fit:cover; }
        .hero-price { position:absolute; top:20px; right:-14px; background:#A65437; color:#fff; padding:1rem 1.2rem; border-radius:14px; text-align:center; box-shadow:0 8px 24px rgba(42,107,114,0.3); }
        .hero-price .num { font-family:'Poppins',sans-serif; font-size:1.5rem; font-weight:700; line-height:1; }
        .hero-price .lbl { font-size:0.62rem; opacity:0.7; letter-spacing:0.06em; text-transform:uppercase; margin-top:3px; }
        /* Sasak diamond ornament */
        .sasak-ornament { position:absolute; bottom:0; right:0; width:72px; height:72px; border-radius:0 0 20px 0; background:#A65437; display:flex; align-items:center; justify-content:center; }

        /* Stats */
        .stats-bar { background:#1E3528; }
        .stats-inner { max-width:1200px; margin:0 auto; padding:0 2rem; display:grid; grid-template-columns:repeat(4,1fr); }
        .stat-cell { padding:2rem 1.5rem; border-right:0.5px solid rgba(255,255,255,0.1); text-align:center; }
        .stat-cell:last-child { border-right:none; }
        .stat-num { font-family:'Poppins',sans-serif; font-size:2.2rem; color:#C9A252; line-height:1; margin-bottom:4px; }
        .stat-lbl { font-size:0.68rem; color:rgba(255,255,255,0.4); letter-spacing:0.1em; text-transform:uppercase; }

        /* Bento about */
        .bento { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; }
        .bcard { border-radius:18px; overflow:hidden; border:0.5px solid #E2D9CC; transition:transform 0.3s,box-shadow 0.3s; }
        .bcard:hover { transform:translateY(-2px); box-shadow:0 10px 32px rgba(26,79,85,0.08); }
        .bcard-text { background:#F5EFE4; padding:2.25rem; grid-row:span 2; display:flex; flex-direction:column; justify-content:space-between; }
        .bcard-feat { background:#fff; padding:2rem; }
        .bcard-img { position:relative; overflow:hidden; min-height:210px; }
        .bcard-img img { width:100%; height:100%; object-fit:cover; transition:transform 0.5s; }
        .bcard-img:hover img { transform:scale(1.04); }
        .bcard-img-ov { position:absolute; inset:0; background:linear-gradient(to top, rgba(26,79,85,0.72) 0%, transparent 55%); }
        .bcard-img-cap { position:absolute; bottom:0; padding:1.2rem; }

        /* Fasilitas */
        .fasi-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:10px; }
        .fcard { background:#fff; border-radius:14px; padding:1.4rem; border:0.5px solid #E2D9CC; transition:transform 0.25s,border-color 0.25s; }
        .fcard:hover { transform:translateY(-2px); border-color:#A65437; }
        .ficon { width:38px; height:38px; background:#F5EFE4; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:1.1rem; margin-bottom:0.8rem; }

        /* Lombok banner */
        .lombok-banner { background:#A65437; position:relative; overflow:hidden; }
        .lombok-banner::before { content:''; position:absolute; inset:0; background-image:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 30 L15 15 L30 30 L15 45 Z M30 30 L45 15 L60 30 L45 45 Z' fill='none' stroke='white' stroke-width='0.8' stroke-opacity='0.07'/%3E%3C/svg%3E"); }
        .lombok-inner { max-width:1200px; margin:0 auto; padding:4rem 2rem; display:grid; grid-template-columns:1fr 1fr; gap:4rem; align-items:center; position:relative; z-index:1; }
        .lombok-pt { display:flex; flex-direction:column; gap:1rem; }
        .lombok-item { display:flex; align-items:flex-start; gap:1rem; background:rgba(255,255,255,0.08); border:0.5px solid rgba(255,255,255,0.12); border-radius:12px; padding:1rem 1.2rem; }

        /* Kamar */
        .room-layout { display:grid; grid-template-columns:1fr 1fr; gap:3.5rem; align-items:start; }
        .room-gallery { display:grid; grid-template-columns:1fr 1fr; grid-template-rows:240px 170px; gap:10px; }
        .rgal-main { grid-column:span 2; border-radius:16px; overflow:hidden; }
        .rgal-sm { border-radius:12px; overflow:hidden; }
        .rgal-main img, .rgal-sm img { width:100%; height:100%; object-fit:cover; }
        .room-badge { display:inline-block; padding:0.3rem 1rem; background:rgba(42,107,114,0.1); border:1px solid rgba(42,107,114,0.3); color:#A65437; border-radius:100px; font-size:0.68rem; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; margin-bottom:1.2rem; }
        .room-name { font-family:'Poppins',sans-serif; font-size:2.2rem; color:#171410; margin-bottom:0.6rem; }
        .room-price { font-family:'Poppins',sans-serif; font-size:2.8rem; color:#A65437; line-height:1; }
        .room-specs { display:grid; grid-template-columns:repeat(3,1fr); background:#F5EFE4; border-radius:14px; border:0.5px solid #E2D9CC; overflow:hidden; margin-bottom:1.75rem; }
        .rspec { padding:1.1rem; border-right:0.5px solid #E2D9CC; }
        .rspec:last-child { border-right:none; }
        .rspec-lbl { font-size:0.62rem; color:#8A7F72; letter-spacing:0.08em; text-transform:uppercase; margin-bottom:3px; }
        .rspec-val { font-size:0.95rem; font-weight:600; }
        .rincludes { display:flex; flex-direction:column; gap:0.45rem; margin-bottom:1.75rem; }
        .rinclude { display:flex; align-items:center; gap:0.7rem; font-size:0.85rem; color:#4A4540; }
        .rinclude::before { content:''; flex-shrink:0; width:5px; height:5px; border-radius:50%; background:#A65437; }

        /* Peraturan */
        .rules-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; }
        .rule-card { background:#fff; border-radius:16px; padding:1.75rem; border:0.5px solid #E2D9CC; transition:border-color 0.25s; }
        .rule-card:hover { border-color:#A65437; }

        /* Lokasi */
        .lokasi-grid { display:grid; grid-template-columns:1fr 1fr; gap:3.5rem; align-items:start; }
        .lm-list { display:flex; flex-direction:column; gap:0.65rem; }
        .lm-item { display:flex; align-items:center; gap:0.85rem; padding:0.8rem 1rem; background:#fff; border-radius:12px; border:0.5px solid #E2D9CC; }
        .lm-icon { width:34px; height:34px; background:rgba(42,107,114,0.08); border-radius:9px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:0.95rem; }
        .map-box { border-radius:18px; overflow:hidden; border:0.5px solid #E2D9CC; aspect-ratio:4/3; }
        .map-box iframe { width:100%; height:100%; border:none; display:block; }

        /* Testi */
        .testi-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; }
        .tcard { background:#fff; border-radius:16px; padding:1.75rem; border:0.5px solid #E2D9CC; transition:transform 0.25s; }
        .tcard:hover { transform:translateY(-2px); }
        .tcard-q { font-family:'Poppins',sans-serif; font-size:1.05rem; font-style:italic; color:#171410; line-height:1.7; margin-bottom:1.25rem; }
        .tavatar { width:34px; height:34px; border-radius:50%; background:#A65437; display:flex; align-items:center; justify-content:center; font-size:0.72rem; font-weight:600; color:#fff; flex-shrink:0; }

        /* CTA */
        .cta-wrap { background:#1E3528; position:relative; overflow:hidden; }
        .cta-deco { position:absolute; top:50%; right:4%; transform:translateY(-50%); font-family:'Poppins',sans-serif; font-size:15rem; color:rgba(255,255,255,0.03); pointer-events:none; white-space:nowrap; line-height:1; }
        .cta-inner { max-width:1200px; margin:0 auto; padding:5rem 2rem; position:relative; z-index:1; }

        /* Footer */
        footer { background:#0F1A13; }
        .footer-inner { max-width:1200px; margin:0 auto; padding:3.5rem 2rem 2rem; }
        .footer-grid { display:grid; grid-template-columns:1.5fr 1fr 1fr; gap:3rem; margin-bottom:2.5rem; }

        /* WA */
        .wa-btn { position:fixed; bottom:2rem; right:2rem; z-index:200; width:52px; height:52px; border-radius:50%; background:#25D366; display:flex; align-items:center; justify-content:center; text-decoration:none; box-shadow:0 6px 24px rgba(37,211,102,0.4); transition:transform 0.3s; }
        .wa-btn:hover { transform:scale(1.1); }

        /* Reveal */
        .reveal { opacity:0; transform:translateY(22px); transition:opacity 0.6s ease,transform 0.6s ease; }
        .reveal.in { opacity:1; transform:translateY(0); }
        .d1 { transition-delay:0.1s; } .d2 { transition-delay:0.2s; } .d3 { transition-delay:0.3s; }

        @media (max-width:900px) {
            .hero { grid-template-columns:1fr; padding:3rem 1.25rem 2rem; }
            .hero-visual { display:none; }
            .bento, .fasi-grid { grid-template-columns:1fr 1fr; }
            .bcard-text { grid-column:span 2; }
            .room-layout, .lokasi-grid, .lombok-inner { grid-template-columns:1fr; }
            .stats-inner { grid-template-columns:repeat(2,1fr); }
            .testi-grid, .rules-grid { grid-template-columns:1fr; }
            .footer-grid { grid-template-columns:1fr; }
            .wrap { padding:3.5rem 1.25rem; }
            .wrap-sm { padding:2.5rem 1.25rem; }
        }
        @media (max-width:600px) {
            .bento, .fasi-grid { grid-template-columns:1fr; }
            .bcard-text { grid-column:span 1; }
        }
    </style>
</head>
<body>

{{-- Sasak color stripe --}}
<div class="sasak-stripe"></div>

{{-- ── NAVBAR ── --}}
<nav>
    <div class="nav-inner">
        <a href="#" class="nav-logo">Arcadia<span>.</span></a>
        <ul class="nav-links hidden md:flex">
            <li><a href="#" class="active">Beranda</a></li>
            <li><a href="#tentang">Tentang</a></li>
            <li><a href="#fasilitas">Fasilitas</a></li>
            <li><a href="#kamar">Kamar</a></li>
            <li><a href="#lokasi">Lokasi</a></li>
        </ul>
        <a href="#kontak" class="btn btn-teal">Cek Kamar</a>
    </div>
</nav>

{{-- ── HERO ── --}}
<div class="hero">
    <div>
        <div class="hero-eyebrow">Kost · Mataram, Lombok NTB</div>
        <h1>Hunian nyaman<br>di <em>Pulau Seribu<br>Masjid</em></h1>
        <p class="hero-desc">Arcadia Kost hadir sebagai hunian modern yang mendukung produktivitas dan kehidupan sehari-hari di Kota Mataram — strategis, bersih, dan terasa seperti rumah.</p>
        <div class="flex gap-3 flex-wrap">
            <a href="#kamar" class="btn btn-teal">Lihat Kamar →</a>
            <a href="#kontak" class="btn btn-ghost">Hubungi Kami</a>
        </div>
    </div>

    <div class="hero-visual">
        <div class="hero-photo">
            <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=900&q=80" alt="Kamar Arcadia">
            <div class="sasak-ornament">
                <svg width="36" height="36" viewBox="0 0 36 36" fill="none">
                    <path d="M4 18 L18 4 L32 18 L18 32 Z" stroke="#C9A252" stroke-width="2" fill="none"/>
                    <path d="M10 18 L18 10 L26 18 L18 26 Z" stroke="rgba(255,255,255,0.5)" stroke-width="1.2" fill="none"/>
                    <circle cx="18" cy="18" r="3" fill="#C9A252"/>
                </svg>
            </div>
        </div>
        <div class="hero-photo-sm">
            <img src="https://images.unsplash.com/photo-1540518614846-7eded433c457?w=400&q=80" alt="Area bersama">
        </div>
        <div class="hero-price">
            <div class="num">Rp 1,2jt</div>
            <div class="lbl">per bulan</div>
        </div>
    </div>
</div>

{{-- ── STATS STRIP ── --}}
<div class="stats-bar">
    <div class="stats-inner">
        <div class="stat-cell"><div class="stat-num">15+</div><div class="stat-lbl">Kamar Aktif</div></div>
        <div class="stat-cell"><div class="stat-num">5+</div><div class="stat-lbl">Tahun Berdiri</div></div>
        <div class="stat-cell"><div class="stat-num">24/7</div><div class="stat-lbl">Keamanan CCTV</div></div>
        <div class="stat-cell"><div class="stat-num" style="color:#C9A252;">★ 4.9</div><div class="stat-lbl">Rating Penghuni</div></div>
    </div>
</div>

{{-- ── TENTANG / BENTO ── --}}
<section style="background:#F5EFE4;" id="tentang">
    <div class="wrap">
        <div class="bento">

            <div class="bcard bcard-text reveal">
                <div>
                    <p class="stag">Tentang Arcadia</p>
                    <h2 class="font-serif leading-tight" style="font-size:clamp(1.7rem,2.8vw,2.4rem);">Ruang yang<br>menyambut <em style="font-style:italic;color:#A65437;">pulang</em></h2>
                </div>
                <div>
                    <p style="font-size:0.88rem;color:#8A7F72;line-height:1.8;margin-bottom:1.4rem;font-weight:300;">Arcadia Kost hadir untuk mendukung gaya hidup modern di Lombok. Nyaman untuk belajar, bekerja, dan beristirahat — dengan pengelola yang responsif dan lingkungan yang aman.</p>
                    <a href="#kontak" style="font-size:0.82rem;font-weight:500;color:#A65437;border-bottom:1.5px solid #A65437;padding-bottom:2px;text-decoration:none;">Hubungi Kami →</a>
                </div>
            </div>

            <div class="bcard bcard-feat reveal d1">
                <div class="ficon" style="background:#F5EFE4;margin-bottom:0.9rem;">🌊</div>
                <div style="font-size:0.95rem;font-weight:500;margin-bottom:6px;">Dekat Wisata Lombok</div>
                <p style="font-size:0.8rem;color:#8A7F72;line-height:1.7;">Akses mudah ke Pantai Senggigi, Gili Trawangan, dan pusat kota Mataram.</p>
            </div>

            <div class="bcard bcard-feat reveal d2">
                <div class="ficon" style="background:#F5EFE4;margin-bottom:0.9rem;">🔐</div>
                <div style="font-size:0.95rem;font-weight:500;margin-bottom:6px;">Keamanan Terjamin</div>
                <p style="font-size:0.8rem;color:#8A7F72;line-height:1.7;">CCTV aktif 24 jam dan penjaga kost yang selalu siaga untuk kenyamanan Anda.</p>
            </div>

            <div class="bcard bcard-img reveal" style="grid-column:span 2;min-height:210px;">
                <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=1000&q=80" alt="Interior kamar" loading="lazy">
                <div class="bcard-img-ov"></div>
                <div class="bcard-img-cap">
                    <div style="color:#fff;font-size:1.05rem;font-weight:500;margin-bottom:4px;">Interior Modern & Bersih</div>
                    <div style="color:rgba(255,255,255,0.6);font-size:0.78rem;">Furnitur lengkap, ventilasi baik, dan suasana nyaman setiap hari.</div>
                </div>
            </div>

            <div class="bcard bcard-img reveal" style="min-height:210px;">
                <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=600&q=80" alt="Dapur bersama" loading="lazy">
                <div class="bcard-img-ov"></div>
                <div class="bcard-img-cap">
                    <div style="color:#fff;font-size:0.95rem;font-weight:500;margin-bottom:4px;">Dapur & Area Bersama</div>
                    <div style="color:rgba(255,255,255,0.6);font-size:0.75rem;">Bersih, lengkap, dan nyaman digunakan bersama.</div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ── LOMBOK HIGHLIGHT ── --}}
<div class="lombok-banner">
    <div class="lombok-inner">
        <div>
            <p class="stag" style="color:rgba(255,255,255,0.45);">Kenapa Lombok</p>
            <h2 class="font-serif text-white mb-3" style="font-size:clamp(1.8rem,3vw,2.4rem);">Hidup di Lombok,<br>pilihan <em>cerdas</em></h2>
            <p style="color:rgba(255,255,255,0.55);font-size:0.88rem;line-height:1.8;max-width:380px;font-weight:300;">Lombok berkembang pesat sebagai destinasi wisata dan bisnis. Tinggal di Arcadia berarti Anda berada di pusat pertumbuhan Nusa Tenggara Barat.</p>
        </div>
        <div class="lombok-pt">
            @php
            $lomps = [
                ['icon'=>'🌴','t'=>'Alam Kelas Dunia','d'=>'Dekat Pantai Senggigi, Gili Trawangan, dan Gunung Rinjani'],
                ['icon'=>'📈','t'=>'Kota Berkembang','d'=>'Mataram sebagai pusat ekonomi & bisnis NTB yang terus tumbuh'],
                ['icon'=>'🕌','t'=>'Budaya Sasak','d'=>'Lingkungan ramah, tenang, dan kaya tradisi lokal yang unik'],
                ['icon'=>'✈️','t'=>'Akses Mudah','d'=>'Bandara Internasional Lombok hanya 30 menit dari kost'],
            ];
            @endphp
            @foreach($lomps as $l)
            <div class="lombok-item">
                <div style="font-size:1.4rem;flex-shrink:0;margin-top:2px;">{{ $l['icon'] }}</div>
                <div>
                    <div style="color:#fff;font-size:0.88rem;font-weight:500;margin-bottom:2px;">{{ $l['t'] }}</div>
                    <div style="color:rgba(255,255,255,0.5);font-size:0.78rem;line-height:1.5;">{{ $l['d'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ── FASILITAS ── --}}
<section style="background:#e2e3e7;" id="fasilitas">
    <div class="wrap">
        <div class="mb-10 reveal">
            <p class="stag">Fasilitas</p>
            <h2 class="stitle">Semua yang Anda<br>butuhkan tersedia</h2>
            <p class="ssub">Semua fasilitas sudah termasuk dalam harga sewa — tanpa biaya tersembunyi.</p>
        </div>
        <div class="fasi-grid reveal">
            @php
            $fasilitas = [
                ['i'=>'📶','n'=>'WiFi Fiber 100Mbps','d'=>'Koneksi stabil untuk WFH & streaming'],
                ['i'=>'❄️','n'=>'AC per Kamar','d'=>'AC individual dengan remote sendiri'],
                ['i'=>'🚿','n'=>'Kamar Mandi Dalam','d'=>'Kamar mandi pribadi + water heater'],
                ['i'=>'🧹','n'=>'Kebersihan Rutin','d'=>'Layanan kebersihan 3× seminggu'],
                ['i'=>'🅿️','n'=>'Parkir Gratis','d'=>'Area parkir motor & mobil aman'],
                ['i'=>'📹','n'=>'CCTV 24 Jam','d'=>'Pengawasan penuh seluruh area kost'],
                ['i'=>'🍳','n'=>'Dapur Bersama','d'=>'Peralatan masak lengkap tersedia'],
                ['i'=>'⚡','n'=>'Listrik Termasuk','d'=>'Tanpa batas, sudah termasuk sewa'],
            ];
            @endphp
            @foreach($fasilitas as $f)
            <div class="fcard">
                <div class="ficon">{{ $f['i'] }}</div>
                <div style="font-size:0.85rem;font-weight:500;margin-bottom:4px;">{{ $f['n'] }}</div>
                <div style="font-size:0.77rem;color:#8A7F72;line-height:1.6;">{{ $f['d'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── KAMAR (1 tipe standar) ── --}}
<section style="background:#fff;" id="kamar">
    <div class="wrap">
        <div class="mb-10 reveal">
            <p class="stag">Tipe Kamar</p>
            <h2 class="stitle">Kamar Standar</h2>
            <p class="ssub">Satu tipe kamar terbaik — dirancang optimal dengan harga terjangkau untuk penghuni Lombok.</p>
        </div>

        <div class="room-layout">
            <div class="room-gallery reveal">
                <div class="rgal-main">
                    <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=900&q=80" alt="Kamar Standar Arcadia" loading="lazy">
                </div>
                <div class="rgal-sm">
                    <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=500&q=80" alt="Area duduk" loading="lazy">
                </div>
                <div class="rgal-sm">
                    <img src="https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?w=500&q=80" alt="Kamar mandi" loading="lazy">
                </div>
            </div>

            <div class="reveal d1">
                <div class="room-badge">Tipe Standar · Satu-satunya</div>
                <h3 class="room-name">Kamar Standar</h3>
                <div class="room-price">Rp 1.200.000</div>
                <p style="font-size:0.78rem;color:#8A7F72;margin:6px 0 1.75rem;">per bulan · semua sudah termasuk</p>

                <div class="room-specs">
                    <div class="rspec"><div class="rspec-lbl">Luas</div><div class="rspec-val">12 m²</div></div>
                    <div class="rspec"><div class="rspec-lbl">Kasur</div><div class="rspec-val">Single</div></div>
                    <div class="rspec"><div class="rspec-lbl">Lantai</div><div class="rspec-val">1 – 3</div></div>
                </div>

                <p style="font-size:0.65rem;color:#8A7F72;letter-spacing:0.1em;text-transform:uppercase;margin-bottom:0.75rem;">Yang sudah termasuk</p>
                <div class="rincludes">
                    @foreach(['AC + remote', 'Kasur + bantal + sprei', 'Lemari pakaian', 'Meja & kursi belajar', 'Kamar mandi dalam + water heater', 'WiFi fiber unlimited', 'Listrik & air', 'Kebersihan rutin 3×/minggu'] as $inc)
                    <div class="rinclude">{{ $inc }}</div>
                    @endforeach
                </div>

                <div class="flex gap-3 flex-wrap">
                    <a href="#kontak" class="btn btn-teal">Tanya Ketersediaan →</a>
                    <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-ghost">WhatsApp</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── PERATURAN ── --}}
<section style="background:#F5EFE4;">
    <div class="wrap">
        <div class="mb-10 reveal">
            <p class="stag">Tata Tertib</p>
            <h2 class="stitle">Peraturan Kost<br>Arcadia</h2>
        </div>
        <div class="rules-grid reveal">
            @php
            $rules = [
                ['no'=>'01','t'=>'Tamu & Kunjungan','d'=>'Tamu hanya diperbolehkan berkunjung hingga pukul 22.00 WITA. Wajib lapor ke pengelola.'],
                ['no'=>'02','t'=>'Kebersihan','d'=>'Penghuni wajib menjaga kebersihan kamar dan area bersama. Sampah dibuang pada tempatnya.'],
                ['no'=>'03','t'=>'Ketenangan','d'=>'Dilarang membuat kebisingan berlebihan, terutama setelah pukul 22.00 WITA.'],
                ['no'=>'04','t'=>'Pembayaran','d'=>'Sewa dibayar paling lambat tanggal 5 setiap bulan. Keterlambatan dikenakan denda.'],
                ['no'=>'05','t'=>'Hewan Peliharaan','d'=>'Tidak diperbolehkan membawa hewan peliharaan ke dalam area kost.'],
                ['no'=>'06','t'=>'Kendaraan','d'=>'Parkir hanya di area yang ditentukan. Satu kamar untuk satu kendaraan.'],
            ];
            @endphp
            @foreach($rules as $r)
            <div class="rule-card">
                <div style="font-family:'Poppins',sans-serif;font-size:2.2rem;color:#E2D9CC;line-height:1;margin-bottom:1rem;">{{ $r['no'] }}</div>
                <div style="font-size:0.92rem;font-weight:500;margin-bottom:6px;">{{ $r['t'] }}</div>
                <div style="font-size:0.8rem;color:#8A7F72;line-height:1.7;">{{ $r['d'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── LOKASI ── --}}
<section style="background:#fff;" id="lokasi">
    <div class="wrap">
        <div class="mb-10 reveal">
            <p class="stag">Lokasi</p>
            <h2 class="stitle">Strategis di<br>Kota Mataram</h2>
        </div>
        <div class="lokasi-grid">
            <div class="reveal">
                <p style="font-size:0.98rem;color:#4A4540;line-height:1.8;padding-left:1rem;border-left:3px solid #A65437;margin-bottom:1.75rem;">
                    Jl. Arcadia No. 12, Cakranegara,<br>
                    Kota Mataram, Lombok, NTB 83239
                </p>
                <div class="lm-list" style="margin-bottom:1.75rem;">
                    @php
                    $lm = [
                        ['i'=>'🎓','n'=>'Universitas Mataram','d'=>'10 menit berkendara'],
                        ['i'=>'🏪','n'=>'Mataram Mall','d'=>'5 menit berkendara'],
                        ['i'=>'🌊','n'=>'Pantai Senggigi','d'=>'20 menit berkendara'],
                        ['i'=>'✈️','n'=>'Bandara Internasional Lombok','d'=>'30 menit berkendara'],
                        ['i'=>'🛒','n'=>'Indomaret & Alfamart','d'=>'3 menit jalan kaki'],
                    ];
                    @endphp
                    @foreach($lm as $l)
                    <div class="lm-item">
                        <div class="lm-icon">{{ $l['i'] }}</div>
                        <div>
                            <div style="font-size:0.86rem;font-weight:500;">{{ $l['n'] }}</div>
                            <div style="font-size:0.74rem;color:#8A7F72;">{{ $l['d'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <a href="https://maps.google.com" target="_blank" class="btn btn-teal">Buka Google Maps →</a>
            </div>
            <div class="map-box reveal d1">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63245.36!2d116.07634!3d-8.58354!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dcdbef2b00a5a35%3A0x8e3fb75db7e2cdf!2sMataram%2C%20NTB!5e0!3m2!1sid!2sid!4v1699999999" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</section>

{{-- ── TESTIMONI ── --}}
<section style="background:#F5EFE4;">
    <div class="wrap">
        <div class="flex items-end justify-between mb-10 reveal">
            <div>
                <p class="stag">Testimoni</p>
                <h2 class="stitle">Kata penghuni<br>kami</h2>
            </div>
            <div class="hidden md:flex items-center gap-2" style="color:#C9A252;">
                <span style="font-family:'Poppins',sans-serif;font-size:2.4rem;">4.9</span>
                <div>
                    <div style="font-size:0.82rem;">★★★★★</div>
                    <div style="font-size:0.72rem;color:#8A7F72;">80+ ulasan</div>
                </div>
            </div>
        </div>
        <div class="testi-grid reveal">
            @php
            $testi = [
                ['n'=>'Siti R.','i'=>'Mahasiswi, Unram','av'=>'SR','q'=>'"Kamarnya bersih banget dan pengelola super responsif. Selama di Lombok, saya nyaman banget di Arcadia!"'],
                ['n'=>'Bayu P.','i'=>'Pegawai Bank NTB','av'=>'BP','q'=>'"Lokasi strategis, WiFi kencang, AC dingin. Harganya worth it banget untuk fasilitas sebagus ini."'],
                ['n'=>'Ayu W.','i'=>'Freelancer Desainer','av'=>'AW','q'=>'"Lingkungannya tenang dan aman. Cocok banget untuk kerja remote seperti saya. Sangat recommended!"'],
            ];
            @endphp
            @foreach($testi as $t)
            <div class="tcard">
                <div style="color:#C9A252;font-size:0.82rem;margin-bottom:0.75rem;">★★★★★</div>
                <p class="tcard-q">{{ $t['q'] }}</p>
                <div style="display:flex;align-items:center;gap:0.75rem;">
                    <div class="tavatar">{{ $t['av'] }}</div>
                    <div>
                        <div style="font-size:0.84rem;font-weight:500;">{{ $t['n'] }}</div>
                        <div style="font-size:0.73rem;color:#8A7F72;">{{ $t['i'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── CTA / KONTAK ── --}}
<div class="cta-wrap" id="kontak">
    <div class="cta-deco">Arcadia</div>
    <div class="cta-inner">
        <div class="grid md:grid-cols-2 gap-10 items-center reveal">
            <div>
                <p class="stag" style="color:rgba(255,255,255,0.35);">Tertarik?</p>
                <h2 class="font-serif text-white mb-3" style="font-size:clamp(1.8rem,3.5vw,3rem);">Siap pindah ke<br>Arcadia Lombok?</h2>
                <p style="color:rgba(255,255,255,0.5);font-size:0.88rem;line-height:1.8;max-width:400px;font-weight:300;margin-bottom:2rem;">Hubungi kami untuk cek ketersediaan kamar atau jadwalkan kunjungan langsung ke lokasi di Mataram.</p>
                <div class="flex flex-wrap gap-3">
                    <a href="https://wa.me/6281234567890?text=Halo%2C+saya+tertarik+dengan+Arcadia+Kost+Lombok" target="_blank" class="btn btn-teal">WhatsApp Sekarang →</a>
                </div>
            </div>
            <div>
                <div style="display:flex;flex-direction:column;gap:1rem;">
                    @foreach([['lbl'=>'WhatsApp','val'=>'0812-3456-7890'],['lbl'=>'Instagram','val'=>'@arcadiakost.id'],['lbl'=>'Email','val'=>'info@arcadiakost.id'],['lbl'=>'Alamat','val'=>'Cakranegara, Mataram, NTB']] as $c)
                    <div style="border-bottom:0.5px solid rgba(255,255,255,0.08);padding-bottom:0.85rem;">
                        <div style="color:rgba(255,255,255,0.3);font-size:0.65rem;letter-spacing:0.1em;text-transform:uppercase;margin-bottom:3px;">{{ $c['lbl'] }}</div>
                        <div style="color:#fff;font-family:'Poppins',sans-serif;font-size:1.1rem;">{{ $c['val'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── FOOTER ── --}}
<footer>
    <div class="footer-inner">
        <div class="footer-grid">
            <div>
                <div style="font-family:'Poppins',sans-serif;font-size:1.6rem;color:#fff;margin-bottom:0.75rem;">Arcadia<span style="color:#A65437;">.</span></div>
                <p style="font-size:0.8rem;color:rgba(255,255,255,0.3);line-height:1.8;max-width:240px;">Hunian modern yang nyaman dan strategis di Kota Mataram, Lombok, NTB.</p>
                <div class="sasak-stripe" style="margin-top:1.2rem;width:72px;border-radius:4px;"></div>
            </div>
            <div>
                <h4 style="color:rgba(255,255,255,0.25);font-size:0.62rem;letter-spacing:0.1em;text-transform:uppercase;margin-bottom:1rem;">Navigasi</h4>
                <ul style="list-style:none;display:flex;flex-direction:column;gap:0.55rem;">
                    @foreach(['Beranda'=>'#','Tentang'=>'#tentang','Fasilitas'=>'#fasilitas','Kamar'=>'#kamar','Lokasi'=>'#lokasi','Kontak'=>'#kontak'] as $label => $href)
                    <li><a href="{{ $href }}" style="color:rgba(255,255,255,0.4);font-size:0.82rem;text-decoration:none;">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4 style="color:rgba(255,255,255,0.25);font-size:0.62rem;letter-spacing:0.1em;text-transform:uppercase;margin-bottom:1rem;">Kontak</h4>
                <ul style="list-style:none;display:flex;flex-direction:column;gap:0.55rem;color:rgba(255,255,255,0.4);font-size:0.82rem;">
                    <li>Jl. Arcadia No. 12, Cakranegara</li>
                    <li>Mataram, Lombok, NTB 83239</li>
                    <li style="margin-top:4px;"><a href="tel:+6281234567890" style="color:rgba(255,255,255,0.4);text-decoration:none;">0812-3456-7890</a></li>
                    <li><a href="mailto:info@arcadiakost.id" style="color:rgba(255,255,255,0.4);text-decoration:none;">info@arcadiakost.id</a></li>
                </ul>
            </div>
        </div>
        <div style="border-top:0.5px solid rgba(255,255,255,0.07);padding-top:1.4rem;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.5rem;">
            <p style="color:rgba(255,255,255,0.18);font-size:0.73rem;">© {{ date('Y') }} Arcadia Kost Lombok. All rights reserved.</p>
            <p style="color:rgba(255,255,255,0.18);font-size:0.73rem;">Mataram, NTB 🌴</p>
        </div>
    </div>
</footer>

<div class="sasak-stripe"></div>

{{-- WhatsApp Float --}}
<a href="https://wa.me/6281234567890?text=Halo%2C+saya+tertarik+dengan+Arcadia+Kost+Lombok" target="_blank" class="wa-btn" aria-label="WhatsApp">
    <svg width="26" height="26" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
</a>

<script>
    const reveals = document.querySelectorAll('.reveal');
    const obs = new IntersectionObserver((entries) => {
        entries.forEach((e, i) => {
            if (e.isIntersecting) {
                setTimeout(() => e.target.classList.add('in'), i * 60);
                obs.unobserve(e.target);
            }
        });
    }, { threshold: 0.08 });
    reveals.forEach(el => obs.observe(el));

    const secs = document.querySelectorAll('[id]');
    const links = document.querySelectorAll('.nav-links a');
    window.addEventListener('scroll', () => {
        let cur = '';
        secs.forEach(s => { if (window.scrollY >= s.offsetTop - 80) cur = s.id; });
        links.forEach(a => {
            a.classList.remove('active');
            if (a.getAttribute('href') === '#' + cur) a.classList.add('active');
        });
    });
</script>

{{-- Chat Widget for customers --}}
<x-chat-widget />

</body>
</html>