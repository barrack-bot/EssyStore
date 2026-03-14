<?php 
session_start();
$currentPage = 'contact'; 
require_once __DIR__ . '/../resources/views/layouts/main-header.php'; ?>

    <!-- Contact Page -->
    <section class="contact-page">
        <div class="contact-header">
            <h1 class="contact-title">Contact Us</h1>
            <p class="contact-subtitle">We'd love to hear from you! Get in touch with our team</p>
        </div>
        
        <div class="contact-content">
            <div class="contact-info">
                <h2>Get in Touch</h2>
                <p>Have questions about our products? Need help with an order? Our friendly customer service team is here to help you 24/7.</p>
                
                <div class="contact-item">
                    <div class="contact-icon">📍</div>
                    <div class="contact-details">
                        <h3>Visit Us</h3>
                        <p>123 Store Street, City Center, Nairobi, Kenya</p>
                    </div>
                </div>
                
                <div class="contact-item">
                    <div class="contact-icon">📞</div>
                    <div class="contact-details">
                        <h3>Call Us</h3>
                        <p>+254 712 345 678</p>
                        <p>Mon-Fri: 9AM-6PM, Sat: 10AM-4PM</p>
                    </div>
                </div>
                
                <div class="contact-item">
                    <div class="contact-icon">📧</div>
                    <div class="contact-details">
                        <h3>Email Us</h3>
                        <p>info@essystore.com</p>
                        <p>support@essystore.com</p>
                    </div>
                </div>
                
                <div class="contact-item">
                    <div class="contact-icon">💬</div>
                    <div class="contact-details">
                        <h3>Live Chat</h3>
                        <p>Chat with us instantly</p>
                        <p>Available 24/7</p>
                    </div>
                </div>
            </div>
            
            <div class="contact-form">
                <h2>Send us a Message</h2>
                <form id="contactForm" onsubmit="handleSubmit(event)">
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Subject *</label>
                        <input type="text" id="subject" name="subject" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" required placeholder="Tell us how we can help you..."></textarea>
                    </div>
                    
                    <button type="submit" class="submit-btn">Send Message</button>
                </form>
            </div>
        </div>
        
        <!-- Map Section -->
        <div class="map-section">
            <div class="map-container">
                <div>
                    <h3>📍 Find Us</h3>
                    <p>Interactive map would be displayed here</p>
                    <p>123 Store Street, City Center, Nairobi, Kenya</p>
                </div>
            </div>
        </div>
        
        <!-- FAQ Section -->
        <div class="faq-section">
            <h2 class="faq-title">Frequently Asked Questions</h2>
            
            <div class="faq-grid">
                <div class="faq-item">
                    <div class="faq-question">
                        <span>❓</span>
                        How long does shipping take?
                    </div>
                    <div class="faq-answer">
                        Standard shipping takes 3-5 business days. Express shipping is available for 1-2 business days delivery.
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>❓</span>
                        What is your return policy?
                    </div>
                    <div class="faq-answer">
                        We offer 30-day return policy for all unused items in original packaging. Simply contact us to initiate a return.
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>❓</span>
                        Do you ship internationally?
                    </div>
                    <div class="faq-answer">
                        Yes! We ship to over 50 countries worldwide. International shipping times vary by destination.
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>❓</span>
                        How can I track my order?
                    </div>
                    <div class="faq-answer">
                        Once your order ships, you'll receive a tracking number via email. You can track your package on our website.
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>❓</span>
                        What payment methods do you accept?
                    </div>
                    <div class="faq-answer">
                        We accept all major credit cards, PayPal, M-Pesa, and bank transfers for your convenience.
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>❓</span>
                        Is my personal information secure?
                    </div>
                    <div class="faq-answer">
                        Absolutely! We use industry-standard SSL encryption to protect your personal and payment information.
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Social Media Section -->
        <div class="social-section">
            <h2 class="social-title">Connect With Us</h2>
            <p style="margin-bottom: 2rem;">Follow us on social media for updates, promotions, and more!</p>
            
            <div class="social-links">
                <a href="#" class="social-link">
                    <span>📘</span>
                    Facebook
                </a>
                <a href="#" class="social-link">
                    <span>📷</span>
                    Instagram
                </a>
                <a href="#" class="social-link">
                    <span>🐦</span>
                    Twitter
                </a>
                <a href="#" class="social-link">
                    <span>📺</span>
                    YouTube
                </a>
                <a href="#" class="social-link">
                    <span>💼</span>
                    LinkedIn
                </a>
            </div>
        </div>
    </section>

    <style>
        /* Contact Page */
        .contact-page {
            padding: 4rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .contact-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .contact-title {
            font-family: 'Poppins', sans-serif;
            font-size: 3rem;
            color: var(--secondary);
            margin-bottom: 1rem;
        }

        .contact-subtitle {
            font-size: 1.3rem;
            color: var(--gray);
        }

        .contact-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            margin-bottom: 4rem;
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .contact-info h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .contact-info p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--gray);
            margin-bottom: 1.5rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .contact-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .contact-icon {
            font-size: 2rem;
            color: var(--primary);
            min-width: 40px;
        }

        .contact-details h3 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.2rem;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .contact-details p {
            color: var(--gray);
        }

        /* Contact Form */
        .contact-form {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .contact-form h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 2rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark);
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        .form-group textarea {
            min-height: 150px;
            resize: vertical;
        }

        .submit-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
            width: 100%;
        }

        .submit-btn:hover {
            background: var(--secondary);
        }

        /* Map Section */
        .map-section {
            margin-bottom: 4rem;
        }

        .map-container {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 15px;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            text-align: center;
        }

        /* FAQ Section */
        .faq-section {
            margin-bottom: 4rem;
        }

        .faq-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            color: var(--secondary);
            text-align: center;
            margin-bottom: 3rem;
        }

        .faq-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .faq-item {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .faq-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .faq-question {
            font-family: 'Poppins', sans-serif;
            font-size: 1.2rem;
            color: var(--primary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .faq-answer {
            color: var(--gray);
            line-height: 1.6;
        }

        /* Social Media Section */
        .social-section {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 3rem 2rem;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 4rem;
        }

        .social-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            margin-bottom: 2rem;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .social-link {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .social-link:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .contact-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .contact-title {
                font-size: 2.5rem;
            }
            
            .faq-grid,
            .social-links {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script>
        function handleSubmit(event) {
            event.preventDefault();
            
            // Get form data
            const formData = new FormData(event.target);
            const data = Object.fromEntries(formData);
            
            // Show success message (in real implementation, this would send to server)
            alert('Thank you for your message! We will get back to you within 24 hours.');
            
            // Reset form
            event.target.reset();
        }
    </script>

<?php require_once __DIR__ . '/../resources/views/layouts/main-footer.php'; ?>
