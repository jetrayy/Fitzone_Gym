<?php
session_start();
session_destroy();
echo '<script>
    alert("You are now logged out. See you again soon!");
    window.location.href = "../index.php";
</script>'; // Redirect to home page
exit;
?>
