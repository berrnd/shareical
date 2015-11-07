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
    <link rel='stylesheet' href='<?php echo APP_ROOT_URL; ?>vendor_manually/fullcalendar/fullcalendar.css' />
</head>
<body>
    <div class="container">

        <?php if (LOGO_URL != '') : ?>
        <img style="float: left;" width="<?php echo LOGO_WIDTH; ?>" height="<?php echo LOGO_HEIGHT; ?>" src="<?php echo LOGO_URL; ?>" />
        <?php endif; ?>

        <div class="header clearfix" style="margin-top: <?php echo HEADLINE_TOP_MARGIN; ?>;">
            <h3 class="text-muted">
                <?php echo $data->headline; ?>

                <?php if (HIDE_APP_FRAME === false) : ?>
                <small>shareical</small>
                <?php endif; ?>
            </h3>
        </div>

        <div class="row main-content">

            <div class="col-lg-12">
                <div id="calendar"></div>
            </div>

        </div>

        <?php if (HIDE_APP_FRAME === false) : ?>
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
        <?php endif; ?>

    </div>

    <script src="<?php echo APP_ROOT_URL; ?>vendor/components/jquery/jquery.min.js"></script>
    <script src="<?php echo APP_ROOT_URL; ?>vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo APP_ROOT_URL; ?>vendor/moment/moment/min/moment.min.js"></script>
    <script src="<?php echo APP_ROOT_URL; ?>vendor_manually/fullcalendar/fullcalendar.min.js"></script>
    <script src="<?php echo APP_ROOT_URL; ?>vendor_manually/fullcalendar/lang-all.js"></script>
    <script src="<?php echo APP_ROOT_URL; ?>vendor_manually/ical.js/ical.min.js"></script>

    <script>
        $(function () {
            var events = new Array();

            var icalString = decodeURIComponent("<?php echo rawurlencode($data->icalcontent); ?>");
            var ical = ICAL.parse(icalString);
            var icalContentElements = ical[2];

            icalContentElements.forEach(function (icalContentElement) {
                if (icalContentElement[0] == "vevent")
                {
                    var event = new Array();

                    icalContentElement[1].forEach(function (icalEvent) {
                        if (icalEvent[0] == "dtstart")
                            event["start"] = icalEvent[3];

                        if (icalEvent[0] == "dtend")
                            event["end"] = icalEvent[3];

                        if (icalEvent[0] == "summary")
                            event["summary"] = icalEvent[3];

                        if (icalEvent[0] == "location")
                            event["location"] = icalEvent[3];
                    });

                    event["title"] = event["summary"] + " [" + event["location"] + "]";
                    events.push(event);
                }
            });

            $('#calendar').fullCalendar({
                "events": events,
                "defaultView": "<?php echo CALENDAR_VIEW; ?>",
                "allDaySlot": false,
                "minTime": "<?php echo CALENDAR_TIME_MIN; ?>",
                "maxTime": "<?php echo CALENDAR_TIME_MAX; ?>",
                "lang": "<?php echo LANGUAGE; ?>",
                "eventColor": "<?php echo CALENDAR_EVENT_COLOR; ?>"
            });
        });
    </script>

</body>
</html>
