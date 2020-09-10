function logoutConfirm() {
    if(window.confirm('Sigur doriti sa va delogati?')) {
        window.location = 'index.php?action=logout';
    } else {
        window.location = 'index.php';
    }
}