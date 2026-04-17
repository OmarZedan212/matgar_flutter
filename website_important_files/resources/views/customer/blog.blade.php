@extends('layouts.app')
@section('title', __('Blog'))

@section('style')
<style>
    /* --- Variables & Reset --- */
    :root {
        --primary-blue: #3b82f6;
        /* Logo & Badge Color */
        --top-bar-bg: #1e1e27;
        /* Dark Top Bar */
        --footer-bg: #151515;
        /* Dark Footer */
        --text-gray: #b3b3b3;
        --light-bg: #f8f9fa;
        --promo-blue: #87ceeb;
        /* Light blue banner */
        --white: #ffffff;
        --font-main: 'Poppins', sans-serif;
        --primary-blue: #3b82f6;
        --footer-bg: #151515;
        /* Dark Black/Grey */
        --text-gray: #b3b3b3;
        /* Light Grey Text */
        --card-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    .tag {
        background: var(--primary-blue);
        padding: 5px 15px;
        border-radius: 20px;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1px;
    }

    .btn {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 25px;
        background: white;
        color: var(--primary-blue);
        font-weight: bold;
        transition: 0.3s;
    }

    .btn:hover {
        background: var(--primary-blue);
        color: white;
    }
    
    .filter-container {
        text-align: center;
        margin: 2.5rem;
    }

    .filter-btn {
        border: none;
        background: white;
        padding: 10px 20px;
        margin: 0 5px;
        cursor: pointer;
        font-size: 1rem;
        border-radius: 25px;
        border: 1px solid #ddd;
        transition: all 0.3s ease;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background: var(--primary-blue);
        color: white;
        border-color: var(--primary-blue);
    }

    /* --- Blog Grid --- */
    .blog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .blog-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: var(--card-shadow);
        transition: transform 0.3s ease;
    }

    .blog-card:hover {
        transform: translateY(-5px);
    }

    .card-image img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .card-content {
        padding: 1.5rem;
    }

    .card-date {
        color: #888;
        font-size: 0.9rem;
    }

    .card-content h3 {
        margin: 10px 0;
        color: var(--primary-blue);
    }

    .card-content p {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 15px;
    }

    .read-more {
        color: var(--primary-blue);
        font-weight: bold;
        font-size: 0.9rem;
    }

    .read-more:hover {
        text-decoration: underline;
    }

    /* --- Responsive --- */
    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 2rem;
        }

        .nav-links {
            display: none;
        }

        /* Simplified mobile view */
    }
</style>
@endsection

@section('content')
    <main class="container">

        <div class="filter-container">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="trends">Trends</button>
            <button class="filter-btn" data-filter="guides">Guides</button>
            <button class="filter-btn" data-filter="news">Company News</button>
        </div>

        <div class="blog-grid" id="blog-grid">

            <article class="blog-card" data-category="trends">
                <div class="card-image">
                    <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Fashion">
                </div>
                <div class="card-content">
                    <span class="card-date">Nov 28, 2025</span>
                    <h3>Top 5 Streetwear Looks</h3>
                    <p>Streetwear is evolving. Here are the top 5 looks dominating the city streets this month.</p>
                    <a href="#" class="read-more">Read More →</a>
                </div>
            </article>

            <article class="blog-card" data-category="guides">
                <div class="card-image">
                    <img src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Gift Guide">
                </div>
                <div class="card-content">
                    <span class="card-date">Nov 25, 2025</span>
                    <h3>Holiday Gift Guide</h3>
                    <p>Struggling to find the perfect gift? We've curated a list for every budget.</p>
                    <a href="#" class="read-more">Read More →</a>
                </div>
            </article>

            <article class="blog-card" data-category="news">
                <div class="card-image">
                    <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Sustainable">
                </div>
                <div class="card-content">
                    <span class="card-date">Nov 20, 2025</span>
                    <h3>Going 100% Sustainable</h3>
                    <p>We are proud to announce our shift to 100% recycled packaging starting next year.</p>
                    <a href="#" class="read-more">Read More →</a>
                </div>
            </article>

            <article class="blog-card" data-category="trends">
                <div class="card-image">
                    <img src="https://images.unsplash.com/photo-1529139574466-a302d2d3f524?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Minimalism">
                </div>
                <div class="card-content">
                    <span class="card-date">Nov 15, 2025</span>
                    <h3>The Return of Minimalism</h3>
                    <p>Why less is more when it comes to building a capsule wardrobe.</p>
                    <a href="#" class="read-more">Read More →</a>
                </div>
            </article>

        </div>
    </main>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        
        // Select all filter buttons and blog cards
        const filterButtons = document.querySelectorAll('.filter-btn');
        const blogCards = document.querySelectorAll('.blog-card');

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                
                // 1. Remove 'active' class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                // 2. Add 'active' class to clicked button
                button.classList.add('active');

                const filterValue = button.getAttribute('data-filter');

                // 3. Loop through cards and show/hide based on category
                blogCards.forEach(card => {
                    const cardCategory = card.getAttribute('data-category');

                    if (filterValue === 'all' || filterValue === cardCategory) {
                        card.style.display = 'block';
                        // Optional: Add a fade-in animation
                        card.style.animation = 'fadeIn 0.5s ease';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    });

    // Add a simple keyframe for the fade animation in JS (or add to CSS)
    const styleSheet = document.createElement("style");
    styleSheet.innerText = `
    @keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
    }`;
    document.head.appendChild(styleSheet);
</script>
@endsection