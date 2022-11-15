  <?php
    class AppConfig
    {

        public function init()
        {
            \ilDug\Web\Scripts::adopt("ANALYTICS", __DIR__ . "/scripts/google-analytics.template.html");
            \ilDug\Web\Scripts::adopt("STRUCTURED_DATA", __DIR__ . "/scripts/structured-data.template.html");
            \ilDug\Web\Scripts::adopt("FACEBOOK_SDK", __DIR__ . "/scripts/facebook-sdk.template.html");
            \ilDug\Web\Scripts::adopt("TWITTER_SDK", __DIR__ . "/scripts/twitter-sdk.template.html");
            \ilDug\Web\Scripts::adopt("IUBENDA", __DIR__ . "/scripts/iubenda.template.html");
        }
    }

    ?>


  <head>

      <?php
        /** eventualmente da fare in app config */
        \ilDug\Web\Scripts::adopt("ANALYTICS", __DIR__ . "/scripts/google-analytics.template.html");
        \ilDug\Web\Scripts::adopt("STRUCTURED_DATA", __DIR__ . "/scripts/structured-data.template.html");
        \ilDug\Web\Scripts::adopt("FACEBOOK_SDK", __DIR__ . "/scripts/facebook-sdk.template.html");
        \ilDug\Web\Scripts::adopt("TWITTER_SDK", __DIR__ . "/scripts/twitter-sdk.template.html");
        \ilDug\Web\Scripts::adopt("IUBENDA", __DIR__ . "/scripts/iubenda.template.html");


        \ilDug\Web\Scripts::run(["STRUCTURED_DATA", "ANALYTICS"]);
        ?>
  </head>