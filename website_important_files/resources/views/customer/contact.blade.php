@extends('layouts.app')
@section('title', __('Contact Us'))

@section('style')
<style>   
    :root {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --dark: #1f2937;
            --light-bg: #f9fafb;
            --white: #ffffff;
            --border: #e5e7eb;
            --shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }

        body {
            background-color: var(--light-bg);
        }

        .contact-container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 3rem 20px;
        }

        /* --- Header --- */
        .contact-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        .contact-header h1 { font-size: 2.5rem; color: var(--dark); margin-bottom: 0.5rem; }
        .contact-header p { color: #6b7280; font-size: 1.1rem; }

        /* --- Main Grid Layout --- */
        .contact-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr; /* Form takes more space */
            gap: 2rem;
            margin-bottom: 4rem;
        }

        /* --- Form Section --- */
        .contact-form-card {
            background: var(--white);
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--dark);
            font-weight: 500;
        }

        .form-input, .form-textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            transition: border-color 0.3s;
        }

        .form-input:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
        }

        .btn-submit {
            background: var(--primary);
            color: var(--white);
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s;
            width: 100%;
        }

        .btn-submit:hover {
            background: var(--primary-dark);
        }

        /* --- Info Section --- */
        .contact-info-wrapper {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .info-card {
            background: var(--white);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .info-icon {
            font-size: 1.5rem;
            color: var(--primary);
            background: #eff6ff;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .info-content h4 { font-size: 1.1rem; color: var(--dark); margin-bottom: 0.3rem; }
        .info-content p { color: #6b7280; font-size: 0.9rem; line-height: 1.5; }
        .info-content a { color: var(--primary); text-decoration: none; }

        /* --- Map Section --- */
        .map-section {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
            height: 400px;
            border: 1px solid var(--border);
        }

        .map-section iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .contact-grid { grid-template-columns: 1fr; }
        }
</style>
@endsection

@section('content')
    <main class="contact-container">

            <div class="contact-header">
                <h1>Get In Touch</h1>
                <p>Have a question or feedback? We'd love to hear from you.</p>
            </div>

            <div class="contact-grid">

                <div class="contact-form-card">
                    <form id="contactForm">
                        <div class="form-group">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-input" placeholder="Enter your name" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-input" placeholder="Enter your email" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Subject</label>
                            <select class="form-input">
                                <option>Order Inquiry</option>
                                <option>Return & Refund</option>
                                <option>Technical Issue</option>
                                <option>General Feedback</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Message</label>
                            <textarea class="form-textarea" rows="5" placeholder="How can we help you?" required></textarea>
                        </div>

                        <button type="submit" class="btn-submit">Send Message</button>
                    </form>
                </div>

                <div class="contact-info-wrapper">

                    <div class="info-card">
                        <div class="info-icon"><i class="fa-solid fa-phone"></i></div>
                        <div class="info-content">
                            <h4>Phone Support</h4>
                            <p>Available 9AM - 10PM</p>
                            <a href="tel:+20123456789">+20 123 456 789</a>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-icon"><i class="fa-solid fa-envelope"></i></div>
                        <div class="info-content">
                            <h4>Email Us</h4>
                            <p>We usually reply within 24h</p>
                            <a href="mailto:support@matgar.com">support@matgar.com</a>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-icon"><i class="fa-solid fa-location-dot"></i></div>
                        <div class="info-content">
                            <h4>Head Office</h4>
                            <p>Building 42, 90th Street<br>New Cairo, Cairo, Egypt</p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="map-section">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d55251.3770996497!2d31.223444832568353!3d30.059483810319882!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14583fa60b21beeb%3A0x79df8294e8c238de!2sCairo%2C%20Cairo%20Governorate!5e0!3m2!1sen!2seg!4v1701234567890!5m2!1sen!2seg" allowfullscreen="" loading="lazy"></iframe>
            </div>

        </main>

@endsection

@section('script')
<script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // 1. Get the toast element
        const toast = document.getElementById('toast-notification');

        if (toast) {
            // 2. Set Content & Style (Green Success)
            toast.innerHTML = '<i class="fa-solid fa-check-circle"></i> Message sent successfully!';
            toast.classList.add('success');

            // 3. Show (Slide Up)
            toast.classList.add('show');

            // 4. Hide after 3 seconds
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        } else {
            // Fallback if you forgot Step 1
            alert('Thank you! Your message has been sent successfully.');
        }

        // 5. Clear the form
        this.reset();
    });
</script>
@endsection