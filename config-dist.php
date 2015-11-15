<?php

//Application base url with an trailing slash
define('APP_ROOT_URL', 'http://localhost:54452/');

//You need to set this to TRUE if you don't use HTTPS - but why should you do this?
define('INSECURE', false);

//Possible values: en, de
define('LANGUAGE', 'en');

//Authentication for backend (generating share urls), leave empty to disable authentication
define('BACKEND_USER', 'admin');
define('BACKEND_PASSWORD', 'admin');

//Proposed value for the headline
define('HEADLINE_DEFAULT', 'Calendar for ');

//Length of the data-part of the generated URLs
define('URL_LENGTH', 32);

//Default calendar view type, for possible values see http://fullcalendar.io/docs/views/Available_Views
define('CALENDAR_VIEW', 'agendaWeek');

//For day and week views, the start time of the day, appointments before this time will not be displayed
define('CALENDAR_TIME_MIN', '06:00:00');

//For day and week views, the start time of the day, appointments after this time will not be displayed
define('CALENDAR_TIME_MAX', '23:00:00');

//Background color of events in the calendar view
define('CALENDAR_EVENT_COLOR', "#2B2E73");

//URL to an image used in the upper left corner, can be either a relative or absoulte url, or empty if you don't need a logo
define('LOGO_URL', '');

//Logo size
define('LOGO_HEIGHT', '80');
define('LOGO_WIDTH', '80');

//Top space of the headline if you want to arrange it with your logo
define('HEADLINE_TOP_MARGIN', "0px");

//Show application frame (footer and header) on the calendar view site or not
define('HIDE_APP_FRAME', false);

?>