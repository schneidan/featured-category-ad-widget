/**
 * This file is part of Featured Category Ad Widget
 * Last revised at version 0.1
 *
 * Copyright 2009-2013  Edward Caissie  (email : edward.caissie@gmail.com)
 *
 * BNS Featured Category is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * You may NOT assume that you can use any other version of the GPL.
 *
 * BNS Featured Category is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, write to:
 *
 *      Free Software Foundation, Inc.
 *      51 Franklin St, Fifth Floor
 *      Boston, MA  02110-1301  USA
 */
jQuery(document).ready(function($) {
    // Note: $() will work as an alias for jQuery() inside of this function
    $("p.fcad-display-all-posts-check input.checkbox").click(function () {
        $(".fcad-all-options-open").toggleClass("fcad-all-options-closed");
    });

    $("p.fcad-display-thumbnail-sizes input.checkbox").click( function(){
        $(".fcad-thumbnails-open").toggleClass("fcad-thumbnails-closed");
    });

    $("p.fcad-excerpt-option-open-check input.checkbox").click( function(){
        $(".fcad-excerpt-option-open").toggleClass("fcad-excerpt-option-closed");
    });
});