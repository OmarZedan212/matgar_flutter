@extends('layouts.app')
@section('title', __('About'))

@section('style')
<style>     
    /* --- Re-using variables from Blog page --- */
    :root {
        --primary-color: #2c3e50;
        --accent-color: #e67e22;
        --bg-color: #f9f9f9;
    }

    /* --- About Hero --- */
    .about-hero {
        background-color: var(--primary-color);
        color: white;
        text-align: center;
        padding: 4rem 1rem;
    }

    .about-hero h1 { font-size: 2.5rem; margin-bottom: 10px; }
    .about-hero p { font-size: 1.1rem; opacity: 0.8; }

    /* --- Story Section (Split Layout) --- */
    .story-section {
        display: flex;
        align-items: center;
        gap: 3rem;
        padding: 4rem 1rem;
    }

    .story-image { flex: 1; }
    .story-image img {
        width: 100%;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .story-content { flex: 1; }
    .story-content h2 { font-size: 2rem; color: var(--primary-color); margin-bottom: 1.5rem; }
    .story-content p { color: #555; line-height: 1.6; margin-bottom: 1rem; }

    .features-grid {
        display: flex;
        gap: 20px;
        margin-top: 20px;
    }

    .feature {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: bold;
        color: var(--primary-color);
    }
    .feature i { color: var(--accent-color); }

    /* --- Stats Section --- */
    .stats-section {
        background: white;
        padding: 3rem 1rem;
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .stat-box { margin: 15px; min-width: 150px; }
    .stat-box h3 { font-size: 2.5rem; color: var(--accent-color); margin-bottom: 5px; }
    .stat-box p { color: #666; font-weight: 500; }

    /* --- Team Section --- */
    .team-section { padding: 4rem 1rem; text-align: center; }
    .section-title h2 { font-size: 2rem; color: var(--primary-color); margin-bottom: 0.5rem; }
    .section-title p { color: #777; margin-bottom: 3rem; }

    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
    }

    .team-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s;
    }

    .team-card:hover { transform: translateY(-10px); }

    .team-img { position: relative; overflow: hidden; }
    .team-img img { width: 100%; display: block; }

    /* Social Overlay on Hover */
    .social-overlay {
        position: absolute;
        bottom: -50px; /* Hidden initially */
        left: 0;
        width: 100%;
        background: rgba(44, 62, 80, 0.9);
        display: flex;
        justify-content: center;
        gap: 15px;
        padding: 10px;
        transition: bottom 0.3s ease;
    }

    .team-card:hover .social-overlay { bottom: 0; }
    .social-overlay i { color: white; cursor: pointer; transition: 0.2s; }
    .social-overlay i:hover { color: var(--accent-color); }

    .team-card h3 { margin: 15px 0 5px; color: var(--primary-color); }
    .team-card span { display: block; color: #888; font-size: 0.9rem; margin-bottom: 15px; }

    /* Responsive */
    @media (max-width: 768px) {
        .story-section { flex-direction: column; }
        .stats-section { flex-direction: column; }
    }
     /* --- Page Specific Styles --- */
        :root {
            --primary-color: #2563eb; /* Adjust to match Matgar Blue */
            --text-dark: #1f2937;
            --bg-light: #f9fafb;
            --white: #ffffff;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --promo-blue: #87ceeb;   /* Light blue banner */
        }

        /* Banner Section */
        .about-banner {
            background: linear-gradient(var(--primary-color), var(--promo-blue)), url('https://via.placeholder.com/1200x400/2563eb/ffffff?text=Matgar+Headquarters');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 5rem 1rem;
            text-align: center;
            margin-bottom: 3rem;
        }
        .about-banner h1 { font-size: 3rem; margin-bottom: 1rem; }
        .about-banner p { font-size: 1.25rem; opacity: 0.9; }

        /* Content Layout */
        .page-content {
            padding: 0 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Section Titles */
        .section-title {
            text-align: center;
            margin: 4rem 0 2rem 0;
        }
        .section-title h2 { font-size: 2.25rem; margin-bottom: 0.5rem; color: var(--text-dark); }
        .underline {
            width: 80px; height: 4px; background: var(--primary-color); margin: 0 auto; border-radius: 2px;
        }

        /* Story Section */
        .story-content {
            display: flex;
            gap: 2rem;
            align-items: center;
            background: var(--white);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }
        .story-text { flex: 1; line-height: 1.8; color: #4b5563; }
        .story-image { flex: 1; }
        .story-image img { width: 100%; border-radius: 8px; }

        /* Mission Cards */
        .mission-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }
        .mission-card {
            background: var(--white);
            padding: 2rem;
            border-radius: 8px;
            text-align: center;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease;
            border: 1px solid #eee;
        }
        .mission-card:hover { transform: translateY(-5px); border-color: var(--primary-color); }
        .mission-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        /* Team Section */
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-bottom: 5rem;
        }
        .team-member {
            background: var(--white);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--shadow);
            text-align: center;
            opacity: 0; /* For animation */
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .team-member.visible { opacity: 1; transform: translateY(0); }
        .member-img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            background-color: #eee;
        }
        .member-info { padding: 1.5rem; }
        .member-info h3 { color: var(--text-dark); margin-bottom: 0.25rem; font-size: 1.2rem; }
        .member-info span { color: var(--primary-color); font-weight: 500; font-size: 0.9rem; }

        /* Mobile Fix */
        @media (max-width: 768px) {
            .story-content { flex-direction: column; }
            .about-banner h1 { font-size: 2rem; }
        }
</style>
@endsection

@section('content')
    <div class="about-banner">
        <h1>We Are Matgar</h1>
        <p>Bridging the gap between quality and affordability in Egypt.</p>
    </div>

    <main class="container page-content">
        
        <section class="story-content">
            <div class="story-image">
                <img src="https://via.placeholder.com/600x400/eee/999?text=Matgar+Office" alt="Our Office">
            </div>
            <div class="story-text">
                <h2>Our Story</h2>
                <br>
                <p>Founded in 2025, <strong>Matgar</strong> started with a simple mission: to provide a seamless shopping experience for everyone. We noticed that finding high-quality products at reasonable prices was often difficult.</p>
                <br>
                <p>Today, Matgar has grown into a trusted platform serving thousands of customers. We are committed to authentic products, fast delivery across the country, and putting our customers first.</p>
            </div>
        </section>

        <div class="section-title">
            <h2>Why Shop With Us?</h2>
            <div class="underline"></div>
        </div>

        <section class="mission-grid">
            <div class="mission-card">
                <i class="fa-solid fa-truck-fast mission-icon"></i>
                <h3>Fast Delivery</h3>
                <p>We deliver to all governorates in Egypt within 2-4 working days.</p>
            </div>
            <div class="mission-card">
                <i class="fa-solid fa-shield-halved mission-icon"></i>
                <h3>Secure Payment</h3>
                <p>Your transactions are protected by industry-standard encryption.</p>
            </div>
            <div class="mission-card">
                <i class="fa-solid fa-headset mission-icon"></i>
                <h3>24/7 Support</h3>
                <p>Our support team is available via phone and email around the clock.</p>
            </div>
        </section>
    </main>
@endsection

    <script>
        // Intersection Observer to fade in team members
        const observerOptions = { root: null, threshold: 0.1 };
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.team-member').forEach(member => {
            observer.observe(member);
        });
    </script>
    <div id="toast-notification" class="toast-notification"></div>
@section('script')
<script>
        // Number Counting Animation
    const counters = document.querySelectorAll('.counter');

    counters.forEach(counter => {
        counter.innerText = '0';

        const updateCounter = () => {
            // Get the target number from data-target attribute
            // The '+' symbol converts string to number
            const target = +counter.getAttribute('data-target');
            const c = +counter.innerText;

            // Determine increment step (higher divider = slower)
            const increment = target / 200; 

            if (c < target) {
                counter.innerText = `${Math.ceil(c + increment)}`;
                setTimeout(updateCounter, 10); // Run every 10ms
            } else {
                // Ensure it ends exactly on the target number
                counter.innerText = target;
                // Add 'k' or '+' formatting if needed (Optional)
                if(target > 1000) counter.innerText += '+'; 
            }
        };

        updateCounter();
    });
</script>
@endsection