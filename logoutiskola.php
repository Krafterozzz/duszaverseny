<?php
session_start();
session_destroy();
echo "<script>
    localStorage.removeItem('is_logged_in2');
    window.location.href = 'index.html';
</script>";
exit();
?>
