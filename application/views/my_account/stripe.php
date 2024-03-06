<div class="custom-control custom-radio">
    <input type="radio" name="payment_method" id="stripe" class="custom-control-input get_tips" value="stripe">
    <label class="custom-control-label payment-label" for="stripe">Stripe</label>
</div>

<div class="stripe-card-payment" style="display: none">
    <div class="sr-input sr-card-element StripeElement" id="card-element"></div>
    <div class="sr-field-error" id="card-errors" role="alert" style="color: red"></div>
    <div class="sr-result hidden"><p></p><pre><code></code></pre></div>

    <input type="hidden" id="stripe-token" name="stripe_token" value="">
</div>