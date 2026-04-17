@extends('layouts.app')
@section('title', __('Track'))

@section('style')
<style>   
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap");
    :root {
    --primary: #4f46e5;
    --secondary: #e0e7ff;
    --text-dark: #1f2937;
    --text-light: #6b7280;
    --bg-color: #f3f4f6;
    }
    .main-container {
    width: 100%;
    max-width: 800px;
    margin: 40px auto;
    padding: 0 20px;
    }

    /* --- Cards --- */
    .search-card,
    .order-status-card {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    margin-bottom: 20px;
    }

    .header-info {
    margin-bottom: 20px;
    }

    /* --- Inputs & Buttons --- */
    .input-group {
    display: flex;
    gap: 10px;
    margin-top: 15px;
    }

    input {
    flex: 1;
    padding: 12px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 16px;
    outline: none;
    transition: 0.3s;
    }
    input:focus {
    border-color: var(--primary);
    }

    button {
    background-color: var(--primary);
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.3s;
    }
    button:hover {
    background-color: #4338ca;
    }

    .copy-btn {
    padding: 5px 10px;
    font-size: 12px;
    background: #f3f4f6;
    color: #333;
    margin-left: 10px;
    border-radius: 4px;
    }
    .copy-btn:hover {
    background: #e5e7eb;
    }

    .error-msg {
    color: #ef4444;
    font-size: 14px;
    margin-top: 10px;
    min-height: 20px;
    }
    hr {
    border: 0;
    border-top: 1px solid #e5e7eb;
    margin: 30px 0;
    }

    /* --- Progress Bar System --- */
    #progressbar {
    margin-top: 40px;
    padding: 0;
    list-style: none;
    counter-reset: step;
    display: flex;
    justify-content: space-between;
    position: relative;
    }

    #progressbar li {
    width: 25%;
    position: relative;
    text-align: center;
    color: var(--text-light);
    font-size: 14px;
    z-index: 10;
    }

    /* Icons */
    #progressbar li i {
    width: 50px;
    height: 50px;
    line-height: 50px;
    display: block;
    margin: 0 auto 10px auto;
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 50%;
    font-size: 18px;
    transition: 0.3s;
    }

    /* Connecting Line */
    #progressbar li::after {
    content: "";
    width: 100%;
    height: 4px;
    background: #e5e7eb;
    position: absolute;
    top: 25px;
    left: -35%;
    z-index: -1;
    }
    #progressbar li:first-child::after {
    content: none;
    }

    /* Active States */
    #progressbar li.active i {
    background: var(--primary);
    border-color: var(--primary);
    color: white;
    }
    #progressbar li.active span {
    color: var(--text-dark);
    font-weight: 600;
    }
    #progressbar li.active + li.active::after {
    background: var(--primary);
    }

    /* Pulse Animation */
    @keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(79, 70, 229, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(79, 70, 229, 0);
    }
    }
    #progressbar li.active:last-of-type i {
    animation: pulse 1.5s infinite;
    }

    /* Vertical History */
    .vertical-timeline {
    margin-top: 20px;
    padding-left: 10px;
    border-left: 2px solid #e5e7eb;
    }
    .timeline-item {
    position: relative;
    margin-bottom: 25px;
    padding-left: 20px;
    }
    .timeline-item::before {
    content: "";
    position: absolute;
    left: -6px;
    top: 5px;
    width: 10px;
    height: 10px;
    background: white;
    border: 2px solid var(--primary);
    border-radius: 50%;
    }
    .timeline-time {
    font-size: 12px;
    color: var(--text-light);
    margin-bottom: 2px;
    }
    .timeline-desc {
    font-weight: 500;
    color: var(--text-dark);
    }
</style>
@endsection

