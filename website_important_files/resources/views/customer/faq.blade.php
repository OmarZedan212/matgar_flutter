@extends('layouts.app')
@section('title', __('FAQ'))

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

        .faq-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 3rem 20px;
            min-height: 60vh;
        }

        /* --- Header Section --- */
        .faq-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .faq-header h1 {
            font-size: 2.5rem;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .faq-header p {
            color: #6b7280;
            margin-bottom: 2rem;
        }

        /* --- Search Bar --- */
        .faq-search {
            position: relative;
            max-width: 500px;
            margin: 0 auto;
        }

        .faq-search input {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border: 2px solid var(--border);
            border-radius: 50px;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s;
        }

        .faq-search input:focus {
            border-color: var(--primary);
        }

        .faq-search i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        /* --- Accordion Style --- */
        .accordion {
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .accordion-item {
            border-bottom: 1px solid var(--border);
        }

        .accordion-item:last-child {
            border-bottom: none;
        }

        .accordion-btn {
            width: 100%;
            background: none;
            border: none;
            padding: 20px 25px;
            text-align: left;
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--dark);
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background 0.3s;
        }

        .accordion-btn:hover {
            background-color: #f3f4f6;
        }

        .accordion-btn.active {
            color: var(--primary);
            background-color: #f8fafc;
        }

        .accordion-btn i {
            transition: transform 0.3s ease;
            color: #9ca3af;
        }

        .accordion-btn.active i {
            transform: rotate(180deg);
            color: var(--primary);
        }

        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
            background-color: var(--white);
        }

        .accordion-body {
            padding: 0 25px 25px 25px;
            color: #4b5563;
            line-height: 1.6;
        }

        /* Section Label */
        .faq-category {
            margin-top: 3rem;
            margin-bottom: 1rem;
            color: var(--primary);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
        }

</style>
@endsection

@section('content')
    
    <main class="faq-container">

        <div class="faq-header">
            <h1>How can we help you?</h1>
            <p>Search our help center or browse frequently asked questions below.</p>

            <div class="faq-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="faqSearchInput" placeholder="Type keywords to find answers...">
            </div>
        </div>

        <div class="faq-category">Orders & Shipping</div>

        <div class="accordion">

            <div class="accordion-item">
                <button class="accordion-btn">
                    How long does delivery take?
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="accordion-content">
                    <div class="accordion-body">
                        Delivery times vary depending on your location. Generally, orders in Cairo and Giza arrive within <strong>24-48 hours</strong>. For other governorates, it typically takes <strong>3-5 business days</strong>.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-btn">
                    How can I track my order?
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="accordion-content">
                    <div class="accordion-body">
                        You can track your order by clicking on the "Track Order" link in the top menu and entering your Order ID and phone number.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-btn">
                    What are the shipping costs?
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="accordion-content">
                    <div class="accordion-body">
                        Shipping is free for orders over 1000 EGP. For orders below that amount, a flat rate of 50 EGP applies to Cairo/Giza and 70 EGP for other regions.
                    </div>
                </div>
            </div>

        </div>

        <div class="faq-category">Returns & Refunds</div>

        <div class="accordion">

            <div class="accordion-item">
                <button class="accordion-btn">
                    What is your return policy?
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="accordion-content">
                    <div class="accordion-body">
                        We offer a 14-day return policy for most items, provided they are unused, in original packaging, and include all tags. Defective items can be returned within 30 days.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-btn">
                    How do I get my refund?
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="accordion-content">
                    <div class="accordion-body">
                        Refunds are processed to your original payment method. If you paid via Cash on Delivery, we will transfer the amount to your Mobile Wallet (Vodafone Cash / Etisalat Cash) or bank account.
                    </div>
                </div>
            </div>

        </div>

        <div class="faq-category">Payment & Account</div>

        <div class="accordion">

            <div class="accordion-item">
                <button class="accordion-btn">
                    Is my credit card information safe?
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="accordion-content">
                    <div class="accordion-body">
                        Yes, absolutely. We use SSL encryption and do not store your credit card details on our servers. All payments are handled by certified third-party processors.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-btn">
                    I forgot my password, what do I do?
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="accordion-content">
                    <div class="accordion-body">
                        Go to the Login page and click "Forgot Password". Enter your email address, and we will send you a link to reset it securely.
                    </div>
                </div>
            </div>

        </div>

    </main>
@endsection

@section('script')
<script>
     const accordions = document.querySelectorAll('.accordion-btn');

        accordions.forEach(acc => {
            acc.addEventListener('click', function() {
                // 1. Toggle the active class on the button
                this.classList.toggle('active');

                // 2. Select the panel (the div immediately following the button)
                const panel = this.nextElementSibling;

                // 3. Toggle height
                if (panel.style.maxHeight) {
                    // If it is open, close it
                    panel.style.maxHeight = null;
                } else {
                    // If it is closed, open it to its scrollHeight
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            });
        });

        // Optional: Simple Search Filter Script
        const searchInput = document.getElementById('faqSearchInput');
        const faqItems = document.querySelectorAll('.accordion-item');

        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase();

            faqItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                if(text.includes(filter)) {
                    item.style.display = "";
                } else {
                    item.style.display = "none";
                }
            });
        });
</script>
@endsection