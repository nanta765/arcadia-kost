<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Kost Arca | Premium Living</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
<style>
  :root {
    --cream: #F8F5F0;
    --stone: #EAE5DE;
    --warm-gray: #9B9289;
    --dark: #1C1916;
    --accent: #C4A882;
  }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  html { scroll-behavior: smooth; }
  body {
    background: var(--cream);
    color: var(--dark);
    font-family: 'Plus Jakarta Sans', sans-serif;
    -webkit-font-smoothing: antialiased;
  }
  .font-display { font-family: 'Cormorant Garamond', serif; }

  /* Nav */
  nav {
    position: fixed; top: 0; left: 0; right: 0; z-index: 100;
    background: rgba(248,245,240,0.9);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--stone);
    height: 60px;
    display: flex; align-items: center;
    padding: 0 48px;
    justify-content: space-between;
  }
  .nav-logo { font-family: 'Cormorant Garamond', serif; font-size: 22px; font-weight: 600; letter-spacing: -0.3px; }
  .nav-links a {
    font-size: 13px; font-weight: 400; color: var(--warm-gray);
    text-decoration: none; margin-left: 32px; letter-spacing: 0.3px;
    transition: color .2s;
  }
  .nav-links a:hover, .nav-links a.active { color: var(--dark); }
  .btn-book {
    background: var(--dark); color: var(--cream);
    font-size: 12px; font-weight: 500; letter-spacing: 0.5px;
    border: none; border-radius: 100px; padding: 9px 24px; cursor: pointer;
    transition: opacity .2s;
  }
  .btn-book:hover { opacity: .82; }
  .btn-outline {
    background: transparent; color: var(--dark);
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; font-weight: 500;
    border: 1px solid var(--dark); border-radius: 100px; padding: 9px 24px; cursor: pointer;
    transition: background .2s, color .2s;
    text-decoration: none; display: inline-block;
  }
  .btn-outline:hover { background: var(--dark); color: var(--cream); }

  /* Gallery */
  .gallery-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr 1fr;
    grid-template-rows: 240px 240px;
    gap: 8px;
    border-radius: 16px;
    overflow: hidden;
  }
  .gallery-grid .main {
    grid-row: 1 / 3;
    position: relative;
  }
  .gallery-grid img {
    width: 100%; height: 100%; object-fit: cover; display: block;
    transition: transform .5s ease;
  }
  .gallery-grid .cell:hover img { transform: scale(1.03); }
  .gallery-grid .cell { overflow: hidden; }
  .gallery-pill {
    position: absolute; bottom: 14px; right: 14px;
    background: rgba(28,25,22,0.75);
    color: #fff; font-size: 11px; letter-spacing: 0.3px;
    padding: 5px 14px; border-radius: 100px;
    cursor: pointer;
  }

  /* Tag pill */
  .tag {
    display: inline-flex; align-items: center; gap: 4px;
    background: var(--stone); color: var(--warm-gray);
    font-size: 11px; font-weight: 500; letter-spacing: 0.4px;
    border-radius: 100px; padding: 4px 12px;
  }
  .tag.green { background: #E8F5E2; color: #3A7C2E; }
  .tag.accent { background: #F5EEE3; color: #9B7346; }

  /* Room type nav */
  .room-type-nav {
    display: flex; gap: 6px; flex-wrap: wrap;
  }
  .room-type-btn {
    background: var(--stone); border: none; border-radius: 100px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 12px; font-weight: 500; color: var(--warm-gray);
    padding: 7px 18px; cursor: pointer; transition: all .2s;
  }
  .room-type-btn.active, .room-type-btn:hover {
    background: var(--dark); color: var(--cream);
  }

  /* Room cards */
  .room-card {
    background: #fff; border-radius: 16px;
    overflow: hidden; border: 1px solid var(--stone);
    transition: transform .3s ease, box-shadow .3s ease;
  }
  .room-card:hover { transform: translateY(-4px); box-shadow: 0 16px 48px rgba(0,0,0,.08); }
  .room-card img { width: 100%; height: 220px; object-fit: cover; display: block; }
  .room-card-body { padding: 20px 22px 24px; }

  /* Feature row */
  .feature-row {
    display: flex; align-items: center; gap: 6px;
    font-size: 12px; color: var(--warm-gray);
  }
  .feature-dot { width: 4px; height: 4px; background: var(--accent); border-radius: 50%; }

  /* Stats */
  .stat-item { border-right: 1px solid var(--stone); padding: 0 28px; }
  .stat-item:first-child { padding-left: 0; }
  .stat-item:last-child { border-right: none; }

  /* Amenity chip */
  .amenity-chip {
    display: flex; flex-direction: column; align-items: center; gap: 8px;
    background: #fff; border: 1px solid var(--stone);
    border-radius: 14px; padding: 20px 14px;
    transition: border-color .2s;
  }
  .amenity-chip:hover { border-color: var(--accent); }
  .amenity-chip svg { width: 24px; height: 24px; stroke: var(--dark); }

  /* Location row */
  .loc-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 16px 0; border-bottom: 1px solid var(--stone);
  }
  .loc-row:last-child { border-bottom: none; }

  /* FAQ */
  details summary { list-style: none; }
  details summary::-webkit-details-marker { display: none; }
  details[open] .chevron { transform: rotate(180deg); }
  .chevron { transition: transform .25s; }

  /* Floating CTA */
  .sticky-cta {
    position: sticky; top: 72px;
    background: #fff; border: 1px solid var(--stone);
    border-radius: 20px; padding: 28px 26px;
  }

  /* Section label */
  .section-label {
    font-size: 11px; font-weight: 600; letter-spacing: 1.5px;
    text-transform: uppercase; color: var(--accent);
    margin-bottom: 10px;
  }

  /* Divider */
  .divider { border: none; border-top: 1px solid var(--stone); margin: 56px 0; }

  /* Image overlay gradient */
  .overlay-gradient {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(28,25,22,.45) 0%, transparent 50%);
    pointer-events: none;
  }

  /* Scroll reveal */
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .reveal { animation: fadeUp .6s ease both; }
  .reveal-2 { animation: fadeUp .6s .12s ease both; }
  .reveal-3 { animation: fadeUp .6s .24s ease both; }

  @media (max-width: 768px) {
    nav { padding: 0 20px; }
    .nav-links, .btn-book { display: none; }
    .mobile-menu-btn { display: flex !important; }
    .gallery-grid {
      grid-template-columns: 1fr 1fr;
      grid-template-rows: 200px 160px;
    }
    .gallery-grid .main { grid-column: 1 / 3; grid-row: 1 / 2; }
    .stat-item { padding: 0 16px; }
  }
