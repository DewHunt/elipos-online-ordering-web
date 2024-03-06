<?php if ($this->order_type=='delivery_collection_and_dinein' ||$this->order_type=='delivery_and_collection' || $this->order_type=='delivery'): ?>
    <div class="fields form-group changing-post-code">
        <label>Post Code(Delivery)</label>

        <?php
            $order_type_session = $this->session->userdata('order_type_session');
            $delivery_post_code = $this->session->userdata('delivery_post_code');
            if (empty($delivery_post_code)) {
                $delivery_post_code = $customer->delivery_postcode;
            }
        ?>
        <div autocomplete="off">
            <div class="autocomplete" style="width: 100%">
                <input data-action="<?= base_url("menu/get_delivery_charge_postcodewise/"); ?>" type="text" class="input1" id="delivery_postcode" name="delivery_postcode" value="<?=$delivery_post_code?>" <?= !empty($order_type_session == 'delivery') ? 'required="required"' : '' ?> >
            </div>
        </div>
        <label class="error invalid-post-code-message" ></label>
    </div>
     
    <h4 class="color_green"><strong>DELIVERY DETAILS</strong></h4>
    <div class="form-group">
        <!-- <label>Delivery Address &nbsp;
            <span style="display: none">
                <input style="" type="checkbox" id="same_as_billing_address_line_1_checkbox" name="same_as_billing_address_line_1_checkbox">As Billing Address
            </span>
        </label> -->
    </div>
    <div class="fields form-group">
        <div autocomplete="off">
            <div class="autocomplete" style="width: 100%;">
                <textarea type="text" class="input1" id="delivery_address_line_1" name="delivery_address_line_1" value="" rows="4"><?=$customer->delivery_address_line_1?></textarea>
                <!-- <input type="text" class="input1" id="delivery_address_line_1" name="delivery_address_line_1" value="<?= $customer->delivery_address_line_1 ?>"> -->
            </div>
        </div>
    </div>   
<?php endif ?>