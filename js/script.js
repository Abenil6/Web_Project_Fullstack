// Existing code remains the same until the end
let navbar = document.querySelector('.header .navbar');

document.querySelector('#menu-btn').onclick = () => {
   navbar.classList.toggle('active');
}

window.onscroll = () => {
   navbar.classList.remove('active');
}

document.querySelectorAll('.contact .row .faq .box h3').forEach(faqBox => {
   faqBox.onclick = () => {
      faqBox.parentElement.classList.toggle('active');
   }
});

// Home slider (existing)
var swiper = new Swiper(".home-slider", {
   loop: true,
   effect: "coverflow",
   spaceBetween: 30,
   grabCursor: true,
   coverflowEffect: {
      rotate: 50,
      stretch: 0,
      depth: 100,
      modifier: 1,
      slideShadows: false,
   },
   navigation: {
     nextEl: ".swiper-button-next",
     prevEl: ".swiper-button-prev",
   },
});

// Reviews slider (existing)
var swiper = new Swiper(".reviews-slider", {
   loop: true,
   slidesPerView: "auto",
   grabCursor: true,
   spaceBetween: 30,
   pagination: {
      el: ".swiper-pagination",
   },
   breakpoints: {
      768: {
        slidesPerView: 1,
      },
      991: {
        slidesPerView: 2,
      },
   },
});

// NEW CODE FOR AUTH PAGES ====================================
// Only run auth-related code on auth pages
if (document.querySelector('.auth-page')) {
   // Form validation
   const authForm = document.querySelector('.auth-form');
   
   if (authForm) {
      authForm.addEventListener('submit', function(e) {
         e.preventDefault();
         
         const submitBtn = this.querySelector('button[type="submit"]');
         submitBtn.classList.add('loading');
         submitBtn.disabled = true;
         
         // Simulate API call
         setTimeout(() => {
            submitBtn.classList.remove('loading');
            submitBtn.disabled = false;
            
            // Show success message
            const successMsg = document.createElement('div');
            successMsg.className = 'success-message';
            successMsg.innerHTML = `
               <i class="fas fa-check-circle"></i>
               <p>${this.id === 'login-form' ? 'Login successful!' : 'Registration complete!'}</p>
            `;
            authForm.prepend(successMsg);
            
            // Remove message after 3 seconds
            setTimeout(() => {
               successMsg.remove();
               if (this.id === 'login-form') {
                  window.location.href = 'index.html'; // Redirect after login
               }
            }, 3000);
            
            // Reset form if register
            if (this.id === 'register-form') {
               this.reset();
            }
         }, 1500);
      });
   }
   
   // Toggle password visibility
   document.querySelectorAll('.toggle-password').forEach(toggle => {
      toggle.addEventListener('click', function() {
         const input = this.previousElementSibling;
         const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
         input.setAttribute('type', type);
         this.classList.toggle('fa-eye');
         this.classList.toggle('fa-eye-slash');
      });
   });
}