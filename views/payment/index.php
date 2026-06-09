<?php $pageTitle = 'Payment'; ?>
<section class="py-4">
    <div class="container">
        <h3 class="fw-bold mb-4">Complete Payment</h3>
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white fw-bold">Select Payment Method</div>
                    <div class="card-body">
                        <form method="POST" action="<?= url('payment/process') ?>" id="paymentForm">
                            <?= Security::csrfField() ?>
                            <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">

                            <div class="payment-methods">
                                <div class="form-check payment-option mb-3 p-3 border rounded">
                                    <input class="form-check-input" type="radio" name="payment_method" id="stripe" value="stripe" checked>
                                    <label class="form-check-label w-100" for="stripe">
                                        <i class="fab fa-stripe fa-2x text-primary me-2"></i>
                                        <strong>Credit/Debit Card (Stripe)</strong>
                                        <p class="text-muted small mb-0 mt-1">Pay securely with your card</p>
                                    </label>
                                </div>
                                <div class="form-check payment-option mb-3 p-3 border rounded">
                                    <input class="form-check-input" type="radio" name="payment_method" id="paypal" value="paypal">
                                    <label class="form-check-label w-100" for="paypal">
                                        <i class="fab fa-paypal fa-2x text-primary me-2"></i>
                                        <strong>PayPal</strong>
                                        <p class="text-muted small mb-0 mt-1">Pay with your PayPal account</p>
                                    </label>
                                </div>
                                <div class="form-check payment-option mb-3 p-3 border rounded">
                                    <input class="form-check-input" type="radio" name="payment_method" id="bank" value="bank_transfer">
                                    <label class="form-check-label w-100" for="bank">
                                        <i class="fas fa-university fa-2x text-primary me-2"></i>
                                        <strong>Bank Transfer</strong>
                                        <p class="text-muted small mb-0 mt-1">Transfer to our bank account (manual verification)</p>
                                    </label>
                                </div>
                                <div class="form-check payment-option mb-3 p-3 border rounded">
                                    <input class="form-check-input" type="radio" name="payment_method" id="manual" value="manual">
                                    <label class="form-check-label w-100" for="manual">
                                        <i class="fas fa-hand-holding-usd fa-2x text-primary me-2"></i>
                                        <strong>Manual Approval</strong>
                                        <p class="text-muted small mb-0 mt-1">Request manual payment approval</p>
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 mt-3" id="payBtn">
                                <i class="fas fa-lock me-2"></i>Pay <?= formatMoney($booking['final_amount']) ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white fw-bold">Order Summary</div>
                    <div class="card-body">
                        <p class="mb-1"><strong>Reference:</strong> <?= e($booking['booking_reference']) ?></p>
                        <p class="mb-1"><strong>Class:</strong> <?= cabinClassLabel($booking['cabin_class']) ?></p>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total</span>
                            <span class="text-primary"><?= formatMoney($booking['final_amount']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
