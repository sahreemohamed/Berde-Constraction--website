<?php 
// 1. Isku xirka Database-ka (Hubi in magaca database-kaagu yahay berde_db)
$conn = mysqli_connect("localhost", "root", "", "berde_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['save_section'])) {
    $section_key = mysqli_real_escape_string($conn, $_POST['section_key']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    

    // Habka Sawirka:
    $image_name = "";
    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "upload/" . $image_name);
    }

    // Hubi haddii section-kan uu hore u jiray (Update) ama uu cusub yahay (Insert)
    $check = mysqli_query($conn, "SELECT id FROM site_sections WHERE section_key='$section_key'");
    
    if (mysqli_num_rows($check) > 0) {
        // UPDATE: Haddii sawir cusub la keenay, kan hore tirtir
        if ($image_name != "") {
            $query = "UPDATE site_sections SET title='$title', description='$desc', image='$image_name' WHERE section_key='$section_key'";
        } else {
            $query = "UPDATE site_sections SET title='$title', description='$desc' WHERE section_key='$section_key'";
        }
    } else {
        // INSERT: Haddii uu yahay markii u horreysay
        $query = "INSERT INTO site_sections (section_key, title, description, image) VALUES ('$section_key', '$title', '$desc', '$image_name')";
    }

    if (mysqli_query($conn, $query)) {
        header("Location: index.php?msg=Success");
    } else {
        echo "Cilad ayaa dhacday: " . mysqli_error($conn);
    }
}

// --- 2. SHAQADA TIRTIRISTA (Delete) ---
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    
    // Ka saar sawirka folder-ka marka hore
    $get_img = mysqli_query($conn, "SELECT image FROM site_sections WHERE id='$id'");
    $row = mysqli_fetch_assoc($get_img);
    if (!empty($row['image'])) {
        unlink("upload/" . $row['image']); 
    }

    // Tirtir xogta database-ka
    mysqli_query($conn, "DELETE FROM site_sections WHERE id='$id'");
    header("Location:index.php?msg=Deleted");
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berde Construction & Engineering</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="header.css">
</head>
<body>
<section class="hero-section">
    <div class="hero-container">
        
        <h1 id="changing-title" class="hero-title">
            Transforming Businesses With Engineering
        </h1>
        
        <p class="hero-subtitle">
            Expert Multi Services to Drive Growth and Efficiency
        </p>
        
        <div class="hero-btn-area">
            <a href="services.php" class="hero-btn">
                Our Capabilities <i class="fas fa-arrow-alt-circle-right ms-2"></i>
            </a>
        </div>

    </div>
</section>


<script>
    // Labada ciwaan ee aad rabtay
    const titles = [
        "Transforming Businesses With Engineering",
        "Building Sustainable Infrastructure Solutions"
    ];
    
    let currentIndex = 0;
    const titleElement = document.getElementById("changing-title");

    function changeTitle() {
        titleElement.style.opacity = 0; // Yar qari qoraalka marka uu isbeddelayo
        setTimeout(() => {
            currentIndex = (currentIndex + 1) % titles.length;
            titleElement.textContent = titles[currentIndex];
            titleElement.style.opacity = 1; // Soo saar qoraalka cusub
        }, 500);
    }

    // Wuxuu isbeddelayaa 4-tii ilbiriqsiba mar
    setInterval(changeTitle, 4000);
