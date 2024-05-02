<?php $swagger = config('Swagger'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Platform UNIP API</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url('swagger/swagger-ui.css') ?>"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url('swagger/index.css') ?>"/>
    <link rel="icon" type="image/png" href="<?= base_url('swagger/favicon-32x32.png') ?>" sizes="32x32"/>
    <link rel="icon" type="image/png" href="<?= base_url('swagger/favicon-16x16.png') ?>" sizes="16x16"/>
</head>
<body>
<div id="swagger-ui"></div>
<script src="<?= base_url('swagger/swagger-ui-bundle.js') ?>" charset="UTF-8"></script>
<script src="<?= base_url('swagger/swagger-ui-standalone-preset.js') ?>" charset="UTF-8"></script>
<script src="<?= base_url('swagger/swagger-initializer.js') ?>" charset="UTF-8"></script>
<script>
    window.onload = function () {
        // Build a system
        window.ui = SwaggerUIBundle({
            dom_id: '#swagger-ui',
            deepLinking: true,
            enableCORS: true,
            url: "<?=base_url("swagger/" . $swagger->jsonFileName)?>",
            operationsSorter: <?= isset($swagger->operationsSort) ? '"' . $swagger->operationsSort . '"' : 'null' ?>,
            configUrl: <?= isset($swagger->additionalConfigUrl) ? '"' . $swagger->additionalConfigUrl . '"' : 'null' ?>,
            validatorUrl: <?= isset($swagger->validatorUrl) ? '"' . $swagger->validatorUrl . '"' : 'null' ?>,
            oauth2RedirectUrl: "<?=base_url($swagger->oauth2Callback)?>",
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],
            plugins: [
                SwaggerUIBundle.plugins.DownloadUrl
            ],
            layout: "StandaloneLayout"
        });
    }
</script>
</body>
</html>