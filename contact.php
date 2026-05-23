<?php include 'includes/header.php'; ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h4 class="mb-0">Contact Us</h4>
            </div>
            <div class="card-body p-4">
                <form class="needs-validation" novalidate onsubmit="event.preventDefault(); alert('Message sent successfully!');">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" required>
                        <div class="invalid-feedback">Please provide your name.</div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" required>
                        <div class="invalid-feedback">Please provide a valid email.</div>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" rows="4" required></textarea>
                        <div class="invalid-feedback">Please write a message.</div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
