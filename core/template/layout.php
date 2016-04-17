<?php
// Before anything is sent, set the appropriate header
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>EUNIQUE</title>
        <?php
        /*         * *
         * This section specifies the page header
         */

        // The page title
        if ($templateResource = TemplateResource::getResource('title')) {
            ?>
            <title><?php echo $templateResource; ?></title>
        <?php } ?>	
        <!-- Basic CSS -->
        <!-- End of basic CSS -->
        <?php
        // The CSS included
        if ($templateResource = TemplateResource::getResource('css')) {
            ?>
            <!-- Additional CSS -->
            <?php
            foreach ($templateResource as $style) {
                $style = "web/$style";
                ?>
                <link rel="stylesheet" href="<?php echo $style; ?>" />
                <?php
            }
            ?>
            <!-- Additional CSS end -->
            <?php
        }
        ?>
        <!-- Favicon and touch icons -->
    </head>
    <body> 
        <div>
            <?php
            require $currentPage;
            ?>
            <div class="control-sidebar-bg"></div>
        </div>

        <?php
        /*         * *
         * Specify the scripts that are to be added.
         */
        if ($templateResource = TemplateResource::getResource('js')) {
            ?>
            <!-- Additional Scripts -->
            <?php
            foreach ($templateResource as $js) {
                $js = "web/$js";
                ?>
                <script src="<?php echo $js; ?>"></script>
                <?php
            }
            ?>
            <?php
        }
        ?>
        <?php if (!App::isLoggedIn()) { ?>
            <script>
                jQuery(document).ready(function () {
                    App.initLogin();
                });
            </script>
        <?php } else { ?>
            <script>
                jQuery(document).ready(function () {
                    // initiate layout and plugins
                    App.init();
                    //App.setMainPage(true);

                });
            </script>
            <?php
        }
        ?>
    </body>
</html>