</style>
</head>
<body>

<!-- NAV -->
<nav>
  <div class="nav-logo">Kost Arca</div>
  <div class="nav-links" style="display:flex">
    <a href="#rooms" class="active">Rooms</a>
    <a href="#amenities">Amenities</a>
    <a href="#location">Location</a>
    <a href="#faq">FAQ</a>
  </div>
  <div style="display:flex;align-items:center;gap:14px">
    <button class="btn-book" style="display:none" id="sticky-book-btn">Booking</button>
    <button class="btn-book">Book Now</button>
  </div>
  <button class="mobile-menu-btn" style="display:none;background:none;border:none;cursor:pointer">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
  </button>
</nav>

<!-- MAIN CONTENT -->
<main style="max-width:1200px;margin:0 auto;padding:0 32px;padding-top:80px">

  <!-- HERO / GALLERY + INFO -->
  <section style="padding:40px 0 0">
    <!-- Title row -->
    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:24px" class="reveal">
      <div>
        <p class="section-label">Malang, Jawa Timur</p>
        <h1 class="font-display" style="font-size:clamp(36px,4vw,52px);font-weight:600;line-height:1.1;letter-spacing:-0.5px">
          Arca — Hunian<br><em>Premium & Tenang.</em>
        </h1>
        <div style="display:flex;align-items:center;gap:8px;margin-top:14px;flex-wrap:wrap">
          <span class="tag green">● Tersedia Sekarang</span>
          <span class="tag">5 menit ke kampus</span>
          <span class="tag">100% Bebas Banjir</span>
        </div>
      </div>
      <div style="text-align:right;display:none" id="hero-price" class="reveal">
        <p style="font-size:12px;color:var(--warm-gray);letter-spacing:.3px">mulai dari</p>
        <p class="font-display" style="font-size:42px;font-weight:600;letter-spacing:-1px">Rp 1,5jt</p>
        <p style="font-size:12px;color:var(--warm-gray)">/bulan</p>
      </div>
    </div>

    <!-- Gallery grid -->
    <div class="gallery-grid reveal-2" style="margin-bottom:40px">
      <div class="main cell" style="position:relative">
        <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&auto=format&fit=crop" alt="Kamar Utama"/>
        <div class="overlay-gradient"></div>
        <span class="gallery-pill">+4 Foto</span>
      </div>
      <div class="cell">
        <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=500&auto=format&fit=crop" alt="Living Area"/>
      </div>
      <div class="cell">
        <img src="https://images.unsplash.com/photo-1560448204-603b3fc33ddc?w=500&auto=format&fit=crop" alt="Kamar Mandi"/>
      </div>
      <div class="cell">
        <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=500&auto=format&fit=crop" alt="Common Area"/>
      </div>
      <div class="cell">
        <img src="https://images.unsplash.com/photo-1616594039964-ae9021a400a0?w=500&auto=format&fit=crop" alt="Workspace"/>
      </div>
    </div>

    <!-- Stats row -->
    <div style="display:flex;align-items:center;margin-bottom:40px;overflow-x:auto" class="reveal-3">
      <div class="stat-item">
        <p style="font-size:11px;color:var(--warm-gray);letter-spacing:.4px;margin-bottom:4px">UNIT TERSEDIA</p>
        <p class="font-display" style="font-size:24px;font-weight:600">12 Unit</p>
      </div>
      <div class="stat-item">
        <p style="font-size:11px;color:var(--warm-gray);letter-spacing:.4px;margin-bottom:4px">LUAS KAMAR</p>
        <p class="font-display" style="font-size:24px;font-weight:600">18–24 m²</p>
      </div>
      <div class="stat-item">
        <p style="font-size:11px;color:var(--warm-gray);letter-spacing:.4px;margin-bottom:4px">RATING PENGHUNI</p>
        <p class="font-display" style="font-size:24px;font-weight:600">4.9 ★</p>
      </div>
      <div class="stat-item">
        <p style="font-size:11px;color:var(--warm-gray);letter-spacing:.4px;margin-bottom:4px">SEJAK</p>
        <p class="font-display" style="font-size:24px;font-weight:600">2019</p>
      </div>
    </div>
  </section>

  <hr class="divider">

  <!-- TWO-COLUMN LAYOUT: Content + Sticky CTA -->
  <div style="display:grid;grid-template-columns:1fr 340px;gap:64px;align-items:start">

    <!-- LEFT COLUMN -->
    <div>

      <!-- ROOMS SECTION -->
      <section id="rooms" style="margin-bottom:64px">
        <p class="section-label">Pilihan Kamar</p>
        <h2 class="font-display" style="font-size:36px;font-weight:600;margin-bottom:24px">Temukan Kamar Ideal Anda</h2>
        
        <div class="room-type-nav" style="margin-bottom:28px">
          <button class="room-type-btn active">Semua</button>
          <button class="room-type-btn">Deluxe</button>
          <button class="room-type-btn">Superior</button>
          <button class="room-type-btn">Suite</button>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px" id="room-grid">
          <!-- Card 1 -->
          <div class="room-card">
            <div style="position:relative;overflow:hidden">
              <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=600&auto=format&fit=crop" alt="Deluxe Room"/>
              <span style="position:absolute;top:12px;left:12px" class="tag green">Sisa 2 Kamar</span>
            </div>
            <div class="room-card-body">
              <p style="font-size:11px;color:var(--warm-gray);letter-spacing:.8px;text-transform:uppercase;margin-bottom:6px">/Kamar Deluxe</p>
              <p class="font-display" style="font-size:26px;font-weight:600;margin-bottom:4px">Rp 1.500.000<span style="font-family:'Plus Jakarta Sans';font-size:13px;font-weight:400;color:var(--warm-gray)"> / bulan</span></p>
              <div class="feature-row" style="margin:10px 0 16px">
                <span class="feature-dot"></span><span>18 m²</span>
                <span class="feature-dot"></span><span>AC + Smart TV</span>
                <span class="feature-dot"></span><span>KM Dalam</span>
              </div>
              <a href="#" class="btn-outline" style="width:100%;text-align:center;font-size:12px;padding:9px 0">Detail Kamar</a>
            </div>
          </div>

          <!-- Card 2 -->
          <div class="room-card">
            <div style="position:relative;overflow:hidden">
              <img src="https://images.unsplash.com/photo-1616594039964-ae9021a400a0?w=600&auto=format&fit=crop" alt="Superior Room"/>
              <span style="position:absolute;top:12px;left:12px" class="tag accent">Tersedia</span>
            </div>
            <div class="room-card-body">
              <p style="font-size:11px;color:var(--warm-gray);letter-spacing:.8px;text-transform:uppercase;margin-bottom:6px">/Kamar Superior</p>
              <p class="font-display" style="font-size:26px;font-weight:600;margin-bottom:4px">Rp 2.000.000<span style="font-family:'Plus Jakarta Sans';font-size:13px;font-weight:400;color:var(--warm-gray)"> / bulan</span></p>
              <div class="feature-row" style="margin:10px 0 16px">
                <span class="feature-dot"></span><span>22 m²</span>
                <span class="feature-dot"></span><span>AC + Smart TV</span>
                <span class="feature-dot"></span><span>Working Desk</span>
              </div>
              <a href="#" class="btn-outline" style="width:100%;text-align:center;font-size:12px;padding:9px 0">Detail Kamar</a>
            </div>
          </div>

          <!-- Card 3 -->
          <div class="room-card">
            <div style="position:relative;overflow:hidden">
              <img src="https://images.unsplash.com/photo-1540518614846-7eded433c457?w=600&auto=format&fit=crop" alt="Suite Room"/>
              <span style="position:absolute;top:12px;left:12px" class="tag">Terbatas</span>
            </div>
            <div class="room-card-body">
              <p style="font-size:11px;color:var(--warm-gray);letter-spacing:.8px;text-transform:uppercase;margin-bottom:6px">/Kamar Suite</p>
              <p class="font-display" style="font-size:26px;font-weight:600;margin-bottom:4px">Rp 2.800.000<span style="font-family:'Plus Jakarta Sans';font-size:13px;font-weight:400;color:var(--warm-gray)"> / bulan</span></p>
              <div class="feature-row" style="margin:10px 0 16px">
                <span class="feature-dot"></span><span>24 m²</span>
                <span class="feature-dot"></span><span>AC + Bathtub</span>
                <span class="feature-dot"></span><span>Corner View</span>
              </div>
              <a href="#" class="btn-outline" style="width:100%;text-align:center;font-size:12px;padding:9px 0">Detail Kamar</a>
            </div>
          </div>
        </div>
      </section>

      <!-- AMENITIES SECTION -->
      <section id="amenities" style="margin-bottom:64px">
        <p class="section-label">Fasilitas</p>
        <h2 class="font-display" style="font-size:36px;font-weight:600;margin-bottom:28px">Lengkap, Tanpa Kompromi</h2>
        <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:12px">
          <div class="amenity-chip">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><path d="M5 12.55a11 11 0 0114.08 0M1.42 9a16 16 0 0121.16 0M8.53 16.11a6 6 0 016.95 0M12 20h.01"/></svg>
            <span style="font-size:11px;font-weight:500;text-align:center">Wi-Fi Cepat</span>
          </div>
          <div class="amenity-chip">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><path d="M4 3h16v13H4zM8 20h8M12 17v3"/></svg>
            <span style="font-size:11px;font-weight:500;text-align:center">Smart TV</span>
          </div>
          <div class="amenity-chip">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><path d="M9.5 2A2.5 2.5 0 0112 4.5v15a2.5 2.5 0 01-4.96-.46 2.5 2.5 0 01.06-1.07 9 9 0 00.4-3v-1a2 2 0 014 0v3a2 2 0 004 0v-3a6 6 0 00-6-6H9.5z"/><rect x="2" y="12" width="6" height="10" rx="2"/></svg>
            <span style="font-size:11px;font-weight:500;text-align:center">AC</span>
          </div>
          <div class="amenity-chip">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><path d="M4 12h8m-8 4h12M4 8h16M20 4H4v16h16V4z"/></svg>
            <span style="font-size:11px;font-weight:500;text-align:center">KM Dalam</span>
          </div>
          <div class="amenity-chip">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><path d="M3 22V2h18v20M9 22V12h6v10"/></svg>
            <span style="font-size:11px;font-weight:500;text-align:center">Laundry</span>
          </div>
          <div class="amenity-chip">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            <span style="font-size:11px;font-weight:500;text-align:center">CCTV 24/7</span>
          </div>
          <div class="amenity-chip">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
            <span style="font-size:11px;font-weight:500;text-align:center">Parkir Motor</span>
          </div>
          <div class="amenity-chip">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
            <span style="font-size:11px;font-weight:500;text-align:center">Ruang Kerja</span>
          </div>
          <div class="amenity-chip">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <span style="font-size:11px;font-weight:500;text-align:center">Area Bersama</span>
          </div>
          <div class="amenity-chip">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><path d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8zM6 1v3M10 1v3M14 1v3"/></svg>
            <span style="font-size:11px;font-weight:500;text-align:center">Air Panas</span>
          </div>
        </div>
      </section>

      <!-- LOCATION SECTION -->
      <section id="location" style="margin-bottom:64px">
        <p class="section-label">Lokasi</p>
        <h2 class="font-display" style="font-size:36px;font-weight:600;margin-bottom:24px">Strategis di Jantung Kota</h2>
        
        <!-- Map placeholder -->
        <div style="background:var(--stone);border-radius:16px;height:200px;display:flex;align-items:center;justify-content:center;margin-bottom:24px;overflow:hidden;position:relative">
          <div style="position:absolute;inset:0;background:url('https://api.mapbox.com/styles/v1/mapbox/light-v11/static/112.6194,-7.9798,14,0/700x240@2x?access_token=pk.demo') center/cover;opacity:.7"></div>
          <div style="position:relative;background:var(--dark);color:var(--cream);border-radius:100px;padding:9px 22px;font-size:12px;font-weight:500;cursor:pointer">
            Lihat di Google Maps ↗
          </div>
        </div>

        <div style="background:#fff;border:1px solid var(--stone);border-radius:16px;padding:0 24px">
          <div class="loc-row">
            <div style="display:flex;align-items:center;gap:14px">
              <div style="width:36px;height:36px;background:var(--stone);border-radius:50%;display:flex;align-items:center;justify-content:center">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 10v6M2 10l10-5 10 5M6 12v5c3 3 9 3 12 0v-5"/></svg>
              </div>
              <span style="font-size:14px;font-weight:500">Universitas Brawijaya</span>
            </div>
            <span class="tag green">5 menit</span>
          </div>
          <div class="loc-row">
            <div style="display:flex;align-items:center;gap:14px">
              <div style="width:36px;height:36px;background:var(--stone);border-radius:50%;display:flex;align-items:center;justify-content:center">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 10v6M2 10l10-5 10 5M6 12v5c3 3 9 3 12 0v-5"/></svg>
              </div>
              <span style="font-size:14px;font-weight:500">Universitas Negeri Malang</span>
            </div>
            <span class="tag green">8 menit</span>
          </div>
          <div class="loc-row">
            <div style="display:flex;align-items:center;gap:14px">
              <div style="width:36px;height:36px;background:var(--stone);border-radius:50%;display:flex;align-items:center;justify-content:center">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18M16 10a4 4 0 01-8 0"/></svg>
              </div>
              <span style="font-size:14px;font-weight:500">Minimarket Terdekat</span>
            </div>
            <span class="tag">2 menit</span>
          </div>
          <div class="loc-row">
            <div style="display:flex;align-items:center;gap:14px">
              <div style="width:36px;height:36px;background:var(--stone);border-radius:50%;display:flex;align-items:center;justify-content:center">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8z"/></svg>
              </div>
              <span style="font-size:14px;font-weight:500">Café & Restoran</span>
            </div>
            <span class="tag">5 menit</span>
          </div>
        </div>
      </section>

      <!-- FAQ SECTION -->
      <section id="faq" style="margin-bottom:64px">
        <p class="section-label">FAQ</p>
        <h2 class="font-display" style="font-size:36px;font-weight:600;margin-bottom:28px">Pertanyaan Umum</h2>
        
        <div style="display:flex;flex-direction:column;gap:10px">
          <details style="background:#fff;border:1px solid var(--stone);border-radius:14px;padding:0 22px">
            <summary style="display:flex;justify-content:space-between;align-items:center;cursor:pointer;padding:20px 0;font-size:14px;font-weight:500">
              Apakah harga sudah termasuk listrik?
              <svg class="chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="6 9 12 15 18 9"/></svg>
            </summary>
            <div style="padding-bottom:20px;font-size:13px;color:var(--warm-gray);line-height:1.7">
              Tidak, biaya listrik ditanggung masing-masing penyewa menggunakan sistem token prabayar. Rata-rata penggunaan normal berkisar Rp 80.000–150.000 per bulan.
            </div>
          </details>
          
          <details style="background:#fff;border:1px solid var(--stone);border-radius:14px;padding:0 22px">
            <summary style="display:flex;justify-content:space-between;align-items:center;cursor:pointer;padding:20px 0;font-size:14px;font-weight:500">
              Berapa deposit awal yang diperlukan?
              <svg class="chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="6 9 12 15 18 9"/></svg>
            </summary>
            <div style="padding-bottom:20px;font-size:13px;color:var(--warm-gray);line-height:1.7">
              Deposit awal setara dengan harga sewa satu bulan. Deposit akan dikembalikan penuh saat masa sewa berakhir, selama tidak ada kerusakan pada fasilitas kamar.
            </div>
          </details>

          <details style="background:#fff;border:1px solid var(--stone);border-radius:14px;padding:0 22px">
            <summary style="display:flex;justify-content:space-between;align-items:center;cursor:pointer;padding:20px 0;font-size:14px;font-weight:500">
              Apakah boleh membawa hewan peliharaan?
              <svg class="chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="6 9 12 15 18 9"/></svg>
            </summary>
            <div style="padding-bottom:20px;font-size:13px;color:var(--warm-gray);line-height:1.7">
              Mohon maaf, saat ini kami belum mengizinkan hewan peliharaan demi kenyamanan seluruh penghuni.
            </div>
          </details>

          <details style="background:#fff;border:1px solid var(--stone);border-radius:14px;padding:0 22px">
            <summary style="display:flex;justify-content:space-between;align-items:center;cursor:pointer;padding:20px 0;font-size:14px;font-weight:500">
              Bagaimana sistem akses masuk?
              <svg class="chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="6 9 12 15 18 9"/></svg>
            </summary>
            <div style="padding-bottom:20px;font-size:13px;color:var(--warm-gray);line-height:1.7">
              Kami menggunakan sistem akses kartu pintar (smart card) untuk keamanan 24 jam. Setiap penghuni mendapatkan kartu akses pribadi yang hanya bisa digunakan untuk kamar masing-masing.
            </div>
          </details>
        </div>
      </section>

    </div>

    <!-- RIGHT COLUMN: STICKY CTA -->
    <div>
      <div class="sticky-cta">
        <p style="font-size:11px;color:var(--warm-gray);letter-spacing:.4px;margin-bottom:4px">MULAI DARI</p>
        <p class="font-display" style="font-size:38px;font-weight:600;line-height:1;margin-bottom:2px">Rp 1,5jt</p>
        <p style="font-size:12px;color:var(--warm-gray);margin-bottom:20px">/bulan · sudah termasuk fasilitas</p>

        <div style="background:var(--cream);border-radius:12px;padding:16px;margin-bottom:20px">
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px">
            <span style="font-size:12px;color:var(--warm-gray)">Check-in</span>
            <span style="font-size:13px;font-weight:500">Kapan saja</span>
          </div>
          <div style="height:1px;background:var(--stone);margin-bottom:10px"></div>
          <div style="display:flex;justify-content:space-between;align-items:center">
            <span style="font-size:12px;color:var(--warm-gray)">Tipe Kamar</span>
            <select style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;border:none;background:transparent;color:var(--dark);font-weight:500;cursor:pointer">
              <option>Pilih Tipe</option>
              <option>Deluxe – Rp 1.500.000</option>
              <option>Superior – Rp 2.000.000</option>
              <option>Suite – Rp 2.800.000</option>
            </select>
          </div>
        </div>

        <button style="width:100%;background:var(--dark);color:var(--cream);border:none;border-radius:100px;padding:14px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;letter-spacing:.3px;cursor:pointer;transition:opacity .2s;margin-bottom:12px" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
          Booking Sekarang
        </button>
        <button style="width:100%;background:transparent;color:var(--dark);border:1px solid var(--stone);border-radius:100px;padding:13px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:500;cursor:pointer;transition:background .2s" onmouseover="this.style.background='var(--stone)'" onmouseout="this.style.background='transparent'">
          Jadwalkan Survei
        </button>

        <div style="margin-top:20px;padding-top:20px;border-top:1px solid var(--stone);display:flex;align-items:center;gap:12px">
          <div style="width:42px;height:42px;border-radius:50%;background:var(--stone);overflow:hidden;flex-shrink:0">
            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&auto=format&fit=crop&crop=face" alt="Manager" style="width:100%;height:100%;object-fit:cover"/>
          </div>
          <div style="flex:1">
            <p style="font-size:13px;font-weight:500;margin-bottom:1px">Sarah Putri</p>
            <p style="font-size:11px;color:var(--warm-gray)">Property Manager</p>
          </div>
          <a href="tel:+6281234567890" style="background:var(--stone);border-radius:50%;width:34px;height:34px;display:flex;align-items:center;justify-content:center;text-decoration:none">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.9 11 19.79 19.79 0 01.87 2.38 2 2 0 012.86.21h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L7.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0121.22 15l.7 1.92z"/></svg>
          </a>
        </div>

        <div style="margin-top:16px;background:#F0FBF0;border-radius:10px;padding:10px 14px;display:flex;gap:8px;align-items:flex-start">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#3A7C2E" stroke-width="2" style="flex-shrink:0;margin-top:1px"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          <p style="font-size:11px;color:#3A7C2E;line-height:1.5">Bebas biaya booking. Pembayaran hanya setelah survei dan konfirmasi.</p>
        </div>
      </div>
    </div>

  </div>

