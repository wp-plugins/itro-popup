<?php
/*
Copyright 2013  I.T.RO.® Corp  (email : support.itro@live.com)
This file is part of ITRO Popup Plugin.

    ITRO Popup Plugin is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    ITRO Popup Plugin is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with ITRO Popup Plugin.  If not, see <http://www.gnu.org/licenses/>.
*/
	
//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) exit ();

mysql_query("DROP TABLE IF EXIST wp_itro_plugin_option,wp_itro_plugin_field");

?>