<?php 
// 1. Ku dar Header-kaaga
('config/header.php'); 

// 2. Qaado ID-ga laga soo diray bogga hore
$sector_id = isset($_GET['id']) ? $_GET['id'] : 1;

// 3. Diyaari xogta 6-da page (halkan ayaad ka bedbedeli kartaa qoraalka)
$all_sectors = [
    1 => [
        'title' => 'Government Infrastructure',
        'bg' => 'assest/uploads/planet.jpg',
        'desc' => 'We specialize in constructing high-security government buildings, national monuments, and public service centers that stand the test of time.'
    ],
    2 => [
        'title' => 'Healthcare Engineering',
        'bg' => 'assest/uploads/s1.jpg',
        'desc' => 'Our engineering team designs medical facilities with precision, focusing on patient safety, advanced ventilation, and modern lab spaces.'
    ],
    3 => [
        'title' => 'Commercial Development',
        'bg' => 'assest/uploads/commercial.jpg',
        'desc' => 'From luxury shopping malls to corporate skyscrapers, we build commercial spaces that drive business growth and innovation.'
    ],
    4 => [
        'title' => 'Industrial Construction',
        'bg' => 'assest/uploads/ind.jpg',
        'desc' => 'Building heavy-duty factories and smart warehouses with the latest structural technology for industrial efficiency.'
    ],
    5 => [
        'title' => 'Residential Projects',
        'bg' => '../',
        'desc' => 'We create dream homes. Our residential portfolio includes high-end villas and eco-friendly apartment complexes.'
    ],
    6 => [
        'title' => 'Civil Engineering & Roads',
        'bg' => 'assest/uploads/road.jpg',
        'desc' => 'Connecting cities through resilient highway networks, bridges, and sustainable urban transportation systems.'
    ]
];

// Soo saar xogta qaybta la gujiyo, haddii kale u dhowow tan koowaad
$current_sector = isset($all_sectors[$sector_id]) ? $all_sectors[$sector_id] : $all_sectors[1];
?>

<main>
    <section style="background: linear-gradient(rgba(6, 64, 43, 0.8), rgba(0, 0, 0, 0.8)), url('<?php echo $current_sector['bg']; ?>'); 
                    background-size: cover; background-position: center; padding: 150px 0; text-align: center; color: white;">
        <div class="container">
            <h1 style="font-size: 50px; font-weight: 900; text-transform: uppercase;"><?php echo $current_sector['title']; ?></h1>
            <div style="width: 80px; height: 5px; background: #28a745; margin: 20px auto;"></div>
            <p style="font-size: 18px; opacity: 0.9;">Home / Sectors / <?php echo $current_sector['title']; ?></p>
        </div>
    </section>

    <section style="padding: 100px 0; background: #fff;">
        <div class="container" style="max-width: 900px; margin: 0 auto; text-align: center;">
            <h2 style="color: #06402B; margin-bottom: 30px; font-size: 35px;">Overview of Our Services</h2>
            <p style="font-size: 18px; line-height: 1.8; color: #555; margin-bottom: 40px;">
                <?php echo $current_sector['desc']; ?>
            </p>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 50px;">
                <div style="padding: 20px; border: 1px solid #eee; border-radius: 10px;">
                    <h3 style="color: #28a745;">100%</h3>
                    <p>Quality Assured</p>
                </div>
                <div style="padding: 20px; border: 1px solid #eee; border-radius: 10px;">
                    <h3 style="color: #28a745;">Safety</h3>
                    <p>First Priority</p>
                </div>
                <div style="padding: 20px; border: 1px solid #eee; border-radius: 10px;">
                    <h3 style="color: #28a745;">Modern</h3>
                    <p>Technology</p>
                </div>
            </div>

            <div style="margin-top: 60px;">
                <a href="index.php#home-sectors" style="padding: 15px 35px; background: #06402B; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold;">BACK TO ALL SECTORS</a>
            </div>
        </div>
    </section>
</main>

<?php 
// 4. Ku dar Footer-kaaga
('config/footer.php'); 
?>