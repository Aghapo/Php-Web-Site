document.addEventListener('DOMContentLoaded', function () {
    // 1. Şifre Göster / Gizle
    const toggleButtons = document.querySelectorAll('.password-toggle-btn');
    toggleButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const targetInput = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (targetInput.type === 'password') {
                targetInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                targetInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });

    // 2. Canlı Şifre Güçlülük Kontrolü
    const passwordInput = document.getElementById('password');
    const strengthBar = document.getElementById('strength-bar');
    const strengthText = document.getElementById('strength-text');

    if (passwordInput && strengthBar && strengthText) {
        passwordInput.addEventListener('input', function () {
            const val = this.value;
            let score = 0;

            if (!val) {
                strengthBar.style.width = '0%';
                strengthText.textContent = '';
                return;
            }

            if (val.length >= 6) score += 25;
            if (val.length >= 10) score += 15;
            if (/[A-Z]/.test(val)) score += 20;
            if (/[0-9]/.test(val)) score += 20;
            if (/[^A-Za-z0-9]/.test(val)) score += 20;

            strengthBar.style.width = score + '%';

            if (score <= 35) {
                strengthBar.style.backgroundColor = '#ef4444';
                strengthText.textContent = 'Zayıf Şifre';
                strengthText.style.color = '#ef4444';
            } else if (score <= 70) {
                strengthBar.style.backgroundColor = '#f59e0b';
                strengthText.textContent = 'Orta Güçlükte Şifre';
                strengthText.style.color = '#f59e0b';
            } else {
                strengthBar.style.backgroundColor = '#10b981';
                strengthText.textContent = 'Güçlü Şifre';
                strengthText.style.color = '#10b981';
            }
        });
    }

    // 3. Şifre Eşleşme Kontrolü
    const confirmInput = document.getElementById('password_confirm');
    const matchMessage = document.getElementById('password-match-msg');

    if (confirmInput && passwordInput && matchMessage) {
        function checkPasswordMatch() {
            if (!confirmInput.value) {
                matchMessage.textContent = '';
                return;
            }
            if (passwordInput.value === confirmInput.value) {
                matchMessage.textContent = '✓ Şifreler eşleşiyor';
                matchMessage.style.color = '#10b981';
            } else {
                matchMessage.textContent = '✗ Şifreler eşleşmiyor';
                matchMessage.style.color = '#ef4444';
            }
        }
        confirmInput.addEventListener('input', checkPasswordMatch);
        passwordInput.addEventListener('input', checkPasswordMatch);
    }

    // 4. Form Gönderildiğinde Yükleniyor Buton Efekti
    const registerForm = document.getElementById('registerForm');
    const submitBtn = document.getElementById('submitBtn');

    if (registerForm && submitBtn) {
        registerForm.addEventListener('submit', function () {
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Hesap Oluşturuluyor...
            `;
        });
    }
});
