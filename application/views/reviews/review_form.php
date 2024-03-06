<?php
    $is_login = $this->Customer_Model->customer_is_loggedIn();
    $customer_name = '';
    $customer_email = '';
    if ($is_login) {
	    $customer_id = $this->Customer_Model->get_logged_in_customer_id();
	    $customer = $this->Customer_Model->get($customer_id);
	    $customer_name = $customer->title.' '.$customer->first_name.' '.$customer->last_name;
	    $customer_email = $customer->email;
    }
?>

<div class="modal" id="reviewFormModal">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title">Write your review</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<label class="label" for="ratings">Ratings</label>
						<div class="form-group">
							<div class="row">
								<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">Food</div>
								<div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9">
									<i class="fa fa-star-o form-star unchecked-star food-star food-one-star" aria-hidden="true" star-val="1"></i>
			                        <i class="fa fa-star form-star checked-star food-star food-selected-one-star" aria-hidden="true" star-val="1"></i>

			                        <i class="fa fa-star-o form-star unchecked-star food-star food-two-star" aria-hidden="true" star-val="2"></i>
			                        <i class="fa fa-star form-star checked-star food-star food-selected-two-star" aria-hidden="true" star-val="2"></i>

			                        <i class="fa fa-star-o form-star unchecked-star food-star food-three-star" aria-hidden="true" star-val="3"></i>
									<i class="fa fa-star form-star checked-star food-star food-selected-three-star" aria-hidden="true" star-val="3"></i>

			                        <i class="fa fa-star-o form-star unchecked-star food-star food-four-star" aria-hidden="true" star-val="4"></i>
			                        <i class="fa fa-star form-star checked-star food-star food-selected-four-star" aria-hidden="true" star-val="4"></i>

			                        <i class="fa fa-star-o form-star unchecked-star food-star food-five-star" aria-hidden="true" star-val="5"></i>
			                        <i class="fa fa-star form-star checked-star food-star food-selected-five-star" aria-hidden="true" star-val="5"></i>
			                        <br>

			                        <input type="hidden" class="form-control" id="food-star-count" name="food_star">
			                        <span class="error" id="food-star-error"></span>
								</div>

								<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">Service</div>
								<div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9">
									<i class="fa fa-star-o form-star unchecked-star service-star service-one-star" aria-hidden="true" star-val="1"></i>
			                        <i class="fa fa-star form-star checked-star service-star service-selected-one-star" aria-hidden="true" star-val="1"></i>

			                        <i class="fa fa-star-o form-star unchecked-star service-star service-two-star" aria-hidden="true" star-val="2"></i>
			                        <i class="fa fa-star form-star checked-star service-star service-selected-two-star" aria-hidden="true" star-val="2"></i>

			                        <i class="fa fa-star-o form-star unchecked-star service-star service-three-star" aria-hidden="true" star-val="3"></i>
									<i class="fa fa-star form-star checked-star service-star service-selected-three-star" aria-hidden="true" star-val="3"></i>

			                        <i class="fa fa-star-o form-star unchecked-star service-star service-four-star" aria-hidden="true" star-val="4"></i>
			                        <i class="fa fa-star form-star checked-star service-star service-selected-four-star" aria-hidden="true" star-val="4"></i>

			                        <i class="fa fa-star-o form-star unchecked-star service-star service-five-star" aria-hidden="true" star-val="5"></i>
			                        <i class="fa fa-star form-star service-star checked-star service-star service-selected-five-star" aria-hidden="true" star-val="5"></i>
			                        <br>

			                        <input type="hidden" class="form-control" id="service-star-count" name="service_star">
			                        <span class="error" id="service-star-error"></span>
								</div>

								<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">Atmosphere</div>
								<div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9">
									<i class="fa fa-star-o form-star unchecked-star atmosphere-star atmosphere-one-star" aria-hidden="true" star-val="1"></i>
			                        <i class="fa fa-star form-star checked-star atmosphere-star atmosphere-selected-one-star" aria-hidden="true" star-val="1"></i>

			                        <i class="fa fa-star-o form-star unchecked-star atmosphere-star atmosphere-two-star" aria-hidden="true" star-val="2"></i>
			                        <i class="fa fa-star form-star checked-star atmosphere-star atmosphere-selected-two-star" aria-hidden="true" star-val="2"></i>

			                        <i class="fa fa-star-o form-star unchecked-star atmosphere-star atmosphere-three-star" aria-hidden="true" star-val="3"></i>
									<i class="fa fa-star form-star checked-star atmosphere-star atmosphere-selected-three-star" aria-hidden="true" star-val="3"></i>

			                        <i class="fa fa-star-o form-star unchecked-star atmosphere-star atmosphere-four-star" aria-hidden="true" star-val="4"></i>
			                        <i class="fa fa-star form-star checked-star atmosphere-star atmosphere-selected-four-star" aria-hidden="true" star-val="4"></i>

			                        <i class="fa fa-star-o form-star unchecked-star atmosphere-star atmosphere-five-star" aria-hidden="true" star-val="5"></i>
			                        <i class="fa fa-star form-star checked-star atmosphere-star atmosphere-selected-five-star" aria-hidden="true" star-val="5"></i>
			                        <br>

			                        <input type="hidden" class="form-control" id="atmosphere-star-count" name="atmosphere_star">
			                        <span class="error" id="atmosphere-star-error"></span>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<label class="label" for="ratings">Share more about your experience</label>
						<div class="form-group">
							<textarea class="form-control" id="message" name="message"></textarea>
						</div>
					</div>

					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<label class="order-type" for="ratings">Did you dine in, take out, or get delivery?</label>
						<div class="form-group">
							<button type="button" class="btn btn-light order-type-btn" value="Dine in">
								<i class="fa fa-check" id="dine-in-icon" aria-hidden="true"></i> Dine in
							</button>
							<button type="button" class="btn btn-light order-type-btn" value="Take out">
								<i class="fa fa-check" id="take-out-icon" aria-hidden="true"></i> Take out
							</button>
							<button type="button" class="btn btn-light order-type-btn" value="Delivery">
								<i class="fa fa-check" id="delivery-icon" aria-hidden="true"></i> Delivery
							</button>
							<input type="hidden" class="form-control" id="choosed-order-types" name="choosed_order_types">
						</div>
					</div>

					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<label class="label" for="name">Name</label>
						<div class="form-group">
							<input type="text" class="form-control" id="name" name="name" placeholder="Please enter your name." value="<?= $customer_name ?>">
							<span class="error" id="name-error"></span>
						</div>
					</div>

					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<label class="label" for="email">Email</label>
						<div class="form-group">
							<input type="email" class="form-control" id="email" name="email" placeholder="Please enter your email" value="<?= $customer_email ?>">
							<span class="error" id="email-error"></span>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success reviews-save-btn">Post</button>
			</div>
		</div>
	</div>
</div>