</script>
<header>
    
    
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="../sawir/logo.jpeg" alt="Berde Logo" class="logo-img-nav me-2">
            <div class="d-flex flex-column">
                <span class="logo-text-main">BERDE</span>
                <small class="logo-text-sub">Construction & Engineering</small>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>



     
         <nav class="navbar">
            <ul class="nav-links">
                <li><a href="index.php" class="nav-item">Home</a></li>
                

             <li class="dropdown-item">
    <a href="services.php" class="drop-link">Services <i class="fa fa-caret-down"></i></a>
    <div class="mega-menu">
        <div class="mega-container">
            <div class="mega-row">
                
                <div class="mega-col side-content">
                    <h3 class="section-title">Engineering & Design</h3>
                    <div class="service-box">
                        <h4>Architectural Design & 3D Modeling</h4>
                        <p>We provide state-of-the-art architectural blueprints and immersive 3D visualizations tailored to modern urban aesthetics and functional requirements.</p>
                    </div>
                    <div class="service-box">
                        <h4>Structural Engineering</h4>
                        <p>Our expert engineers ensure that every structure is built with maximum safety, using advanced stress analysis and high-quality material specifications.</p>
                    </div>
                    <div class="service-box">
                        <h4>Civil Infrastructure Planning</h4>
                        <p>Specializing in large-scale infrastructure projects including roads, drainage systems, and site surveys to ensure a solid foundation for any build.</p>
                    </div>
                </div>

                <div class="mega-col side-content">
                    <h3 class="section-title">Construction & Management</h3>
                    <div class="service-box">
                        <h4>General Contracting & Construction</h4>
                        <p>From residential villas to massive commercial towers, Berde Construction handles the entire building process with precision and world-class craftsmanship.</p>
                    </div>
                    <div class="service-box">
                        <h4>Project Management & Consultancy</h4>
                        <p>We manage your project from A to Z, overseeing budgets, timelines, and procurement to deliver your vision on time and within cost.</p>
                    </div>
                    <div class="service-box">
                        <h4>Interior Fit-Out & Renovations</h4>
                        <p>Transforming interior spaces with high-end finishes, modern electrical installations, and eco-friendly sustainable green building materials.</p>
                    </div>
                </div>

            </div>
            
            <div class="mega-footer-cta">
                <p>Learn more about our sustainable "Berde" building approach. <a href="services.php">Explore All Services →</a></p>
            </div>
        </div>
    </div>
</li>

<li class="dropdown-item">
    <a href="sectors.php" class="drop-link"> Sectors <i class="fa fa-caret-down"></i></a>
    
    <div class="mega-menu">
        <div class="mega-container">
            <div class="mega-row">
                
                <div class="mega-col left-side">
                    <h3 class="section-title">Urban & Real Estate Development</h3>
                    
                    <div class="service-detail">
                        <div class="icon-text">
                            <i class="fa fa-city"></i>
                            <div>
                                <h4>Premium Residential Sector</h4>
                                <p>Berde Construction is a leader in creating high-end residential living spaces. From massive housing estates and luxury private villas to modern apartment complexes, we focus on delivering comfort, security, and eco-friendly designs. We integrate "Berde" green spaces into our residential plans to ensure a healthy living environment for all families.</p>
                            </div>
                        </div>

                        <div class="icon-text">
                            <i class="fa fa-hotel"></i>
                            <div>
                                <h4>Commercial & Corporate Hubs</h4>
                                <p>We build the infrastructure where businesses thrive. Our commercial sector expertise covers the construction of high-rise office buildings, international-standard shopping malls, and luxury hotels. We focus on smart building technology, efficient energy use, and professional finishes that reflect the prestige of your business brand.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mega-col right-side">
                    <h3 class="section-title">National Infrastructure & Industry</h3>
                    
                    <div class="service-detail">
                        <div class="icon-text">
                            <i class="fa fa-bridge"></i>
                            <div>
                                <h4>Public Infrastructure & Civil Works</h4>
                                <p>We are committed to national development through robust civil engineering. Our team specializes in large-scale public works, including the design and construction of bridges, complex road networks, and urban drainage systems. We build infrastructure that connects communities and withstands the most challenging environmental conditions.</p>
                            </div>
                        </div>

                        <div class="icon-text">
                            <i class="fa fa-industry"></i>
                            <div>
                                <h4>Industrial Power & Logistics</h4>
                                <p>Supporting the backbone of the economy, we provide specialized construction for the industrial sector. This includes heavy-duty manufacturing plants, massive logistics warehouses, and renewable energy facilities. Our industrial builds are designed for maximum operational efficiency, heavy load durability, and future-proof expansion capability.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mega-footer">
                <p>Delivering excellence across every sector we serve. <a href="sectors.php">Download our Full Sector Profile & Experience Portfolio →</a></p>
            </div>
        </div>
    </div>
</li>

