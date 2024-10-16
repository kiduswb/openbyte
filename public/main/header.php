<?php 
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $canonicalUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO Tags -->
    <link rel="icon" href="/assets/img/favicon.svg">
    <link rel="canonical" href="<?php echo htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8'); ?>" />
    <meta name="robots" content="index, follow">
    <meta name="keywords" content="openbyte, openbyte hosting, openbytehosting">
    <meta name="description" content="OpenByte Hosting provides powerful and capable web hosting for free. Enjoy access to unlimited bandwidth and storage, 300+ apps and more!">
    <meta property="og:title" content="<?php echo $pageTitle; ?>" />
    <meta property="og:description" content="OpenByte Hosting provides powerful and capable web hosting for free. Enjoy access to unlimited bandwidth and storage, 300+ apps and more!" />
    <meta property="og:url" content="<?php echo htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8'); ?>" />
    <meta property="og:type" content="website" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="<?php echo $pageTitle; ?>" />
    <meta name="twitter:description" content="OpenByte Hosting provides powerful and capable web hosting for free. Enjoy access to unlimited bandwidth and storage, 300+ apps and more!" />
    <meta name="twitter:url" content="<?php echo htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8'); ?>" />
    <title><?php echo $pageTitle; ?></title>

    <!-- Dependencies -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="https://unpkg.com/htmx.org@2.0.3" integrity="sha384-0895/pl2MU10Hqc6jd4RvrthNlDiE9U1tWmX7WRESftEDRosgxNsQG/Ze9YMRzHq" crossorigin="anonymous"></script>

    <!-- Google Analytics -->
    <?php 
        if($_ENV['TRACK_GOOGLE_ANALYTICS'] == "true") 
        {
            $gtag_id = $_ENV['G_TAG_ID'];

            echo <<<_GTAG
            <script async src="https://www.googletagmanager.com/gtag/js?id=$gtag_id"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());
                gtag('config', '$gtag_id');
            </script>
_GTAG;
        }
    ?>

</head>