</main>

<!-- FOOTER -->
<footer style="margin-top:80px;border-top:1px solid var(--stone);padding:40px 48px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px">
  <div>
    <p class="font-display" style="font-size:20px;font-weight:600">Kost Arca</p>
    <p style="font-size:12px;color:var(--warm-gray);margin-top:4px">© 2024 Arca Essence. Refined Living.</p>
  </div>
  <div style="display:flex;gap:28px;flex-wrap:wrap">
    <a href="#" style="font-size:12px;color:var(--warm-gray);text-decoration:none;transition:color .2s" onmouseover="this.style.color='#1C1916'" onmouseout="this.style.color='var(--warm-gray)'">Privacy Policy</a>
    <a href="#" style="font-size:12px;color:var(--warm-gray);text-decoration:none;transition:color .2s" onmouseover="this.style.color='#1C1916'" onmouseout="this.style.color='var(--warm-gray)'">Terms of Service</a>
    <a href="#" style="font-size:12px;color:var(--warm-gray);text-decoration:none;transition:color .2s" onmouseover="this.style.color='#1C1916'" onmouseout="this.style.color='var(--warm-gray)'">Hubungi Kami</a>
    <a href="#" style="font-size:12px;color:var(--warm-gray);text-decoration:none;transition:color .2s" onmouseover="this.style.color='#1C1916'" onmouseout="this.style.color='var(--warm-gray)'">Instagram</a>
  </div>
</footer>

<script>
  // Room type filter (UI demo)
  const btns = document.querySelectorAll('.room-type-btn');
  btns.forEach(btn => {
    btn.addEventListener('click', () => {
      btns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
    });
  });

  // Show hero price on larger screens
  if (window.innerWidth >= 768) {
    document.getElementById('hero-price').style.display = 'block';
  }

  // Sticky book button on scroll
  window.addEventListener('scroll', () => {
    const btn = document.getElementById('sticky-book-btn');
    if (btn && window.scrollY > 300) btn.style.display = 'block';
    else if (btn) btn.style.display = 'none';
  });
</script>

</body>
</html>