<?php

use App\Core\App;

?>
<div class="container my-5">
    <div class="col text-center">
        <hr>
        <div>&copy; <?= date('Y') ?> &dash; <?= App::appName() ?>. Developed by <a href="https://srisar.dev">srisar.dev</a></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="<?= App::siteURL() ?>/js/libs/all.js"></script>
<script src="<?= App::siteURL() ?>/js/app.js"></script>

</body>
</html>
