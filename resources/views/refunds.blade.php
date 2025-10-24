@extends('layout.main')

@section('content')
<section id="refund-policy-page" class="py-5" style="min-height: 80vh;">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                
                <header class="text-center mb-5" data-aos="fade-down">
                    <h1 class="display-4 fw-bold" style="color: var(--primary-color);">Refund Policy</h1>
                    <p class="lead text-muted">
                        Detailed information on when and how your refund will be processed.
                    </p>
                </header>
                
                <div class="policy-content">

                    <div class="policy-section mb-5" data-aos="fade-up">
                        <h2 class="fw-bold text-primary mb-3 pb-2 border-bottom"> Refund Policy</h2>
                        
                        <h4 class="fw-semibold">Refunds are processed in the following cases:</h4>
                        <ul class="list-unstyled text-secondary ps-3">
                            <li class="mb-2"><i class="fa-solid fa-file-invoice text-success me-2"></i>Order cancelled before dispatch.</li>
                            <li class="mb-2"><i class="fa-solid fa-box-open text-success me-2"></i>Product returned as per policy (damaged, wrong, or defective item).</li>
                            <li class="mb-2"><i class="fa-solid fa-truck-fast text-success me-2"></i>Failed delivery (e.g., customer unavailable, wrong address).</li>
                        </ul>

                        <h4 class="fw-semibold mt-4">Mode & Timeline</h4>
                        <p class="text-secondary"><strong>Prepaid Orders (Card, Net Banking, UPI):</strong> Refunds will be credited to the original payment method within **2–5 business days** after product verification.</p>
                        <p class="text-secondary"><strong>Cash on Delivery Orders:</strong> Refunds will be made via **bank transfer** within **2–5 business days** after you share your bank details with us.</p>
                        <p class="text-secondary small mt-3">
                            <i class="fa-solid fa-clock text-warning me-2"></i>**Please note:** It may take an additional 2–3 business days for the refunded amount to reflect in your account depending on your bank or payment provider.
                        </p>
                    </div>
                    
                    <div class="policy-section mb-5" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="fw-bold text-success mb-3 pb-2 border-bottom">Contact Us</h2>
                        <p class="text-secondary">
                            If you have any questions or concerns about refunds, please reach out to us at:
                        </p>
                        <ul class="list-unstyled text-secondary ps-3">
                            <li class="mb-2"><i class="fa-solid fa-envelope me-2"></i><strong>Email:</strong> <a href="mailto:info@naturolia.in">info@naturolia.in</a></li>
                            <li class="mb-2"><i class="fa-solid fa-phone me-2"></i><strong>Customer Care:</strong> +91-97804-11123</li>
                            <li class="mb-2"><i class="fa-solid fa-clock me-2"></i><strong>Timings:</strong> Monday – Saturday, 10 AM to 7 PM</li>
                        </ul>
                        <p class="text-secondary mt-4 fst-italic">
                            We are committed to ensuring a fair and transparent resolution for all our valued customers. 🌿
                        </p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>
@endsection