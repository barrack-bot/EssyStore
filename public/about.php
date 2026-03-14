<?php 
session_start();
$currentPage = 'about'; 
require_once __DIR__ . '/../resources/views/layouts/main-header.php'; ?>

    <!-- About Page -->
    <section class="about-page">
        <div class="about-header">
            <h1 class="about-title">About EssyStore</h1>
            <p class="about-subtitle">Your trusted online marketplace for unique and beautiful products</p>
        </div>
        
        <div class="about-content">
            <div class="about-text">
                <h2>Our Story</h2>
                <p>Founded in 2020, EssyStore started as a small dream to bring quality products to customers worldwide. What began as a passion project has grown into a thriving online marketplace that connects thousands of customers with carefully curated products.</p>
                
                <p>Our mission is simple: to provide exceptional products at competitive prices while delivering outstanding customer service. We believe that shopping should be enjoyable, affordable, and accessible to everyone.</p>
                
                <p>Today, EssyStore offers hundreds of products across multiple categories, from electronics to home goods, all selected with our customers' needs in mind.</p>
            </div>
            
            <div class="about-image">
                🛍️
            </div>
        </div>
        
        <!-- Values Section -->
        <div class="values-section">
            <h2 class="values-title">Our Values</h2>
            
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">🎯</div>
                    <h3 class="value-title">Quality First</h3>
                    <p class="value-description">We carefully select and test every product to ensure it meets our high standards of quality and durability.</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">💝</div>
                    <h3 class="value-title">Customer Care</h3>
                    <p class="value-description">Your satisfaction is our priority. We're here to help with any questions or concerns you may have.</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">🌍</div>
                    <h3 class="value-title">Sustainability</h3>
                    <p class="value-description">We partner with suppliers who share our commitment to environmental responsibility.</p>
                </div>
            </div>
        </div>
        
        <!-- Team Section -->
        <div class="team-section">
            <h2 class="team-title">Meet Our Team</h2>
            
            <div class="team-grid">
                <div class="team-member">
                    <div class="member-avatar">👨‍💼</div>
                    <div class="member-info">
                        <h3 class="member-name">John Smith</h3>
                        <p class="member-role">Founder & CEO</p>
                        <p class="member-bio">Passionate about bringing quality products to customers worldwide.</p>
                    </div>
                </div>
                
                <div class="team-member">
                    <div class="member-avatar">👩‍💼</div>
                    <div class="member-info">
                        <h3 class="member-name">Sarah Johnson</h3>
                        <p class="member-role">Head of Operations</p>
                        <p class="member-bio">Ensuring smooth operations and exceptional customer service.</p>
                    </div>
                </div>
                
                <div class="team-member">
                    <div class="member-avatar">👨‍💻</div>
                    <div class="member-info">
                        <h3 class="member-name">Mike Chen</h3>
                        <p class="member-role">Tech Lead</p>
                        <p class="member-bio">Building the best online shopping experience for our customers.</p>
                    </div>
                </div>
                
                <div class="team-member">
                    <div class="member-avatar">👩‍🎨</div>
                    <div class="member-info">
                        <h3 class="member-name">Emily Davis</h3>
                        <p class="member-role">Marketing Director</p>
                        <p class="member-bio">Creating amazing experiences and connecting with our community.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- CTA Section -->
        <div class="cta-section">
            <h2 class="cta-title">Ready to Start Shopping?</h2>
            <p class="cta-description">Join thousands of satisfied customers who trust EssyStore for quality products</p>
            <a href="shop.php" class="cta-button">Shop Now</a>
        </div>
    </section>

    <style>
        /* About Page */
        .about-page {
            padding: 4rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .about-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .about-title {
            font-family: 'Poppins', sans-serif;
            font-size: 3rem;
            color: var(--secondary);
            margin-bottom: 1rem;
        }

        .about-subtitle {
            font-size: 1.3rem;
            color: var(--gray);
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            margin-bottom: 4rem;
        }

        .about-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .about-text h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }

        .about-text p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--gray);
            margin-bottom: 1.5rem;
        }

        .about-image {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8rem;
            color: white;
            min-height: 400px;
        }

        /* Values Section */
        .values-section {
            margin-bottom: 4rem;
        }

        .values-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            color: var(--secondary);
            text-align: center;
            margin-bottom: 3rem;
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .value-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .value-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .value-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .value-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .value-description {
            color: var(--gray);
            line-height: 1.6;
        }

        /* Team Section */
        .team-section {
            margin-bottom: 4rem;
        }

        .team-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            color: var(--secondary);
            text-align: center;
            margin-bottom: 3rem;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .team-member {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .team-member:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .member-avatar {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: white;
        }

        .member-info {
            padding: 1.5rem;
        }

        .member-name {
            font-family: 'Poppins', sans-serif;
            font-size: 1.3rem;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .member-role {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .member-bio {
            color: var(--gray);
            font-size: 0.9rem;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 4rem 2rem;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 4rem;
        }

        .cta-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .cta-description {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        .cta-button {
            background: var(--accent);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .cta-button:hover {
            background: #d62876;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(247, 37, 133, 0.3);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .about-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .about-title {
                font-size: 2.5rem;
            }
            
            .values-grid,
            .team-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

<?php require_once __DIR__ . '/../resources/views/layouts/main-footer.php'; ?>
