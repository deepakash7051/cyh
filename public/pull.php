<?php
  $key = urlencode(')91@!876@m,k:"][wsd');

  //exec("cd ../ && export COMPOSER_HOME='$HOME/.config/composer' && composer dump-autoload  2>&1", $output);

  exec("cd ../ && git pull https://macrew_bitbucket:$key@bitbucket.org/macrewt/cyh_laravel.git master 2>&1", $output);

  exec("cd ../ && php artisan migrate 2>&1", $output);

  //exec("cd ../ && php artisan db:seed --class=SettingsTableSeeder 2>&1", $output);

  //exec("cd ../ && php artisan cache:clear && php artisan route:cache && php artisan optimize && php artisan view:clear 2>&1", $output);

  echo implode("<br>", $output);
