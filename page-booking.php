<?php
/* Template Name: Booking Page */
get_header();
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h3 class="card-title mb-3 text-center">Daweddy Appointment</h3>

          <form id="bookingForm" novalidate>
            <div class="mb-3">
              <label class="form-label">Your Name *</label>
              <input type="text" class="form-control" id="name" name='name' required>
            </div>

            <div class="mb-3">
              <label class="form-label">Phone *</label>
              <input type="tel" class="form-control" id="phone" name='phone' required>
            </div>

            <div class="mb-3">
              <label class="form-label">Email*</label>
              <input type="email" class="form-control" id="email" name='email' required>
            </div>

            <div class="mb-3">
              <label class="form-label">Service</label>
              <select class="form-select" id="service" name='service'>
                <option value="Consultation">Consultation</option>
                <option value="first">first Meeting</option>
                <option value="second">Second Meeting</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Date *</label>
              <input type="date" id="date" class="form-control" name='date' required min="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="mb-3">
              <label class="form-label">Time Slot *</label>
              <select id="timeSlot" class="form-select" name='timeSlot' required>
                <option value="">Select date first</option>
              </select>
            </div>

            <div id="bookingMessage" class="mb-3"></div>

            <button class="btn btn-success w-100 " type="submit">Confirm & Continue to WhatsApp</button>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<?php

get_footer();
