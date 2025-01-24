<?php
session_start(); // Start session to access session variables
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Service Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color:rgb(231, 238, 245);
            font-family: 'Arial', sans-serif;
        }
        
        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
        }
        
        .navbar .navbar-brand {
            font-weight: bold;
            font-size: 1.8rem;
        }
        
        .navbar-nav .nav-link {
            font-size: 1.1rem;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover {
            background-color: #28a745;
            color: white;
            border-radius: 5px;
        }
        
        .navbar-toggler-icon {
            color: white;
        }

        /* Hero Section */
        .hero-section {
            background-image: url(image2.jpg);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: white;
            text-align: center;
            padding: 150px 20px;
            position: relative;
        }
        
        .hero-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Dark overlay */
        }
        
        .hero-title {
            background-color: rgba(255, 255, 255, 0.97);
            color:rgba(0, 0, 0, 0.97) ;
            font-size: 4rem;
            font-weight: bold;
            z-index: 1;
        }

        .hero-subtitle {
          
            color:rgba(0, 0, 0, 0.97) ;
            font-size: 1.6rem;
            font-weight: bold;
            z-index: 1;
        }

        /* Service Cards */
        .service-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .service-card .card-body {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
        }

        .service-card .card-body h5 a {
            text-decoration: none;
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
            transition: color 0.3s ease;
        }

        .service-card .card-body h5 a:hover {
            color: #28a745;
        }

        /* Contact Form */
        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        .form-container input, .form-container textarea {
            border-radius: 5px;
            padding: 12px;
            font-size: 1rem;
        }

        .form-container button {
            font-size: 1.1rem;
            background-color: #28a745;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            color: white;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #218838;
        }

        /* Footer */
        footer {
            background-color: #333;
            color: #fff;
            padding: 30px 0;
        }

        footer p {
            margin: 0;
        }
        
        /* Modal */
        .modal-content {
            border-radius: 10px;
        }

        .modal-header {
            background-color: #28a745;
            color: white;
            border-radius: 10px 10px 0 0;
        }
        .contain {
            display: flex;
            justify-content:center;
            align-items: center;
            gap: 20px; /* Space between employee cards */
            padding: 20px;
        }
        .employee-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 350px;
            display: flex;
            align-items: center; /* Aligns image and text vertically */
            transition: transform 0.3s ease;
        }

        .employee-card:hover {
            transform: translateY(-10px);
        }

        .employee-card img {
            width: 100px; /* Adjusted size */
            height: 100px; /* Adjusted size */
            object-fit: cover;
            border-radius: 50%; /* Rounded image */
            margin-right: 20px; /* Space between image and text */
        }

        .employee-card .details {
            padding: 20px;
        }

        .employee-card .details h3 {
            font-size: 1.5rem;
            color: #333;
            margin: 0;
        }

        .employee-card .details p {
            font-size: 1rem;
            color: #777;
            margin: 5px 0;
        }

        .employee-card .details .designation {
            font-size: 1.2rem;
            color: #28a745;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <div class="navbar">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">ITSM</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>

                        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                        <?php else: ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Account</a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a></li>
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#signupModal">Sign Up</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <h1 class="hero-title">Welcome to IT Service Management</h1>
            <p class="hero-subtitle">Streamlining IT operations for a better tomorrow</p>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Our Services</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card service-card">
                        <div class="card-body">
                            <h5><a href="signupCustomer.php">Generative AI and Automation</a></h5>
                            <p class="card-text">AI-driven chatbots, virtual assistants, and data processing will play a pivotal role in IT service management (ITSM), customer experience (CX), and software development.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card service-card">
                        <div class="card-body">
                            <h5><a href="signupCustomer.php">Cloud-native Solutions</a></h5>
                            <p class="card-text">Organizations will continue migrating to cloud-native infrastructures, embracing microservices, containerization, and Kubernetes to improve scalability and flexibility.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card service-card">
                        <div class="card-body">
                            <h5><a href="signupCustomer.php">Cybersecurity</a></h5>
                            <p class="card-text">Managed security services, AI-driven threat detection, and automated security monitoring will play an increasing role in protecting sensitive data.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <h2 style="text-align: center;">Our Team</h2>
    
 
   
    <div class="contain">
        <div class="employee-card">
            <img src="pic.png" alt="Employee Picture"> <!-- Replace 'employee.jpg' with the actual image file -->
            <div class="details">
                
                <h3>David</h3>
                <p class="designation">Software Engineer</p>
                
            </div>
        </div>
    </div>
    <div class="contain">
        <div class="employee-card">
            <img src="pic2.png" alt="Employee Picture"> <!-- Replace 'employee.jpg' with the actual image file -->
            <div class="details">
                
                <h3>Mark</h3>
                <p class="designation">Software Engineer</p>
                
            </div>
        </div>
    </div>
    <div class="contain">
        <div class="employee-card">
            <img src="pic3.png" alt="Employee Picture"> <!-- Replace 'employee.jpg' with the actual image file -->
            <div class="details">
                
                <h3>John</h3>
                <p class="designation">Software Engineer</p>
                
            </div>
        </div>
    </div>

   <!-- Contact Section -->
   <section id="contact" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Contact Us</h2>

            <!-- Success/Error Messages -->
            <?php
            if (isset($_SESSION['success'])) {
                echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
                unset($_SESSION['success']);
            } elseif (isset($_SESSION['error'])) {
                echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
                unset($_SESSION['error']);
            } elseif (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
                echo "<div class='alert alert-danger'><ul>";
                foreach ($_SESSION['errors'] as $error) {
                    echo "<li>" . $error . "</li>";
                }
                echo "</ul></div>";
                unset($_SESSION['errors']);
            }
            ?>

            <form action="contact_process.php" method="POST" class="form-container">
                <div class="mb-3">
                    <label for="fullName" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Enter your full name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone (Optional)</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone number">
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="4" placeholder="Enter your message" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="additionalInfo" class="form-label">Additional Information (Optional)</label>
                    <textarea class="form-control" id="additionalInfo" name="additionalInfo" rows="2" placeholder="Any additional information"></textarea>
                </div>
                <button type="submit" class="btn btn-success w-100">Send Message</button>
            </form>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; 2025 IT Service Management. All rights reserved.</p>
            <p>Designed with ❤ by ClusterWizards Team</p>
        </div>
    </footer>

    <!-- Modal Structures (Login and Signup) -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="login.php" method="post">
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="signupModalLabel">Sign Up</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="registration.php" method="post">
                        <button type="submit" class="btn btn-success w-100">Sign Up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
