@extends('layout.main')

@section('content')
<section id="cancellation-policy-page" class="py-5" style="min-height: 80vh;">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                
                <header class="text-center mb-5" data-aos="fade-down">
                    <h1 class="display-4 fw-bold" style="color: var(--primary-color);">Cancellation Policy</h1>
                    <p class="lead text-muted">
                        At Naturolia, we prioritize smooth and hassle-free cancellations before dispatch.
                    </p>
                </header>
                
                <div class="policy-content">
                    
                    <div class="policy-section mb-5" data-aos="fade-up">
                        <h2 class="fw-bold text-primary mb-3 pb-2 border-bottom">Cancellation Policy</h2>
                        
                        <h4 class="fw-semibold">Before Dispatch</h4>
                        <p class="text-secondary">
                            Orders can be cancelled only if the shipment has **not been dispatched** from our warehouse.
                        </p>
                        <p class="text-secondary">
                            To cancel your order, please email us at 
                            <a href="mailto:info@naturolia.in">info@naturolia.in</a> or contact our customer care at 
                            **+91-97804-11123** (Monday to Saturday, 10 AM to 7 PM).
                        </p>
                        <p class="text-secondary">
                            Once your order is confirmed as eligible for cancellation, we will initiate your refund within <strong>2–5 business days</strong>.
                        </p>
                        
                        <h4 class="fw-semibold mt-4">After Dispatch</h4>
                        <p class="text-secondary">
                            Unfortunately, once the order has been shipped, it **cannot be cancelled**.
                        </p>
                        <p class="text-secondary">
                            If you refuse to accept the parcel at the time of delivery, the order will be marked as “Return to Origin” and refund will be processed after we receive the product back.
                        </p>
                        
                        <h4 class="fw-semibold mt-4">Fraudulent or Invalid Transactions</h4>
                        <p class="text-secondary">
                            Naturolia reserves the right to cancel any order if it is found to be fraudulent or in violation of our Terms & Conditions.
                        </p>
                    </div>

                    <div class="policy-section mb-5" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="fw-bold text-success mb-3 pb-2 border-bottom">Contact Us</h2>
                        <p class="text-secondary">
                            If you have any questions or concerns about cancellations, please reach out to us at:
                        </p>
                        <ul class="list-unstyled text-secondary ps-3">
                            <li class="mb-2"><i class="fa-solid fa-envelope me-2"></i><strong>Email:</strong> <a href="mailto:info@naturolia.in">info@naturolia.in</a></li>
                            <li class="mb-2"><i class="fa-solid fa-phone me-2"></i><strong>Customer Care:</strong> +91-97804-11123</li>
                            <li class="mb-2"><i class="fa-solid fa-clock me-2"></i><strong>Timings:</strong> Monday – Saturday, 10 AM to 7 PM</li>
                        </ul>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>
@endsection