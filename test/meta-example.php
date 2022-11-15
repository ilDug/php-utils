  <?php
    class AppConfig
    {

        public function init()
        {
            \ilDug\Web\Meta::$TEMPLATE = __DIR__ . "/path/to/tags.html";

            /** default */
            \ilDug\Web\Meta::$PLACEHOLDERS = array('%TITLE%', '%DESCRIPTION%', '%MAIN_IMAGE%', '%URL%');
        }
    }

    ?>


  <head>
      <!-- META -->
      <?php
        /** REQUIRED or set in  AppConfig class*/
        \ilDug\Web\Meta::$TEMPLATE = __DIR__ . "/path/to/tags.html";

        /** OPTIONAL or set in  AppConfig class*/
        \ilDug\Web\Meta::$PLACEHOLDERS = array('%TITLE%', '%DESCRIPTION%', '%MAIN_IMAGE%', '%URL%');


        \ilDug\Web\Meta::publish([
            "Title",
            "Description",
            "https://website.it/path/to/images/main_image.jpg",
            "https://website.it",
        ]);
        ?>

      <!-- STYLES  -->
      <link rel="stylesheet" href="dist/styles.css">
  </head>