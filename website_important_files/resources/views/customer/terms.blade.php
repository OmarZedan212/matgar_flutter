@extends('layouts.app')
@section('title', __('Terms & Conditions'))

@section('style')
<style>   
     /* --- Reset & Global Variables --- */
        :root {
            --primary-color: #2563eb; /* Blue */
            --primary-hover: #1e40af; /* Darker Blue */
            --text-dark: #1f2937;
            --text-light: #4b5563;
            --bg-light: #f3f4f6;
            --white: #ffffff;
            --border-color: #e5e7eb;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background-color: var(--bg-light);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        /* --- Main Layout --- */

        .content-section {
            background: var(--white);
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: var(--shadow);
            margin: 2rem;
        }

        .content-section h2,
        .content-section h3 {
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            color: var(--text-dark);
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 0.5rem;
        }

        .content-section p {
            margin-bottom: 1rem;
            color: var(--text-light);
        }

        .content-section ul {
            margin-left: 20px;
            margin-bottom: 1.5rem;
            color: var(--text-light);
        }

        .content-section li {
            margin-bottom: 0.5rem;
        }
        p a {
            color: var(--primary-color);
            text-decoration:underline;
        }

        /* --- Responsive Design --- */
        @media (max-width: 600px) {
            .page-header h1 { font-size: 2rem; }
            .content-section { padding: 1.5rem; }
            nav ul { gap: 15px; flex-direction: column; align-items: center; }
        }
</style>
@endsection

@section('content')
     <main class="container">

        <div class="content-section">
            <p><strong>Last Updated:</strong> <span id="current-date">Loading...</span></p>

            <h3>1. Introduction</h3>
            <p>Welcome to <strong>Matger</strong>. By accessing this website, we assume you accept these terms and conditions. Do not continue to use our website if you do not agree to take all of the terms and conditions stated on this page.</p>

            <h3>2. User Accounts</h3>
            <p>When you create an account with us, you must provide us with information that is accurate, complete, and current at all times. Failure to do so constitutes a breach of the Terms.</p>
            <ul>
                <li>You are responsible for maintaining the confidentiality of your password.</li>
                <li>You agree not to disclose your password to any third party.</li>
                <li>You must notify us immediately upon becoming aware of any breach of security.</li>
            </ul>

            <h3>3. Purchases</h3>
            <p>If you wish to purchase any product or service made available through the Service ("Purchase"), you may be asked to supply certain information relevant to your Purchase including, without limitation, your credit card number, the expiration date of your credit card, your billing address, and your shipping information.</p>

            <h3>4. Termination</h3>
            <p>We may terminate or suspend access to our Service immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms.</p>

            <h3>5. Limitation of Liability</h3>
            <p>In no event shall <strong>Matger</strong>, nor its directors, employees, partners, agents, suppliers, or affiliates, be liable for any indirect, incidental, special, consequential or punitive damages.</p>

            <h3>6. Governing Law</h3>
            <p>These Terms shall be governed and construed in accordance with the laws of <strong>Egypt</strong>, without regard to its conflict of law provisions.</p>

            <h3>7. Contact Us</h3>
            <p>If you have any questions about these Terms, please contact us at <a href="mailto:support@matger.com">support@matger.com</a>.</p>
        </div>

    </main>
@endsection

@section('script')
<script>
            // --- 1. Dynamic Date Script ---
        // Automatically sets the "Last Updated" date to today and Footer Year
        document.addEventListener('DOMContentLoaded', () => {
            const dateElement = document.getElementById('current-date');
            const yearElement = document.getElementById('year');
            const today = new Date();

            // Format: Month Day, Year
            const options = { year: 'numeric', month: 'long', day: 'numeric' };

            dateElement.textContent = today.toLocaleDateString('en-US', options);
            yearElement.textContent = today.getFullYear();
        });
</script>
@endsection