<li class="dropdown-item">
    <a href="projects.php" class="drop-link">Projects <i class="fa fa-caret-down"></i></a>
    
    <div class="mega-menu">
        <div class="mega-container">
            <div class="mega-row">
                
                <div class="mega-col left-side">
                    <h3 class="section-title">Active & Ongoing Developments</h3>
                    
                    <div class="project-item-list">
                        <div class="project-mini">
                            <span class="status-tag ongoing">Under Construction</span>
                            <h4>The Berde Urban Heights (Tower A & B)</h4>
                            <p>This landmark 15-story residential masterpiece is currently in its structural finishing stage. It features an innovative eco-friendly "Berde" design, integrating smart-home automation, earthquake-resistant engineering, and a sustainable water recycling system. It is set to redefine luxury living standards in the city's central business district.</p>
                        </div>

                        <div class="project-mini">
                            <span class="status-tag ongoing">Excavation & Foundation</span>
                            <h4>City Central Grand Mall & Plaza</h4>
                            <p>A massive 120,000 sq. ft. commercial hub designed for high-traffic retail excellence. Our team is currently managing the deep foundation and reinforced concrete works. Once completed, this plaza will feature advanced HVAC cooling systems, 24/7 solar power backup, and underground parking for over 500 vehicles.</p>
                        </div>

                        <div class="project-mini">
                            <span class="status-tag planning">Pre-Construction Phase</span>
                            <h4>Coastal Bridge & Infrastructure Link</h4>
                            <p>An essential civil engineering project aimed at enhancing logistical efficiency. Currently in the technical survey and environmental impact assessment phase, this project involves building a high-durability concrete bridge designed to withstand maritime corrosion and heavy-duty industrial transport loads.</p>
                        </div>
                    </div>
                </div>

                <div class="mega-col right-side">
                    <h3 class="section-title">Completed Landmarks & Success Stories</h3>
                    
                    <div class="project-featured-grid">
                        <div class="featured-project-card">
                            <div class="project-img">
                                <img src="../sawir/constuction.jpg" alt="Westside Industrial Park">
                            </div>
                            <div class="project-details">
                                <h4>Westside International Industrial Park</h4>
                                <p>Successfully delivered a state-of-the-art logistics and manufacturing hub. This project involved complex steel-frame construction, heavy-load flooring systems, and integrated fire safety networks. It now serves as a primary distribution center for national trade operations.</p>
                                <a href="project-detail.php">Read Technical Case Study →</a>
                            </div>
                        </div>

                        <div class="featured-project-card">
                            <div class="project-img">
                                <img src="../sawir/project.jpg" alt="Berde Corporate Plaza">
                            </div>
                            <div class="project-details">
                                <h4>Berde Corporate Executive Plaza</h4>
                                <p>A flagship 10-story office building that earned high praise for its energy-efficient glass facade and LEED-inspired sustainable construction. We managed everything from initial soil testing to the final premium interior fit-outs, delivering the project 2 months ahead of schedule.</p>
                                <a href="project-detail.php">Explore Project Gallery →</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mega-footer">
                <p>From complex engineering to architectural art — see how we build the future. <a href="projects.php" class="view-all-sectors" style="color:#fff; padding: 12px 30px; margin-left: 20px;">Explore Our Full Portfolio</a></p>
            </div>
        </div>
    </div>
</li>
<li class="dropdown-item">
    <a href="about.php" class="drop-link">About  <i class="fa fa-caret-down"></i></a>
    
    <div class="mega-menu">
        <div class="mega-container">
            <div class="mega-row">
                
                <div class="mega-col left-side">
                    
                <h3 class="section-title">Corporate Profile</h3>

<div class="about-content-box">
    <h4>Innovation in the Built Environment</h4>

    <p>Berde Construction and Engineering is a leader in modern infrastructure, combining architectural creativity with strong engineering solutions. Our goal is to deliver sustainable and high-quality projects.</p>

    <p>Our experienced team uses advanced technologies and international standards to ensure every project reflects quality, innovation, and environmental responsibility.</p>
</div>
                </div>

                <div class="mega-col right-side">
                    <h3 class="section-title">Our Strategic Pillars</h3>
                    
                    <div class="values-grid">
                        <div class="value-item">
                            <i class="fa fa-microchip"></i>
                            <div>
                                <h4>Innovation & Technology</h4>
                                <p>We integrate advanced construction technologies, including high-precision surveying and modern structural analysis software, to eliminate errors and optimize project timelines from the ground up.</p>
                            </div>
                        </div>

                        <div class="value-item">
                            <i class="fa fa-award"></i>
                            <div>
                                <h4>Operational Excellence</h4>
                                <p>Our execution strategy focuses on meticulous planning and resource optimization. We pride ourselves on maintaining a seamless supply chain and high-tier craftsmanship that guarantees superior finishes on every build.</p>
                            </div>
                        </div>

                        <div class="value-item">
                            <i class="fa fa-hands-holding-circle"></i>
                            <div>
                                <h4>Client-Centric Approach</h4>
                                <p>At Berde, we believe in radical transparency. We maintain constant communication with our stakeholders, providing detailed technical progress reports and ensuring that every client’s vision is realized with 100% accuracy.</p>
                            </div>
                        </div>

                        <div class="value-item">
                            <i class="fa fa-globe"></i>
                            <div>
                                <h4>Environmental Responsibility</h4>
                                <p>Our "Berde Green" initiative drives us to utilize energy-efficient building systems and eco-conscious waste management practices, reducing the carbon footprint of our developments without compromising on strength.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mega-footer">
                <p>Learn more about our leadership, history of excellence, and future-ready construction solutions. <a href="about.php" class="view-all-sectors" style="color:#fff; padding: 12px 35px; margin-left: 15px;">Explore Our Corporate Story</a></p>
            </div>
        </div>
    </div>
