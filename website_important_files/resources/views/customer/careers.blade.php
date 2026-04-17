@extends('layouts.app')
@section('title', __('Careers'))

@section('style')
<style>   
        /* --- Modern Design Variables --- */
        :root {
            --primary: #2563eb;
            --dark: #0f172a;
            --light-bg: #f8fafc;
            --white: #ffffff;
            --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            --radius: 16px;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Poppins', sans-serif;
        }

        .main-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* --- 1. Split Hero Section --- */
        .hero-split {
            display: flex;
            align-items: center;
            gap: 4rem;
            padding: 4rem 0;
            min-height: 80vh;
        }

        .hero-text {
            flex: 1;
        }

        .hero-text h1 {
            font-size: 3.5rem;
            line-height: 1.1;
            color: var(--dark);
            margin-bottom: 1.5rem;
        }

        .hero-text span {
            color: var(--primary);
        }

        .hero-text p {
            font-size: 1.1rem;
            color: #64748b;
            margin-bottom: 2rem;
            line-height: 1.8;
        }

        .hero-img {
            flex: 1;
            position: relative;
        }

        .hero-img img {
            width: 100%;
            border-radius: var(--radius);
            box-shadow: 20px 20px 0px var(--primary); /* distinct offset shadow */
        }

        .cta-button {
            background-color: var(--dark);
            color: var(--white);
            padding: 15px 35px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .cta-button:hover {
            background-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
        }

        /* --- 2. Stats Strip --- */
        .stats-strip {
            background: var(--white);
            padding: 2rem;
            border-radius: var(--radius);
            display: flex;
            justify-content: space-around;
            box-shadow: var(--card-shadow);
            margin-bottom: 5rem;
            flex-wrap: wrap;
            gap: 20px;
        }

        .stat-item { text-align: center; }
        .stat-num { display: block; font-size: 2.5rem; font-weight: 700; color: var(--primary); }
        .stat-label { color: #64748b; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; }

        /* --- 3. Life at Matgar (Grid) --- */
        .culture-section { margin-bottom: 5rem; }
        .section-heading { text-align: center; margin-bottom: 3rem; }
        .section-heading h2 { font-size: 2.5rem; color: var(--dark); }

        .photo-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            height: 400px;
        }

        .photo-item {
            overflow: hidden;
            border-radius: 12px;
            position: relative;
        }

        /* Making a masonry style layout */
        .photo-item:nth-child(1) { grid-column: span 2; grid-row: span 2; }
        .photo-item:nth-child(2) { grid-column: span 1; grid-row: span 1; }
        .photo-item:nth-child(3) { grid-column: span 1; grid-row: span 2; }

        .photo-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .photo-item:hover img { transform: scale(1.1); }

        /* --- 4. Job Cards (Tile Layout) --- */
        .jobs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
            margin-bottom: 5rem;
        }

        .job-card {
            background: var(--white);
            padding: 2.5rem;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .job-card:hover {
            border-color: var(--primary);
            transform: translateY(-5px);
        }

        .job-tag {
            background: #eff6ff;
            color: var(--primary);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            width: fit-content;
            margin-bottom: 1rem;
        }

        .job-title { font-size: 1.4rem; color: var(--dark); margin-bottom: 0.5rem; }
        .job-location { color: #64748b; font-size: 0.9rem; margin-bottom: 1.5rem; display: block; }

        .apply-link {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .apply-link:hover { gap: 12px; } /* Arrow movement effect */

        /* Responsive */
        @media (max-width: 900px) {
            .hero-split { flex-direction: column-reverse; padding: 2rem 0; text-align: center; }
            .hero-img { width: 100%; }
            .photo-grid { grid-template-columns: repeat(2, 1fr); height: auto; }
            .photo-item:nth-child(1) { grid-column: span 2; }
            .hero-text h1 { font-size: 2.5rem; }
        }
</style>
@endsection

@section('content')
    <main class="main-wrapper">

        <section class="hero-split">
            <div class="hero-text">
                <h1>Do your best work at <span>Matgar.</span></h1>
                <p>We are building the future of e-commerce in Egypt. Join a team that values innovation, creativity, and speed. We don't just sell products; we deliver happiness.</p>
                <a href="#jobs" class="cta-button">See Open Positions</a>
            </div>
            <div class="hero-img">
                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Matgar Team">
            </div>
        </section>

        <section class="stats-strip">
            <div class="stat-item">
                <span class="stat-num">50+</span>
                <span class="stat-label">Team Members</span>
            </div>
            <div class="stat-item">
                <span class="stat-num">1M+</span>
                <span class="stat-label">Happy Customers</span>
            </div>
            <div class="stat-item">
                <span class="stat-num">24/7</span>
                <span class="stat-label">Support</span>
            </div>
            <div class="stat-item">
                <span class="stat-num">EG</span>
                <span class="stat-label">Based in Cairo</span>
            </div>
        </section>

        <section class="culture-section">
            <div class="section-heading">
                <h2>Life at Matgar</h2>
            </div>
            <div class="photo-grid">
                <div class="photo-item"><img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?auto=format&fit=crop&w=600&q=80" alt="Meeting"></div>
                <div class="photo-item"><img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=600&q=80" alt="Office"></div>
                <div class="photo-item"><img src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=600&q=80" alt="Workshop"></div>
                <div class="photo-item"><img src="https://images.unsplash.com/photo-1531545514256-b1400bc00f31?auto=format&fit=crop&w=600&q=80" alt="Laughing"></div>
            </div>
        </section>

        <section id="jobs">
            <div class="section-heading">
                <h2>Current Openings</h2>
            </div>

            <div class="jobs-grid">

                <div class="job-card">
                    <div>
                        <span class="job-tag">Development</span>
                        <h3 class="job-title">Senior React Developer</h3>
                        <span class="job-location"><i class="fa-solid fa-location-dot"></i> Cairo / Remote</span>
                    </div>
                    <a href="#" class="apply-link">Apply Now <i class="fa-solid fa-arrow-right"></i></a>
                </div>

                <div class="job-card">
                    <div>
                        <span class="job-tag">Marketing</span>
                        <h3 class="job-title">Social Media Manager</h3>
                        <span class="job-location"><i class="fa-solid fa-location-dot"></i> Cairo (Maadi)</span>
                    </div>
                    <a href="#" class="apply-link">Apply Now <i class="fa-solid fa-arrow-right"></i></a>
                </div>

                <div class="job-card">
                    <div>
                        <span class="job-tag">Design</span>
                        <h3 class="job-title">UI/UX Designer</h3>
                        <span class="job-location"><i class="fa-solid fa-location-dot"></i> Alexandria / Remote</span>
                    </div>
                    <a href="#" class="apply-link">Apply Now <i class="fa-solid fa-arrow-right"></i></a>
                </div>

                <div class="job-card">
                    <div>
                        <span class="job-tag">Operations</span>
                        <h3 class="job-title">Logistics Manager</h3>
                        <span class="job-location"><i class="fa-solid fa-location-dot"></i> Giza</span>
                    </div>
                    <a href="#" class="apply-link">Apply Now <i class="fa-solid fa-arrow-right"></i></a>
                </div>

            </div>
        </section>

    </main>
@endsection
