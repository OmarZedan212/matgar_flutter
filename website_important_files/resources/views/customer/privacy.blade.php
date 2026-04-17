@extends('layouts.app')
@section('title', __('Privacy'))

@section('style')
<style>   
     /* --- Page Specific Styles --- */
        :root {
            --primary-color: #2563eb;
            --text-dark: #1f2937;
            --text-gray: #4b5563;
            --bg-light: #f9fafb;
            --white: #ffffff;
            --border-color: #e5e7eb;
        }

        body {
            background-color: var(--bg-light);
        }

        /* Page Wrapper */
        .policy-container {
            max-width: 1000px;
            margin: 3rem auto;
            padding: 0 20px;
        }

        /* Header Section */
        .policy-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        .policy-header h1 {
            font-size: 2.5rem;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }
        .policy-header p {
            color: var(--text-gray);
            font-size: 1.1rem;
        }

        /* Content Card */
        .policy-content {
            background: var(--white);
            padding: 3rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border-color);
        }

        /* Typography inside the policy */
        .policy-content h2 {
            font-size: 1.5rem;
            color: var(--text-dark);
            margin-top: 2rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 0.5rem;
        }

        .policy-content h2:first-child { margin-top: 0; }

        .policy-content p {
            color: var(--text-gray);
            line-height: 1.8;
            margin-bottom: 1rem;
        }

        .policy-content ul {
            margin-left: 20px;
            margin-bottom: 1.5rem;
            color: var(--text-gray);
        }

        .policy-content li {
            margin-bottom: 0.5rem;
            padding-left: 0.5rem;
        }

        .policy-content strong {
            color: var(--text-dark);
        }

        /* Contact Box */
        .contact-box {
            background: #f3f4f6;
            padding: 1.5rem;
            border-radius: 8px;
            margin-top: 2rem;
            border-left: 4px solid var(--primary-color);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .policy-content { padding: 1.5rem; }
            .policy-header h1 { font-size: 2rem; }
        }
</style>
@endsection

@section('content')
    <main class="policy-container">

        <div class="policy-header">
            <h1>Privacy Policy</h1>
            <p>Last Updated: November 29, 2025</p>
        </div>

        <div class="policy-content">
            <p>At <strong>Matgar</strong>, accessible from matgar.com, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by Matgar and how we use it.</p>

            <h2>1. Information We Collect</h2>
            <p>We collect information you provide directly to us when you register for an account, make a purchase, or contact customer support.</p>
            <ul>
                <li><strong>Personal Information:</strong> Name, email address, phone number, and billing/shipping address.</li>
                <li><strong>Payment Information:</strong> Credit card details (processed securely via third-party gateways; we do not store your card details).</li>
                <li><strong>Account Credentials:</strong> Password and username.</li>
            </ul>

            <h2>2. How We Use Your Information</h2>
            <p>We use the information we collect in various ways, including to:</p>
            <ul>
                <li>Process and fulfill your orders.</li>
                <li>Provide, operate, and maintain our website.</li>
                <li>Improve, personalize, and expand our website.</li>
                <li>Communicate with you regarding updates, offers, and customer service.</li>
                <li>Prevent fraudulent transactions and monitor against theft.</li>
            </ul>

            <h2>3. Log Files</h2>
            <p>Matgar follows a standard procedure of using log files. These files log visitors when they visit websites. The information collected by log files includes internet protocol (IP) addresses, browser type, Internet Service Provider (ISP), date and time stamp, referring/exit pages, and possibly the number of clicks.</p>

            <h2>4. Cookies and Web Beacons</h2>
            <p>Like any other website, Matgar uses "cookies". These cookies are used to store information including visitors' preferences, and the pages on the website that the visitor accessed or visited. The information is used to optimize the users' experience by customizing our web page content based on visitors' browser type and/or other information.</p>

            <h2>5. Third Party Privacy Policies</h2>
            <p>Matgar's Privacy Policy does not apply to other advertisers or websites. Thus, we are advising you to consult the respective Privacy Policies of these third-party ad servers for more detailed information.</p>

            <h2>6. Data Security</h2>
            <p>We value your trust in providing us your Personal Information, thus we are striving to use commercially acceptable means of protecting it. But remember that no method of transmission over the internet, or method of electronic storage is 100% secure and reliable, and we cannot guarantee its absolute security.</p>

            <h2>7. Children's Information</h2>
            <p>Another part of our priority is adding protection for children while using the internet. We encourage parents and guardians to observe, participate in, and/or monitor and guide their online activity. Matgar does not knowingly collect any Personal Identifiable Information from children under the age of 13.</p>

            <div class="contact-box">
                <h2>Contact Us</h2>
                <p>If you have additional questions or require more information about our Privacy Policy, do not hesitate to contact us.</p>
                <p><i class="fa-regular fa-envelope"></i> <strong>Email:</strong> privacy@matgar.com</p>
                <p><i class="fa-solid fa-phone"></i> <strong>Phone:</strong> +20 123 456 789</p>
            </div>
        </div>

    </main>
@endsection
