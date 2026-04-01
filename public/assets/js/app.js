// ========================================
// PASSWORD TOGGLE
// ========================================
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

// ========================================
// TAB SWITCHING
// ========================================
function switchTab(tab, btn) {
    document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + tab).classList.add('active');
    btn.classList.add('active');
}

// ========================================
// AVATAR PREVIEW
// ========================================
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const wrapper = document.querySelector('.avatar-wrapper');
            let img = wrapper.querySelector('.avatar-img');
            let placeholder = wrapper.querySelector('.avatar-placeholder');
            if (img) {
                img.src = e.target.result;
            } else if (placeholder) {
                placeholder.style.display = 'none';
                const newImg = document.createElement('img');
                newImg.src = e.target.result;
                newImg.className = 'avatar-img';
                wrapper.insertBefore(newImg, wrapper.firstChild);
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// ========================================
// FORM LOADING STATE
// ========================================
document.addEventListener('DOMContentLoaded', function () {
   document.querySelectorAll('form:not(.add-to-cart-form)').forEach(form => {
    // Submit loading
        const btn = form.querySelector('.btn-submit');
        if (btn) {
            form.addEventListener('submit', () => btn.classList.add('loading'));
        }
    });

    // Auto switch to password tab if errors
    const passwordErrors = document.querySelector('#tab-password .is-invalid');
    if (passwordErrors) {
        const btn = document.querySelectorAll('.tab-btn')[1];
        if (btn) switchTab('password', btn);
    }

    // Sidebar mobile toggle
    const toggleBtn = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', () => sidebar.classList.toggle('open'));
        document.addEventListener('click', (e) => {
            if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });
    }

    // Auto hide alerts
    document.querySelectorAll('.alert-success, .alert-error').forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 4000);
    });
});
