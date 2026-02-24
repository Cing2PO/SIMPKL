<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPKL - Sistem Informasi Manajemen Praktik Kerja Lapangan</title>
    <meta name="description"
        content="SIMPKL adalah sistem informasi untuk mengelola praktik kerja lapangan, logbook, absensi, dan evaluasi mahasiswa secara digital.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --primary-light: #818cf8;
            --primary-50: #eef2ff;
            --accent: #06b6d4;
            --accent-dark: #0891b2;
            --surface: #ffffff;
            --surface-alt: #f8fafc;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            --border: #e2e8f0;
            --gradient-start: #4f46e5;
            --gradient-end: #06b6d4;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text-primary);
            background: var(--surface);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            padding: 1rem 2rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid transparent;
        }

        .navbar.scrolled {
            border-bottom-color: var(--border);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .navbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: var(--text-primary);
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 1rem;
            letter-spacing: -0.5px;
        }

        .logo-text {
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: -0.5px;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.625rem 1.5rem;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
            letter-spacing: -0.01em;
        }

        .btn-ghost {
            color: var(--text-secondary);
            background: transparent;
        }

        .btn-ghost:hover {
            color: var(--text-primary);
            background: var(--primary-50);
        }

        .btn-outline {
            color: var(--primary);
            background: transparent;
            border: 1.5px solid var(--border);
        }

        .btn-outline:hover {
            border-color: var(--primary);
            background: var(--primary-50);
        }

        .btn-primary {
            color: white;
            background: linear-gradient(135deg, var(--gradient-start), var(--primary-dark));
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(79, 70, 229, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-lg {
            padding: 0.875rem 2rem;
            font-size: 1rem;
            border-radius: 12px;
        }

        .btn-white {
            color: var(--primary);
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-white:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        }

        /* ===== HERO ===== */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8rem 2rem 4rem;
            position: relative;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 50% at 50% -20%, rgba(79, 70, 229, 0.12), transparent),
                radial-gradient(ellipse 60% 40% at 80% 60%, rgba(6, 182, 212, 0.08), transparent),
                radial-gradient(ellipse 40% 30% at 20% 80%, rgba(79, 70, 229, 0.06), transparent);
        }

        .hero-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(79, 70, 229, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(79, 70, 229, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse 70% 60% at 50% 40%, black 30%, transparent 100%);
            -webkit-mask-image: radial-gradient(ellipse 70% 60% at 50% 40%, black 30%, transparent 100%);
        }

        .hero-content {
            position: relative;
            max-width: 800px;
            text-align: center;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 1rem 0.4rem 0.5rem;
            background: var(--primary-50);
            border: 1px solid rgba(79, 70, 229, 0.15);
            border-radius: 100px;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--primary);
            margin-bottom: 2rem;
            animation: fadeUp 0.6s ease forwards;
        }

        .hero-badge-dot {
            width: 8px;
            height: 8px;
            background: var(--primary);
            border-radius: 50%;
            animation: pulse-dot 2s ease-in-out infinite;
        }

        .hero h1 {
            font-size: clamp(2.5rem, 6vw, 4rem);
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -0.03em;
            margin-bottom: 1.5rem;
            animation: fadeUp 0.6s ease 0.1s forwards;
            opacity: 0;
        }

        .hero h1 .gradient-text {
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-desc {
            font-size: 1.2rem;
            color: var(--text-secondary);
            max-width: 560px;
            margin: 0 auto 2.5rem;
            line-height: 1.7;
            animation: fadeUp 0.6s ease 0.2s forwards;
            opacity: 0;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
            animation: fadeUp 0.6s ease 0.3s forwards;
            opacity: 0;
        }

        /* ===== FEATURES ===== */
        .features {
            padding: 6rem 2rem;
            background: var(--surface-alt);
        }

        .section-inner {
            max-width: 1100px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-label {
            display: inline-block;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: clamp(1.75rem, 4vw, 2.5rem);
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .section-desc {
            color: var(--text-secondary);
            font-size: 1.1rem;
            max-width: 500px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .feature-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.06);
            border-color: rgba(79, 70, 229, 0.2);
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
            font-size: 1.5rem;
        }

        .feature-icon.blue {
            background: #eef2ff;
        }

        .feature-icon.cyan {
            background: #ecfeff;
        }

        .feature-icon.green {
            background: #f0fdf4;
        }

        .feature-icon.amber {
            background: #fffbeb;
        }

        .feature-icon.rose {
            background: #fff1f2;
        }

        .feature-icon.violet {
            background: #f5f3ff;
        }

        .feature-card h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            letter-spacing: -0.01em;
        }

        .feature-card p {
            color: var(--text-secondary);
            font-size: 0.9rem;
            line-height: 1.6;
        }

        /* ===== STATS ===== */
        .stats {
            padding: 5rem 2rem;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            color: white;
        }

        .stats-grid {
            max-width: 900px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 2rem;
            text-align: center;
        }

        .stat-item h3 {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 0.25rem;
        }

        .stat-item p {
            font-size: 0.9rem;
            opacity: 0.85;
            font-weight: 400;
        }

        /* ===== CTA ===== */
        .cta {
            padding: 6rem 2rem;
            text-align: center;
        }

        .cta-card {
            max-width: 700px;
            margin: 0 auto;
            background: linear-gradient(135deg, #1e1b4b, #312e81);
            border-radius: 24px;
            padding: 4rem 3rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .cta-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.3), transparent 70%);
            border-radius: 50%;
        }

        .cta-card h2 {
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 1rem;
            position: relative;
        }

        .cta-card p {
            font-size: 1.05rem;
            opacity: 0.8;
            margin-bottom: 2rem;
            position: relative;
        }

        .cta-actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
            position: relative;
        }

        /* ===== FOOTER ===== */
        .footer {
            padding: 2rem;
            text-align: center;
            border-top: 1px solid var(--border);
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse-dot {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.5;
                transform: scale(0.8);
            }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 640px) {
            .navbar {
                padding: 0.75rem 1rem;
            }

            .hero {
                padding: 6rem 1.25rem 3rem;
            }

            .hero-desc {
                font-size: 1.05rem;
            }

            .features {
                padding: 4rem 1.25rem;
            }

            .stats {
                padding: 3.5rem 1.25rem;
            }

            .cta-card {
                padding: 3rem 1.5rem;
            }

            .nav-actions .btn-ghost {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="navbar-inner">
            <a href="/" class="logo">
                <div class="logo-icon">S</div>
                <span class="logo-text">SIMPKL</span>
            </a>

            <div class="nav-actions">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                    @else
                        <a href="{{ route('auth.loginForm') }}" class="btn btn-ghost">Masuk</a>
                        @if (Route::has('auth.registerForm'))
                            <a href="{{ route('auth.registerForm') }}" class="btn btn-primary">Daftar</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="hero">
        <div class="hero-bg"></div>
        <div class="hero-grid"></div>
        <div class="hero-content">
            <div class="hero-badge">
                <span class="hero-badge-dot"></span>
                Sistem Informasi PKL
            </div>
            <h1>
                Kelola PKL Lebih<br>
                <span class="gradient-text">Mudah & Terstruktur</span>
            </h1>
            <p class="hero-desc">
                SIMPKL membantu sekolah, siswa, dan pembimbing mengelola seluruh kegiatan Praktik Kerja Lapangan dalam
                satu platform digital yang terintegrasi.
            </p>
            <div class="hero-actions">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-lg">Buka Dashboard</a>
                @else
                    <a href="{{ route('auth.loginForm') }}" class="btn btn-primary btn-lg">
                        Masuk Sekarang
                    </a>
                    @if (Route::has('auth.registerForm'))
                        <a href="{{ route('auth.registerForm') }}" class="btn btn-outline btn-lg">Buat Akun</a>
                    @endif
                @endauth
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="section-inner">
            <div class="section-header">
                <span class="section-label">Fitur Lengkap</span>
                <h2 class="section-title">Semua yang Anda Butuhkan</h2>
                <p class="section-desc">Fitur komprehensif untuk mengelola seluruh proses PKL dari awal sampai akhir.
                </p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon blue">📋</div>
                    <h3>Manajemen Penempatan</h3>
                    <p>Kelola penempatan siswa di berbagai instansi mitra dengan mudah dan terorganisir.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon cyan">📖</div>
                    <h3>Logbook Digital</h3>
                    <p>Catat aktivitas harian PKL secara digital. Tidak perlu lagi buku logbook fisik.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon green">✅</div>
                    <h3>Absensi Online</h3>
                    <p>Rekap kehadiran siswa secara real-time dengan sistem absensi yang terintegrasi.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon amber">⭐</div>
                    <h3>Evaluasi & Penilaian</h3>
                    <p>Pembimbing dapat memberikan evaluasi dan penilaian langsung melalui sistem.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon rose">🏢</div>
                    <h3>Data Instansi</h3>
                    <p>Database instansi mitra yang lengkap beserta informasi dan riwayat kerjasama.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon violet">👥</div>
                    <h3>Multi Role</h3>
                    <p>Mendukung berbagai peran: Admin, Guru Pembimbing, dan Siswa dengan akses berbeda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="stats-grid">
            <div class="stat-item">
                <h3>100%</h3>
                <p>Proses Digital</p>
            </div>
            <div class="stat-item">
                <h3>24/7</h3>
                <p>Akses Kapan Saja</p>
            </div>
            <div class="stat-item">
                <h3>3</h3>
                <p>Role Pengguna</p>
            </div>
            <div class="stat-item">
                <h3>∞</h3>
                <p>Data Tersimpan Aman</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="cta-card">
            <h2>Siap Mengelola PKL Secara Digital?</h2>
            <p>Mulai gunakan SIMPKL sekarang dan rasakan kemudahan mengelola praktik kerja lapangan.</p>
            <div class="cta-actions">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-white btn-lg">Buka Dashboard</a>
                @else
                    <a href="{{ route('auth.loginForm') }}" class="btn btn-white btn-lg">Masuk Sekarang</a>
                    @if (Route::has('auth.registerForm'))
                        <a href="{{ route('auth.registerForm') }}" class="btn btn-outline btn-lg"
                            style="color: white; border-color: rgba(255,255,255,0.3);">Daftar Gratis</a>
                    @endif
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; {{ date('Y') }} SIMPKL — Sistem Informasi Manajemen Praktik Kerja Lapangan</p>
    </footer>

    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Intersection Observer for scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.feature-card, .stat-item').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'all 0.5s ease';
            observer.observe(el);
        });
    </script>
</body>

</html>