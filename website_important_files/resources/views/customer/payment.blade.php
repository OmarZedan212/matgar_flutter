@extends('layouts.app')
@section('title', __('about'))

@section('style')
<style>   
    :root {
                --primary-color: #2563eb;
                --text-dark: #1f2937;
                --bg-light: #f9fafb;
                --white: #ffffff;
                --border-color: #e5e7eb;
                --success-color: #10b981;
            }

            body {
                background-color: var(--bg-light);
            }

            .payment-container {
                max-width: 1000px;
                margin: 3rem auto;
                padding: 0 20px;
            }

            /* Hero Section */
            .payment-hero {
                text-align: center;
                background: var(--white);
                padding: 3rem 2rem;
                border-radius: 12px;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                margin-bottom: 2rem;
            }

            .payment-hero i {
                font-size: 4rem;
                color: var(--success-color);
                margin-bottom: 1rem;
            }

            .payment-hero h1 {
                font-size: 2.2rem;
                color: var(--text-dark);
                margin-bottom: 1rem;
            }

            .payment-hero p {
                color: #4b5563;
                max-width: 600px;
                margin: 0 auto;
            }

            /* Payment Methods Row */
            .methods-row {
                display: flex;
                justify-content: center;
                gap: 2rem;
                margin-top: 2rem;
                flex-wrap: wrap;
            }

            .method-icon {
                font-size: 3rem;
                color: #555;
                transition: transform 0.3s;
            }

            .method-icon:hover { transform: scale(1.1); color: var(--primary-color); }

            /* Security Features Grid */
            .security-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 2rem;
                margin-bottom: 3rem;
            }

            .security-card {
                background: var(--white);
                padding: 2rem;
                border-radius: 12px;
                border: 1px solid var(--border-color);
                display: flex;
                align-items: flex-start;
                gap: 1rem;
            }

            .security-card i {
                font-size: 2rem;
                color: var(--primary-color);
                padding: 10px;
                background: #eff6ff;
                border-radius: 8px;
            }

            .card-text h3 {
                font-size: 1.2rem;
                margin-bottom: 0.5rem;
                color: var(--text-dark);
            }

            .card-text p {
                font-size: 0.95rem;
                color: #6b7280;
                line-height: 1.6;
            }

            /* FAQ Section */
            .payment-faq {
                background: var(--white);
                padding: 2rem;
                border-radius: 12px;
                border-top: 4px solid var(--primary-color);
            }
            .payment-faq h2 { margin-bottom: 1.5rem; color: var(--text-dark); }
            .faq-item { margin-bottom: 1.5rem; }
            .faq-item h4 { color: var(--text-dark); margin-bottom: 0.5rem; font-weight: 600; }
            .faq-item p { color: #4b5563; font-size: 0.95rem; }

            @media (max-width: 600px) {
                .payment-hero h1 { font-size: 1.8rem; }
                .methods-row { gap: 1.5rem; }
            }
</style>
@endsection

@section('content')
    <main class="payment-container">

        <section class="payment-hero">
            <i class="fa-solid fa-lock"></i>
            <h1>100% Secure Payment</h1>
            <p>At Matgar, your security is our top priority. We use industry-standard encryption to ensure your data is safe.</p>

            <div class="methods-row">
                <i class="fa-brands fa-cc-visa method-icon" style="color: #1a1f71;" title="Visa"></i>
                <i class="fa-brands fa-cc-mastercard method-icon" style="color: #eb001b;" title="Mastercard"></i>
                <i class="fa-solid fa-money-bill-wave method-icon" style="color: #10b981;" title="Cash on Delivery"></i>
                <i class="fa-solid fa-wallet method-icon" style="color: #2563eb;" title="Mobile Wallets"></i>
            </div>
        </section>

        <section class="security-grid">
            <div class="security-card">
                <i class="fa-solid fa-shield-halved"></i>
                <div class="card-text">
                    <h3>SSL Encryption</h3>
                    <p>Our entire website is secured with 256-bit SSL encryption, meaning your data is scrambled and cannot be intercepted by hackers.</p>
                </div>
            </div>

            <div class="security-card">
                <i class="fa-solid fa-user-secret"></i>
                <div class="card-text">
                    <h3>Data Privacy</h3>
                    <p>We do not store your credit card information on our servers. All payments are processed through secure, certified gateways.</p>
                </div>
            </div>

            <div class="security-card">
                <i class="fa-solid fa-check-double"></i>
                <div class="card-text">
                    <h3>Verified Sellers</h3>
                    <p>Every seller on Matgar goes through a verification process to ensure you receive authentic products.</p>
                </div>
            </div>
        </section>

        <section class="payment-faq">
            <h2>Payment FAQ</h2>

            <div class="faq-item">
                <h4>What payment methods do you accept?</h4>
                <p>We accept Visa, Mastercard, Mobile Wallets (Vodafone Cash, Etisalat Cash), and Cash on Delivery (COD) for most items.</p>
            </div>

            <div class="faq-item">
                <h4>Is it safe to use my credit card?</h4>
                <p>Yes. We use third-party payment processors that are PCI-DSS compliant. Matgar never sees or stores your full card number.</p>
            </div>

            <div class="faq-item">
                <h4>Can I pay when I receive the product?</h4>
                <p>Yes! We offer "Cash on Delivery" as a payment option during checkout. You can pay the courier in cash when your order arrives.</p>
            </div>
        </section>

    </main>
@endsection
