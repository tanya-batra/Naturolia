@extends('layout.main')

@section('content')
<section id="returns-policy-page" class="py-5" style="min-height: 80vh;">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                
                <header class="text-center mb-5" data-aos="fade-down">
                    <h1 class="display-4 fw-bold" style="color: var(--primary-color);">Returns & Replacements</h1>
                    <p class="lead text-muted">
                        We offer an easy 5-day return policy for eligible products, ensuring hygiene and safety.
                    </p>
                </header>
                
                <div class="policy-content">

                    <div class="policy-section mb-5" data-aos="fade-up">
                        <h2 class="fw-bold text-primary mb-3 pb-2 border-bottom"> Returns & Replacements</h2>
                        
                        <p class="text-secondary mb-3">We offer an easy <strong>5-day return policy</strong> for eligible products.</p>
                        
                        <h4 class="fw-semibold">Eligibility for Return/Replacement</h4>
                        <p class="text-secondary">You can request a return or replacement within <strong>5 days of receiving your order</strong> if:</p>
                        <ul class="list-unstyled text-secondary ps-3">
                            <li class="mb-2"><i class="fa-solid fa-circle-right text-success me-2"></i>You have received a damaged, defective, leaking, or wrong product, **or**</li>
                            <li class="mb-2"><i class="fa-solid fa-circle-right text-success me-2"></i>The product delivered does not match your order details.</li>
                        </ul>
                        
                        <p class="text-secondary mt-4"><strong>Please note:</strong></p>
                        <ul class="list-unstyled text-secondary ps-3">
                            <li class="mb-2"><i class="fa-solid fa-ban text-danger me-2"></i>Returns are accepted only if products are **unused, unopened, and in their original packaging** with seals, labels, and barcodes intact.</li>
                            <li class="mb-2"><i class="fa-solid fa-gift text-info me-2"></i>Free gifts, sample packs, or promotional items must also be returned along with the original order.</li>
                            <li class="mb-2"><i class="fa-solid fa-xmark text-danger me-2"></i>We do not accept returns for products **opened, used, or altered** in any form for hygiene and safety reasons.</li>
                        </ul>
                        
                        <h4 class="fw-semibold mt-4">How to Raise a Return/Replacement Request</h4>
                        <ol class="text-secondary">
                            <li>Email us at <a href="mailto:info@naturolia.in">info@naturolia.in</a> within **5 days** of delivery.</li>
                            <li>Mention your Order ID, reason for return, and attach clear **images/videos** of the product and invoice.</li>
                            <li>Our team will review your request within **3 business days**.</li>
                            <li>Once approved, a reverse pickup will be arranged within **4–7 business days**.</li>
                            <li>Replacement or refund will be initiated after we receive and inspect the returned product.</li>
                        </ol>
                    </div>

                    <div class="policy-section mb-5" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="fw-bold text-danger mb-3 pb-2 border-bottom">Non-Returnable Products</h2>
                        <p class="text-secondary">For health and safety reasons, the following items **cannot be returned**:</p>
                        <ul class="list-unstyled text-secondary ps-3">
                            <li class="mb-2"><i class="fa-solid fa-ban text-danger me-2"></i>Opened or used herbal supplements, powders, or liquids.</li>
                            <li class="mb-2"><i class="fa-solid fa-ban text-danger me-2"></i>Products with tampered or missing seals.</li>
                            <li class="mb-2"><i class="fa-solid fa-ban text-danger me-2"></i>Items returned after 5 days of delivery.</li>
                        </ul>
                    </div>

                    <div class="policy-section mb-5" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="fw-bold text-info mb-3 pb-2 border-bottom">Policy Updates</h2>
                        <p class="text-secondary">
                            Naturolia reserves the right to update or modify this policy at any time without prior notice. Any changes will be reflected on this page, and we encourage you to review it periodically.
                        </p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>
@endsection