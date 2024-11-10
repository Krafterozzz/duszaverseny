if (!localStorage.getItem('is_logged_in')) {
    // Ha a felhasználó nincs bejelentkezve, visszairányítjuk a bejelentkezés oldalra
window.location.href = 'admin_login.html';
}