@extends('layouts.app')
@section('title', __('Return Policy'))

@section('style')
<style>   
    :root {
            --primary: #2563eb;
            --dark: #1f2937;
            --light-bg: #f9fafb;
            --white: #ffffff;
            --border: #e5e7eb;
        }

        body {
            background-color: var(--light-bg);
        }

        .policy-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 3rem 20px;
        }

        /* --- Header --- */
        .policy-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        .policy-header h1 { font-size: 2.5rem; color: var(--dark); margin-bottom: 0.5rem; }
        .policy-header p { color: #6b7280; font-size: 1.1rem; }

        /* --- Visual Steps Section --- */
        .steps-wrapper {
            background: var(--white);
            padding: 3rem 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            margin-bottom: 3rem;
        }

        .steps-title {
            text-align: center;
            margin-bottom: 2rem;
            font-size: 1.5rem;
            color: var(--dark);
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            text-align: center;
            position: relative;
        }

        /* Connecting line for desktop */
        @media (min-width: 768px) {
            .steps-grid::before {
                content: '';
                position: absolute;
                top: 35px;
                left: 10%;
                right: 10%;
                height: 2px;
                background: #e5e7eb;
                z-index: 0;
            }
        }

        .step-item {
            position: relative;
            z-index: 1;
            background: var(--white); /* To hide line behind icon */
        }

        .step-icon {
            width: 70px;
            height: 70px;
            background: #eff6ff;
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 1rem;
            border: 2px solid var(--white);
            box-shadow: 0 0 0 4px #eff6ff;
        }

        .step-item h4 { margin-bottom: 0.5rem; color: var(--dark); }
        .step-item p { font-size: 0.9rem; color: #6b7280; }

        /* --- Policy Text Content --- */
        .content-card {
            background: var(--white);
            padding: 2.5rem;
            border-radius: 12px;
            border: 1px solid var(--border);
            margin-bottom: 2rem;
        }

        .content-card h3 {
            color: var(--dark);
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
            font-size: 1.4rem;
        }

        .content-card p {
            margin-bottom: 1rem;
            color: #4b5563;
            line-height: 1.7;
        }

        .content-card ul {
            margin-left: 1.5rem;
            margin-bottom: 1.5rem;
            color: #4b5563;
        }

        .content-card li { margin-bottom: 0.5rem; }

        /* --- Non-Returnable Alert --- */
        .alert-box {
            background-color: #fef2f2;
            border-left: 4px solid #ef4444;
            padding: 1.5rem;
            margin-top: 1rem;
        }
        .alert-box h4 { color: #991b1b; margin-bottom: 0.5rem; }
        .alert-box ul { margin-bottom: 0; color: #7f1d1d; }

        /* --- CTA Button --- */
        .btn-return {
            display: block;
            width: fit-content;
            margin: 0 auto;
            background: var(--primary);
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s;
        }
        .btn-return:hover { background: #1e40af; }
</style>
@endsection

@section('content')
     <main class="policy-container">

        <div class="policy-header">
            <h1>Return & Refund Policy</h1>
            <p>Simple, transparent, and hassle-free returns.</p>
        </div>

        <section class="steps-wrapper">
            <h2 class="steps-title">How to Return an Item</h2>
            <div class="steps-grid">
                <div class="step-item">
                    <div class="step-icon"><i class="fa-regular fa-file-lines"></i></div>
                    <h4>1. Request Return</h4>
                    <p>Go to your account or contact support within 14 days.</p>
                </div>
                <div class="step-item">
                    <div class="step-icon"><i class="fa-solid fa-box-open"></i></div>
                    <h4>2. Pack Item</h4>
                    <p>Place item in original packaging with tags attached.</p>
                </div>
                <div class="step-item">
                    <div class="step-icon"><i class="fa-solid fa-truck"></i></div>
                    <h4>3. Courier Pickup</h4>
                    <p>Our courier will pick up the item from your doorstep.</p>
                </div>
                <div class="step-item">
                    <div class="step-icon"><i class="fa-solid fa-rotate-left"></i></div>
                    <h4>4. Get Refund</h4>
                    <p>Refund processed within 5-7 days after inspection.</p>
                </div>
            </div>
        </section>

        <section class="content-card">
            <h3>General Conditions</h3>
            <p>At Matgar, we want you to be completely satisfied with your purchase. In accordance with Egyptian Consumer Protection Law, you have the right to return products within <strong>14 days</strong> of receipt (or 30 days if the product is defective).</p>
            <p>To be eligible for a return, your item must be:</p>
            <ul>
                <li>Unused and in the same condition that you received it.</li>
                <li>In the original packaging with all seals and tags intact.</li>
                <li>Accompanied by the receipt or proof of purchase.</li>
            </ul>

            <div class="alert-box">
                <h4><i class="fa-solid fa-circle-exclamation"></i> Non-Returnable Items</h4>
                <p>For health and safety reasons, we cannot accept returns on:</p>
                <ul>
                    <li>Lingerie, underwear, and swimwear.</li>
                    <li>Personal care items (cosmetics, skincare) if opened.</li>
                    <li>Perishable goods (food, flowers).</li>
                    <li>Customized or personalized products.</li>
                </ul>
            </div>
        </section>

        <section class="content-card">
            <h3>Refunds & Exchanges</h3>
            <p><strong>Refund Methods:</strong></p>
            <ul>
                <li><strong>Credit/Debit Card:</strong> Refunded directly to your card (takes 5-10 business days depending on your bank).</li>
                <li><strong>Cash on Delivery (COD):</strong> Refunded via Vodafone Cash, Etisalat Cash, InstaPay, or Store Credit voucher.</li>
            </ul>
            <p><strong>Shipping Costs:</strong></p>
            <p>If the return is due to our error (wrong item, defective), we cover the shipping. If you simply changed your mind, the return shipping fee (50 EGP) will be deducted from your refund.</p>
        </section>

        <div style="text-align: center; margin-top: 3rem;">
            <p style="margin-bottom: 1rem; color: #6b7280;">Ready to return an item?</p>
            <a href="#" class="btn-return">Initiate a Return Request</a>
        </div>
    </main>
@endsection
