<label for="booking_purpose">Payment</label>
<div class="form-group">
	<input type="radio" name="payment_method" id="stripe" value="stripe" checked>
	<label for="sagepay"><?= get_stripe_display_name(); ?></label>
</div>

<div class="stripe-card-payment">
    <div class="sr-input sr-card-element StripeElement" id="card-element"></div>
    <div class="sr-field-error" id="card-errors" role="alert" style="color: red"></div>
    <div class="sr-result hidden">
    	<p></p>
    	<pre><code></code></pre>
    </div>

    <input type="hidden" id="stripe-token" name="stripe_token" value="">
</div>