</li>

<li class="dropdown-item">
    <a href="careers.php" class="drop-link">Careers <i class="fa fa-caret-down"></i></a>
    
    <div class="mega-menu">
        <div class="mega-container">
            <div class="mega-row">
                
                <div class="mega-col left-side">
                    <h3 class="section-title">Build Your Career with Berde</h3>
                    
                    <div class="about-content-box">
                        <h4>A Culture of Innovation and Excellence</h4>
                        <p>At Berde Construction and Engineering, we don't just build structures; we build careers. We provide a dynamic environment where young talents and veteran experts collaborate to solve complex engineering challenges. Our team is driven by a passion for sustainability and a commitment to delivering high-quality infrastructure for the future.</p>
                        
                        <p>We offer continuous professional development, hands-on experience with cutting-edge construction technology, and a clear path for career advancement. Whether you are an engineer, an architect, or a project manager, Berde is the place where your skills meet opportunity.</p>
                    </div>
                </div>

                <div class="mega-col right-side">
                    <h3 class="section-title">Current Opportunities</h3>
                    
                    <div class="job-list">
                        <div class="value-item">
                            <i class="fa fa-pencil-ruler"></i>
                            <div>
                                <h4>Architectural & Structural Designers</h4>
                                <p>We are looking for creative minds proficient in BIM and 3D modeling to design sustainable urban landmarks.</p>
                            </div>
                        </div>

                        <div class="value-item">
                            <i class="fa fa-user-gear"></i>
                            <div>
                                <h4>Site Engineers & Project Managers</h4>
                                <p>Join our field operations team to manage large-scale construction sites with a focus on safety and precision.</p>
                            </div>
                        </div>

                        <div class="value-item">
                            <i class="fa fa-graduation-cap"></i>
                            <div>
                                <h4>Graduate Internship Program</h4>
                                <p>Developing the next generation of Somali engineering talent through structured training and mentorship.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mega-footer">
                <p>Don't see a position for you? Send your CV for future consideration. <a href="careers.php" class="view-all-sectors" style="color:#fff; padding: 10px 25px; margin-left: 15px;">Apply Now</a></p>
            </div>
        </div>
    </div>
</li>

<li><a href="contact.php" class="nav-contact-btn">Contact</a></li>

</ul>
        </nav>
    </div>
</header>

<section class="about-split-section">
    <?php
    // Waxaan ku darnay 'or die(mysqli_error($conn))' si uu inoo sheego haddii uu jiro khalad database
    //$about_query = mysqli_query($conn, "SELECT * FROM about ORDER BY id DESC LIMIT 1") or die("<div style='color:red; text-align:center; padding:20px;'>About Error: " . mysqli_error($conn) . "</div>");
    $about_query = mysqli_query($conn, "SELECT * FROM about ORDER BY id DESC LIMIT 1");
    if ($about_query && mysqli_num_rows($about_query) > 0) {
        $about_data = mysqli_fetch_assoc($about_query);
        ?>

        <div class="about-split-image">
            <img src="../admin/img/<?php echo $about_data['image']; ?>" alt="About Berde">
        </div>

        <div class="about-split-content">
            <h2><?php echo $about_data['title']; ?></h2>
            <div class="about-split-line"></div>
            
            <div class="about-split-text">
                <?php echo nl2br($about_data['description']); ?>
            </div>
        </div>

    <?php } else {
        echo "<div style='width:100%; text-align:center; padding:20px;'>Fadlan ku dar xogta 'About Us'.</div>";
    } ?>
</section>

<div class="section-title">
    <h2>Our Services</h2>
    <div class="line"></div>
    <p class="section-subtitle">Delivering excellence in every build through comprehensive construction solutions tailored to your needs.</p>
