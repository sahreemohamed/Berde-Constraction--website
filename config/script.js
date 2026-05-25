// 1. Sticky Navigation Menu
window.addEventListener("scroll", function() {
    let header = document.querySelector("header");
    // Waxay ku daraysaa class-ka "sticky" marka qofku hoos u dego 1px
    header.classList.toggle("sticky", window.scrollY > 0);
});

// 2. Smooth Scrolling for Links
document.querySelectorAll('nav a').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        // Kaliya haddii uu yahay link gudaha bogga ah (#)
        const href = this.getAttribute('href');
        if(href.includes('#')) {
            e.preventDefault();
            const targetId = href.split('#')[1];
            const targetElement = document.getElementById(targetId);
            
            if(targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 70, // 70px waa meel u dhow height-ka header-ka
                    behavior: 'smooth'
                });
            }
        }
    });
});

// 3. Fade-in Animation on Scroll (Intersection Observer)
const faders = document.querySelectorAll('section');
const appearOptions = {
    threshold: 0.15,
    rootMargin: "0px 0px -50px 0px"
};

const appearOnScroll = new IntersectionObserver(function(entries, appearOnScroll) {
    entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('appear');
        appearOnScroll.unobserve(entry.target);
    });
}, appearOptions);

faders.forEach(fader => {
    appearOnScroll.observe(fader);
});

// 4. Simple Form Validation (Contact Page)
const contactForm = document.querySelector('.contact-form form'); // Hubi inuu foomku ku dhex jiro class-ka .contact-form
if(contactForm) {
    contactForm.addEventListener('submit', function(e) {
        const name = document.querySelector('input[name="name"]').value.trim();
        const email = document.querySelector('input[name="email"]').value.trim();
        const message = document.querySelector('textarea[name="message"]').value.trim();
        
        if(name === "" || email === "" || message === "") {
            e.preventDefault();
            alert("Please fill all required fields: Name, Email, and Message.");
        } else {
            // Halkan waxaad ku dari kartaa message ah 'Sending...'
            console.log("Form is valid, submitting...");
        }
    });
}

// 5. Live Search Filter (Projects/Work Items)
const searchInput = document.querySelector('input[name="query"]');
if(searchInput) {
    searchInput.addEventListener('keyup', function() {
        let filter = searchInput.value.toLowerCase();
        let projectCards = document.querySelectorAll('.work-item'); // Hubi in magaca class-kaaga uu yahay .work-item

        projectCards.forEach(card => {
            let titleElement = card.querySelector('h3');
            let categoryElement = card.querySelector('span');
            
            let title = titleElement ? titleElement.innerText.toLowerCase() : "";
            let category = categoryElement ? categoryElement.innerText.toLowerCase() : "";
            
            if(title.includes(filter) || category.includes(filter)) {
                card.style.display = ""; // Muuji card-ka
            } else {
                card.style.display = "none"; // Qari card-ka
            }
        });
    });
}
document.querySelector("form").addEventListener("submit", () => {
  console.log("Login attempt submitted");
});
