<!DOCTYPE html>
<html lang="<?php echo LANGUAGE; ?>">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>shareical</title>

    <link rel="shortcut icon" href="<?php echo APP_ROOT_URL; ?>glyphicons-46-calendar.png" />
    <link href="<?php echo APP_ROOT_URL; ?>vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo APP_ROOT_URL; ?>shareical.css" rel="stylesheet" />
</head>
<body>
    <div class="container">

        <?php if (LOGO_URL != '') : ?>
        <img style="float: left;" width="<?php echo LOGO_WIDTH; ?>" height="<?php echo LOGO_HEIGHT; ?>" src="<?php echo LOGO_URL; ?>" />
        <?php endif; ?>

        <div class="header clearfix" style="margin-top: <?php echo HEADLINE_TOP_MARGIN; ?>;">
            <h3 class="text-muted">shareical</h3>
        </div>

        <div class="row main-content">

            <div class="col-lg-6 col-lg-offset-3">
                <h4>
                    <?php echo $lang['Create shareable link']; ?>
                </h4>
                <form id="createLinkForm">
                    <div class="form-group">
                        <label for="inputIcalLink">
                            <?php echo $lang['iCal source link']; ?>
                        </label>
                        <input id="inputIcalLink" type="text" class="form-control" placeholder="https://..." />
                    </div>
                    <div class="form-group">
                        <label for="inputHeadline">
                            <?php echo $lang['Headline to be displayed above the rendered calendar']; ?>
                        </label>
                        <input id="inputHeadline" type="text" class="form-control" value="<?php echo HEADLINE_DEFAULT; ?>" />
                    </div>
                    <button type="submit" class="btn btn-default">
                        <?php echo $lang['Create link']; ?>
                    </button>
                </form>
            </div>
            <div class="col-lg-6 col-lg-offset-3" style="margin-top: 25px;">
                <h4>
                    <?php echo $lang['Share the created link']; ?>
                </h4>
                <form id="getLinkForm">
                    <div class="form-group">
                        <input id="inputShareLink" type="text" class="form-control" readonly="true" />
                    </div>
                </form>
            </div>
        </div>
        <footer class="footer">
            <small>
                Created with
                <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
                by
                <a target="_blank" href="https://berrnd.de">Bernd Bestel</a>
                <br />
                <a target="_blank" href="https://github.com/berrnd/shareical">Project page</a>
                // <?php echo file_get_contents('version.txt'); ?>
            </small>
        </footer>
    </div>

    <script src="<?php echo APP_ROOT_URL; ?>vendor/components/jquery/jquery.min.js"></script>
    <script src="<?php echo APP_ROOT_URL; ?>vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>

    <script>
        $(function () {
            $("#createLinkForm").on("submit", function (e) {
                e.preventDefault();
                var icalLink = $("#inputIcalLink").val();
                var headline = $("#inputHeadline").val();
                $.ajax({
                    'url': '<?php echo APP_ROOT_URL;?>index.php/api/create-share-link',
                    'type': 'POST',
                    'data': {
                        'icallink': icalLink,
                        'headline': headline
                    },
                    'success': function (data) {
                        $("#inputShareLink").val(data);
                        $("#inputShareLink").trigger("click");
                    },
                    'error': function (data) {
                        alert("Error: " + data.responseText);
                    }
                });
            });

            $("#inputShareLink").click(function () {
                $(this).select();
            });
        });
    </script>

</body>
</html>
