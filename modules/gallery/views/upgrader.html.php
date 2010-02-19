<?php defined("SYSPATH") or die("No direct script access.") ?>
<html>
  <head>
    <title><?= t("Gallery 3 upgrader") ?></title>
    <link rel="stylesheet" type="text/css" href="<?= url::file("modules/gallery/css/upgrader.css") ?>"
          media="screen,print,projection" />
    <script src="<?= url::file("lib/jquery.js") ?>" type="text/javascript"></script>
  </head>
  <body<? if (locales::is_rtl()) { echo ' class="rtl"'; } ?>>
    <div id="outer">
      <img src="<?= url::file("modules/gallery/images/gallery.png") ?>" />
      <div id="inner">
        <? if ($can_upgrade): ?>
        <div id="dialog" style="visibility: hidden">
          <a id="dialog_close_link" style="display: none" onclick="$('#dialog').fadeOut(); return false;" href="#" class="close">[x]</a>
          <div id="busy" style="display: none">
            <h1>
              <img width="16" height="16" src="<?= url::file("lib/images/loading-small.gif") ?>"/>
              <?= t("Upgrade in progress!") ?>
            </h1>
            <p>
              <?= t("Please don't refresh or leave the page.") ?>
            </p>
          </div>
          <div id="done" style="display: none">
            <h1> <?= t("That's it!") ?> </h1>
            <p>
              <?= t("Your <a href=\"%url\">Gallery</a> is up to date.",
                    array("url" => html::mark_clean(url::base()))) ?>
            </p>
          </div>
        </div>
        <script type="text/javascript">
          $(document).ready(function() {
            $("#dialog").css("left", Math.round(($(window).width() - $("#dialog").width()) / 2));
            $("#dialog").css("top", Math.round(($(window).height() - $("#dialog").height()) / 2));
            $("#upgrade_link").click(function(event) { show_busy() });

            <? if ($done): ?>
            show_done();
            <? endif ?>
          });

          var show_busy = function() {
            $("#dialog").css("visibility", "visible");
            $("#busy").show();
            $("#upgrade_link").parent().removeClass("button-active");
            $("#upgrade_link").replaceWith($("#upgrade_link").html())
          }

          var show_done = function() {
            $("#dialog").css("visibility", "visible");
            $("#done").show();
            $("#dialog_close_link").show();
          }
        </script>
        <p class="<?= $done ? "muted" : "" ?>">
          <?= t("Welcome to the Gallery upgrader.  One click and you're done!") ?>
        </p>
        <table>
          <tr class="<?= $done ? "muted" : "" ?>">
            <th class="name"> <?= t("Module name") ?> </th>
            <th> <?= t("Installed version") ?> </th>
            <th> <?= t("Available version") ?> </th>
          </tr>

          <? foreach ($available as $id => $module): ?>
          <? if ($module->active): ?>
          <tr class="<?= $module->version == $module->code_version ? "current" : "upgradeable" ?>" >
            <td class="name <?= $id ?>">
              <?= t($module->name) ?>
            </td>
            <td>
              <?= $module->version ?>
            </td>
            <td>
              <?= $module->code_version ?>
            </td>
          </tr>
          <? else: ?>
          <? @$inactive++ ?>
          <? endif ?>
          <? endforeach ?>
        </table>

        <? if ($done): ?>
        <div class="button muted">
          <?= t("Upgrade all") ?>
        </div>
        <? else: ?>
        <div class="button button-active">
          <a id="upgrade_link" href="<?= url::site("upgrader/upgrade") ?>">
            <?= t("Upgrade all") ?>
          </a>
        </div>
        <? endif ?>

        <? if (@$inactive): ?>
        <p class="<?= $done ? "muted" : "" ?>">
          <?= t("The following modules are inactive and don't require an upgrade.") ?>
        </p>
        <ul class="<?= $done ? "muted" : "" ?>">
          <? foreach ($available as $module): ?>
          <? if (!$module->active): ?>
          <li>
            <?= t($module->name) ?>
          </li>
          <? endif ?>
          <? endforeach ?>
        </p>
        <? endif ?>
        <? else: // can_upgrade ?>
        <h1> <?= t("Who are you?") ?> </h1>
        <p>
          <?= t("You're not logged in as an administrator, so we have to verify you to make sure it's ok for you to do an upgrade.  To prove you can run an upgrade, create a file called <b> %name </b> in your <b>%tmp_dir_path</b> directory.",
                array("name" => "$upgrade_token",
                      "tmp_dir_path" => "gallery3/var/tmp")) ?>
        </p>
        <a href="<?= url::site("upgrader?") ?>"><?= t("Ok, I've done that") ?></a>
        <? endif // can_upgrade ?>
      </div>
      <div id="footer">
        <p>
          <i>
            <?= t("Did something go wrong? Try the <a href=\"%faq_url\">FAQ</a> or ask in the <a href=\"%forums_url\">Gallery forums</a>.",
                array("faq_url" => "http://codex.gallery2.org/Gallery3:FAQ",
                      "forums_url" => "http://gallery.menalto.com/forum")) ?>
          </i>
        </p>
      </div>
    </div>
  </body>
</html>
