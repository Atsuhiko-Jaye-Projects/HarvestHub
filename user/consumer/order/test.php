<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Help & Support</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: #f5f8fa;
      color: #333;
    }
    header {
      background: linear-gradient(135deg, #6c63ff, #3f3fff);
      color: #fff;
      padding: 60px 0;
      text-align: center;
    }
    header h1 {
      font-size: 2.8rem;
      margin-bottom: 10px;
    }
    header p {
      font-size: 1.2rem;
    }
    section {
      padding: 60px 0;
    }
    .faq .card {
      border: none;
      border-radius: 10px;
      margin-bottom: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .faq .card-header {
      background: #fff;
      border-bottom: none;
      cursor: pointer;
      font-weight: 600;
    }
    .contact-form input, .contact-form textarea {
      border-radius: 8px;
      border: 1px solid #ccc;
    }
    .contact-form button {
      border-radius: 8px;
      background: #6c63ff;
      border: none;
    }
    footer {
      background: #222;
      color: #aaa;
      text-align: center;
      padding: 30px 0;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <header>
    <div class="container">
      <h1>Help & Support</h1>
      <p>We're here to help you. Find answers or contact us directly.</p>
    </div>
  </header>

  <!-- FAQ Section -->
  <section class="faq bg-light">
    <div class="container">
      <h2 class="text-center mb-5">Frequently Asked Questions</h2>
      <div class="accordion" id="faqAccordion">
        <div class="card">
          <div class="card-header" id="faq1" data-bs-toggle="collapse" data-bs-target="#collapse1">
            How do I create an account?
          </div>
          <div id="collapse1" class="collapse show" data-bs-parent="#faqAccordion">
            <div class="card-body">
              You can create an account by clicking the "Sign Up" button on the top right corner and filling out the registration form.
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header" id="faq2" data-bs-toggle="collapse" data-bs-target="#collapse2">
            How can I reset my password?
          </div>
          <div id="collapse2" class="collapse" data-bs-parent="#faqAccordion">
            <div class="card-body">
              Click "Forgot Password?" on the login page and follow the instructions to reset your password via email.
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header" id="faq3" data-bs-toggle="collapse" data-bs-target="#collapse3">
            How do I contact support?
          </div>
          <div id="collapse3" class="collapse" data-bs-parent="#faqAccordion">
            <div class="card-body">
              You can fill out the contact form below or email us at <strong>support@example.com</strong>.
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Form Section -->
  <section class="contact">
    <div class="container">
      <h2 class="text-center mb-5">Contact Us</h2>
      <div class="row justify-content-center">
        <div class="col-md-8">
          <form class="contact-form">
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" placeholder="Your Name">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" placeholder="you@example.com">
            </div>
            <div class="mb-3">
              <label for="message" class="form-label">Message</label>
              <textarea class="form-control" id="message" rows="5" placeholder="Your Message"></textarea>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary px-5 py-2">Send Message</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <p>&copy; 2025 Your Company. All rights reserved.</p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