</div>

<div class="universal-grid">
    <?php
    // Sidoo kale halkan error-ka naga sii haddii uu jiro
    $get_services = mysqli_query($conn, "SELECT * FROM services WHERE status = 1") or die("<div style='color:red; text-align:center; padding:20px;'>Services Error: " . mysqli_error($conn) . "</div>");
    
    if(mysqli_num_rows($get_services) > 0) {
        while($row = mysqli_fetch_assoc($get_services)) { ?>
            <div class="content-card">
                <img src="../admin/img/<?php echo $row['image']; ?>" alt="Image">
                <div class="content-body">
                    <h3><?php echo $row['title']; ?></h3>
                    <p><?php echo $row['description']; ?></p>
                </div>
            </div>
        <?php } 
    } else {
        echo "<div style='width:100%; text-align:center; padding:20px;'>Wax Services ah kuma jiraan database-ka ama status-ka ayaa 0 ah.</div>";
    }?>
</div>

<div class="section-title">
    <h2>Main Sectors</h2>
    <div class="line"></div>
    <p class="section-subtitle">Providing specialized expertise across diverse sectors to build a more sustainable and modern future.</p>
</div>
 
<div class="universal-grid">
    <?php
    // Halkan isna ogao haddii uu qaldan yahay table-ka sectors
    $get_sectors = mysqli_query($conn, "SELECT * FROM sectors WHERE status = 1") or die("<div style='color:red; text-align:center; padding:20px;'>Sectors Error: " . mysqli_error($conn) . "</div>");
    
    if(mysqli_num_rows($get_sectors) > 0) {
        while($row = mysqli_fetch_assoc($get_sectors)) { ?>
            <div class="content-card">
                <img src="../admin/img/<?php echo $row['image']; ?>" alt="Image">
                <div class="content-body">
                    <h3><?php echo $row['title']; ?></h3>
                    <p><?php echo $row['description']; ?></p>
                </div>
            </div>
        <?php } 
    } else {
        echo "<div style='width:100%; text-align:center; padding:20px;'>Wax Sectors ah kuma jiraan database-ka ama status-ka ayaa 0 ah.</div>";
    }?>
</div>

<div class="section-title">
    <h2>Our Projects</h2>
    <div class="line"></div>
    <p class="section-subtitle">A showcase of our commitment to quality, innovation, and structural integrity in every project we complete.</p>
</div>
<div class="universal-grid">
    <?php
    $get_projects = mysqli_query($conn, "SELECT * FROM projects WHERE status = 1");
    while($row = mysqli_fetch_assoc($get_projects)) { ?>
        <div class="content-card">
            <img src="../admin/img/<?php echo $row['image']; ?>" alt=" Image">
            <div class="content-body">
                <h3><?php echo $row['title']; ?></h3>
                <p><?php echo $row['description']; ?></p>
            </div>
        </div>
    <?php } ?>
</div>



        
  <section class="py-5 bg-light">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2 class="fw-bold" style="color: #0a5c36;">Latest Job Opportunities</h2>
            <div class="line mx-auto" style="width: 70px; height: 4px; background: #16301c; margin-bottom: 20px;"></div>
        </div>

        <div class="row g-4 d-flex flex-wrap">
            <?php
            // LIMIT 3 si ay 3 kaliya u soo baxaan Home Page-ka
            $get_jobs = mysqli_query($conn, "SELECT * FROM careers WHERE status = 1 ORDER BY id DESC LIMIT 3");
            if(mysqli_num_rows($get_jobs) > 0) {
                while($row = mysqli_fetch_assoc($get_jobs)) { 
            ?>
            <div class="col-lg-4 col-md-6 d-flex">
                <div class="job-card shadow-sm w-100">
                    <img src="../admin/img/<?php echo $row['image']; ?>" class="job-img" onerror="this.src='https://via.placeholder.com/400x250?text=Career+Image'" style="width: 100%; height: 220px; object-fit: cover;">
                    
                    <div class="p-4 d-flex flex-column flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-light text-dark border px-3 py-2"><?php echo $row['job_type']; ?></span>
                            <small class="text-muted"><i class="fas fa-map-marker-alt text-danger me-1"></i> <?php echo $row['job_location']; ?></small>
                        </div>
                        
                        <h4 class="fw-bold mb-3" style="color: #0a5c36;"><?php echo $row['title']; ?></h4>
                        <p class="text-muted small flex-grow-1">
                            <?php echo substr($row['description'], 0, 90); ?>...
                        </p>
                        
                        <a href="contact.php?job=<?php echo urlencode($row['title']); ?>" class="btn-apply text-center text-decoration-none">
                            Apply Now <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php 
                } 
            } else {
                echo "<p class='text-center'>No jobs available.</p>";
            }
            ?>
        </div>

    </div>
