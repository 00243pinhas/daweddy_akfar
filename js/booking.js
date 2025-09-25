document.addEventListener('DOMContentLoaded', function () {
    const dateInput = document.getElementById('date');
    const timeSelect = document.getElementById('timeSlot');
    const form = document.getElementById('bookingForm');
    const msg = document.getElementById('bookingMessage');

    // When date changes, fetch available slots
    dateInput.addEventListener('change', function () {
        const date = this.value;
        if (!date) return;
        msg.innerHTML = '<div class="small text-muted">Loading slots…</div>';

        const formData = new FormData();
        formData.append('action', 'get_time_slots');
        formData.append('nonce', booking_vars.nonce);
        formData.append('date', date);

        fetch(booking_vars.ajax_url, {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            timeSelect.innerHTML = '';
            if (data.success && data.data.length > 0) {
                data.data.forEach(slot => {
                    const opt = document.createElement('option');
                    opt.value = slot;
                    opt.textContent = slot;
                    timeSelect.appendChild(opt);
                });
                msg.innerHTML = '';
            } else {
                const opt = document.createElement('option');
                opt.value = '';
                opt.textContent = 'No slots available';
                timeSelect.appendChild(opt);
                msg.innerHTML = '<div class="alert alert-warning small">No slots available</div>';
            }
        })
        .catch(() => {
            timeSelect.innerHTML = '';
            const opt = document.createElement('option');
            opt.value = '';
            opt.textContent = 'Error loading slots';
            timeSelect.appendChild(opt);
            msg.innerHTML = '<div class="alert alert-danger small">Could not load slots</div>';
        });
    });

    // Form submit → save booking
    form.addEventListener('submit', function (e) {
        e.preventDefault();

            const name = form.querySelector('[name="name"]');
            const phone = form.querySelector('[name="phone"]');
            const email = form.querySelector('[name="email"]');
            const service = form.querySelector('[name="service"]');
            const date = form.querySelector('[name="date"]');
            const time = form.querySelector('[name="time"]');

            if (
                !name.value.trim() ||
                !phone.value.trim() ||
                !email.value.trim() ||
                !service.value.trim() ||
                !date.value.trim() ||
                !timeSlot.value.trim()
            ) {
                msg.innerHTML = '<div class="alert alert-danger">Please fill in all required fields.</div>';
                return;
            }
        
        const formData = new FormData(form);
        formData.append('action', 'submit_booking');
        formData.append('nonce', booking_vars.nonce);

        console.log(...formData);

        fetch(booking_vars.ajax_url, {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                msg.innerHTML = `<div class="alert alert-success">Booking saved! </div>`;
                form.reset();
                timeSelect.innerHTML = '<option value="">Select date first</option>';
            } else {
                msg.innerHTML = `<div class="alert alert-danger">${data.data}</div>`;
            }
        })
        .catch(() => {
            msg.innerHTML = `<div class="alert alert-danger">Server error. Try again later.</div>`;
        });
    });
});