@section('content')
    <div class="main-container">
        <div class="search-card">
            <h2>Track Your Order</h2>
            <p>Enter your order ID to see details (Try: <b>ORD-123</b> or <b>ORD-456</b>)</p>
            <div class="input-group">
                <input type="text" id="orderInput" placeholder="Enter Order ID">
                <button onclick="trackOrder()">Track</button>
            </div>
            <p id="errorMsg" class="error-msg"></p>
        </div>

        <div class="order-status-card" id="statusCard" style="display: none;">
            <div class="header-info">
                <div>
                    <h3>Order <span id="displayOrderId">#</span>
                        <button class="copy-btn" onclick="copyOrderID()" title="Copy Order ID">
                            <i class="fas fa-copy"></i>
                        </button>
                    </h3>
                    <p>Expected Arrival: <span id="displayDate">--/--/----</span></p>
                </div>
            </div>

            <div class="progress-track">
                <ul id="progressbar">
                    <li class="step0" id="step1">
                        <i class="fas fa-box"></i>
                        <span>Order Placed</span>
                    </li>
                    <li class="step0" id="step2">
                        <i class="fas fa-user-check"></i>
                        <span>Confirmed</span>
                    </li>
                    <li class="step0" id="step3">
                        <i class="fas fa-truck"></i>
                        <span>Shipped</span>
                    </li>
                    <li class="step0" id="step4">
                        <i class="fas fa-box-open"></i>
                        <span>Delivered</span>
                    </li>
                </ul>
            </div>

            <hr>

            <div class="history-section">
                <h4>Shipment Activity</h4>
                <div class="vertical-timeline" id="historyLog">
                    </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
        document.addEventListener("DOMContentLoaded", () => {

        const database = {
            '#ORD-7782': {
                stepsCompleted: 4,
                date: 'Nov 22, 2025',
                history: [
                    { time: "Nov 20, 09:00 AM", status: "Order Placed" },
                    { time: "Nov 21, 10:00 AM", status: "Shipped" },
                    { time: "Nov 22, 02:00 PM", status: "Delivered" }
                ]
            },
            '#ORD-7783': {
                stepsCompleted: 2,
                date: 'Nov 25, 2025',
                history: [
                    { time: "Nov 25, 10:30 AM", status: "Order Placed" },
                    { time: "Nov 25, 02:15 PM", status: "Payment Confirmed" }
                ]
            },
            '#ORD-0000': {
                stepsCompleted: 1,
                date: 'Pending',
                history: [
                    { time: "Now", status: "Order placed (Test Mode)" }
                ]
            }
        };

        const params = new URLSearchParams(window.location.search);
        const urlId = params.get('id');

        if (urlId) {
            document.getElementById('orderInput').value = urlId;

            setTimeout(() => {
                trackOrder();
            }, 100);
        }

        window.trackOrder = function() {
            let input = document.getElementById('orderInput').value.trim();
            const statusCard = document.getElementById('statusCard');
            const errorMsg = document.getElementById('errorMsg');
            const historyContainer = document.getElementById('historyLog');

            if (errorMsg) errorMsg.textContent = "";
            if (statusCard) statusCard.style.display = 'none';
            if (historyContainer) historyContainer.innerHTML = "";
            resetSteps();

            if (!input) {
                if (errorMsg) errorMsg.textContent = "Please enter an Order ID.";
                return;
            }

            if (!input.startsWith('#')) input = '#' + input;
            input = input.toUpperCase();

            if (database[input]) {
                const orderData = database[input];
                statusCard.style.display = 'block';

                document.getElementById('displayOrderId').innerText = input;
                document.getElementById('displayDate').innerText = orderData.date;

                updateProgressBar(orderData.stepsCompleted);
                renderHistory(orderData.history);
            } else {
                if (errorMsg) errorMsg.textContent = `Order ${input} not found in database.`;
            }
        };

        function updateProgressBar(stepCount) {
            const steps = document.querySelectorAll('#progressbar li');
            steps.forEach((step, index) => {
                step.classList.remove('active');
                if (index < stepCount) {
                    setTimeout(() => step.classList.add('active'), index * 200);
                }
            });
        }

        function resetSteps() {
            document.querySelectorAll('#progressbar li').forEach(s =>
                s.classList.remove('active')
            );
        }

        function renderHistory(logs) {
            const container = document.getElementById('historyLog');
            logs.forEach(log => {
                container.innerHTML += `
                    <div class="timeline-item">
                        <div class="timeline-time">${log.time}</div>
                        <div class="timeline-desc">${log.status}</div>
                    </div>`;
            });
        }

        window.copyOrderID = function() {
            const orderId = document.getElementById('displayOrderId').innerText;
            navigator.clipboard.writeText(orderId);
            alert("Copied!");
        };
    });
</script>
@endsection