</section>
<li><a href="contact.php" class="nav-contact-btn">Contact</a></li>
<section id="contact" style="padding: 60px 0; background-color: #f8f9fa;">
    <div style="max-width: 800px; margin: auto; background: #fff; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="color: #06402B; margin-bottom: 10px;">Get In Touch</h2>
            <p style="color: #666;">Have a project in mind? Drop us a message and our team will get back to you shortly.</p>
        </div>

        <form action="admin/send_message.php" method="POST">
            <div style="display: flex; gap: 15px; margin-bottom: 20px;">
                <div style="flex: 1;">
                    <label style="font-weight: 600; color: #333;">Full Name</label>
                    <input type="text" name="name" placeholder="e.g. John Doe" required 
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; margin-top: 5px;">
                </div>
                <div style="flex: 1;">
                    <label style="font-weight: 600; color: #333;">Email Address</label>
                    <input type="email" name="email" placeholder="name@company.com" required 
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; margin-top: 5px;">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-weight: 600; color: #333;">Your Message</label>
                <textarea name="message" placeholder="Describe your requirements..." required 
                          style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; height: 120px; margin-top: 5px; resize: none;"></textarea>
            </div>

            <div style="text-align: center;">
                <button type="submit" name="send_msg" 
                        style="background: #28a745; color: white; padding: 15px 40px; border: none; border-radius: 30px; font-weight: bold; cursor: pointer; font-size: 16px; transition: 0.3s;">
                    Send Inquiry <i class="fa fa-paper-plane"></i>
                </button>
            </div>
        </form>
    </div>
</section>

<footer class="main-footer">
    <div class="footer-container">

        <div class="footer-col about-berde">
            <div class="footer-logo-box">
                 <img src="../sawir/logo.jpeg" alt="Berde Logo">
                 <h2>Berde</h2>
            </div>
            <p class="mission-text">
                Leading the construction industry in Somalia through innovative engineering, 
                sustainable "Berde" green solutions, and world-class infrastructure development.
            </p>
        </div>

        <div class="footer-col">
            <h4 class="footer-title">Company Links</h4>
            <div class="title-line"></div>
            <ul class="footer-links">
                <li><a href="index.php"><i class="fa fa-chevron-right"></i> Home Page</a></li>
                <li><a href="services.php"><i class="fa fa-chevron-right"></i> Our Services</a></li>
                <li><a href="projects.php"><i class="fa fa-chevron-right"></i> Our Projects</a></li>
                <li><a href="about.php"><i class="fa fa-chevron-right"></i> About Berde</a></li>
                <li><a href="contact.php"><i class="fa fa-chevron-right"></i> Get in Touch</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4 class="footer-title">Contact Us</h4>
            <div class="title-line"></div>
            <div class="contact-wrapper">
                
                <a href="https://wa.me/252097430106" target="_blank" class="contact-card-link">
                    <div class="contact-box-item c-whatsapp">
                        <div class="icon-circle"><i class="fab fa-whatsapp"></i></div>
                        <div class="contact-info">
                            <span>WhatsApp & Call</span>
                            <p>+252 097430106</p>
                        </div>
                    </div>
                </a>

                <a href="mailto:berdeconstruction12@gmail.com" class="contact-card-link">
                    <div class="contact-box-item c-email">
                        <div class="icon-circle"><i class="far fa-envelope"></i></div>
                        <div class="contact-info">
                            <span>Official Email</span>
                            <p>berdeconstruction12@gmail.com</p>
                        </div>
                    </div>
                </a>

                <a href="#" target="_blank" class="contact-card-link">
                    <div class="contact-box-item c-facebook">
                        <div class="icon-circle"><i class="fab fa-facebook-f"></i></div>
                        <div class="contact-info">
                            <span>Facebook Page</span>
                            <p>BERDE</p>
                        </div>
                    </div>
                </a>

            </div>
        </div>

    </div>

    <div class="footer-bottom">
        <div class="bottom-container">
            <p>© 2026 <strong>Berde Construction & Engineering</strong>. All Rights Reserved.</p>
            <div class="legal-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>
</body>