/**
 * Created using PhpStorm.
 * Author: Josh Pacheco <joshua.pacheco@gmail.com>
 * Project: AnimalDemo
 * Date: 3/27/2016
 *
 * TODO This code needs to be refactored to utilize more consistency between JQuery operations and Classic JavaScript operations
 * TODO All ajax methods should be in their own library
 * TODO This also needs to be refactored to abstract out repeated code
 * TODO This should also be be examined to reduce C.R.A.P. where possible
 */

$(document).ready(function() {
    // Declare 'global' variables
    var dropListData = null;
    var page = null;
    var limit = null;
    var total = null;
    var results = null;
    var selections = null;
    var timeOutValue = 10000;

    //poll(); // This is caused me to be kicked off of my doman, need to keep off for now
    init(page); // Kick off the whole process

    /**
     * This is also used in a callback which is why I placed the start of all operations in a function
     */
    function init(p) {
        // Now set 'global' variables to have default values
        dropListData = {};
        if (isNaN(p)) {
            page = 1;
        } else {
            page = (p == null) ? 1 : p;
        }

        limit = 3;
        total = 0;
        results = [];
        selections = [];

        // Call api and pull all needed drop list data first
        $.get('api/index.php?route=lists', function(results) {
            dropListData = jQuery.parseJSON(results); // Store droplist data in 'global'
            // Call api to get the total count of all records (needed for pagination
            $.get('api/index.php?route=count', showList);
        });
    }

    /**
     * This starts operations to get the animal list data from the api
     * @param {string} results
     */
    function showList(results) {
        results = jQuery.parseJSON(results);
        if (results[0].Total > total) { // TODO figure out a way to deal with magic number
            total = results[0].Total; // Set count of all records to 'global'
            // Call api to get the a list of animals (will be limited to set threshold)
            var p = 0;
            if (page != 1) {
                p = page;
            }
            $.get('api/index.php?route=list&offset=' + (p * limit) + '&limit=' + limit, showListResults);
        } else {
            // TODO Place in some sort of message that no results were found
        }
    }

    /**
     * Take results from api and construct a table within the DOM for display
     * @param {string} results
     */
    function showListResults(results) {
        $("#resultsTable").remove(); // Remove any prior results

        // Start building the results table
        var t = document.createElement('table');
        t.id = "resultsTable";
        results = jQuery.parseJSON(results);
        // Loop though each record and create rows
        $.each(results, function (index, result) {
            var r = document.createElement('tr');

            $(r).click(function () {
                // Api call to pull details on a specific record
                $.get('api/index.php?route=details&ID=' + result.ID, showDetails);
            });

            // Loop though each value within a record to populate a cell
            for (var i in result) {
                if (i != 'ID' && result.hasOwnProperty(i)) { // Don't show id numbers
                    var c = document.createElement('td');
                    $(c).text(result[i]);
                    $(r).append(c);
                }
            }
            $(t).append(r);
        });

        // Set finished table to list container
        $("#animalList").append(t);

        if (total > limit) {
            // If the total number of records is greater than the limit, show the navigation
            showNav();
        }
    }

    /**
     * Build navigation based on state of results
     * TODO Abstract out next and back into one common function
     */
    function showNav() {
        $("#listNavContainer").remove(); // Remove prior navigation display (this is a brute force approach but sufficient for demonstration purposes)
        var left = document.createElement('span');

        var navLeft = null;
        if (page == 1) { // If user is on the first page, just display the text of the navigation controls for back
            navLeft = (total > (limit * 2)) ? " << < " : " < "; // Show controls based on number of results found
            $(left).text(navLeft);
        } else { // If use is on a subsequent page, the left navigation controls must now become clickable

            // Left double
            var leftDouble = document.createElement('span');
            leftDouble.innerHTML = "&lt;&lt;&nbsp;";
            $(leftDouble).click(function() {
                // Call api to pull first result set (user wishes to go back to the start)
                $.get('api/index.php?route=list&offset=0&limit=' + limit, showListResults);
                page = 1;
            });

            left.className = 'nav_controls';
            $(left).append(leftDouble);

            // Left single
            var leftSingle = document.createElement('span');
            leftSingle.innerHTML = "&nbsp;&lt;&nbsp;";
            $(leftSingle).click(function() {
                // Call api and paginate back one page
                $.get('api/index.php?route=list&offset=' + (page * limit) + '&limit=' + limit, showListResults);
                page--;
            });
            $(left).append(leftSingle);
        }

        var pagination = document.createElement('span');
        var lastPage = Math.ceil(total / limit);
        $(pagination).text("Page " + page + " of " + lastPage + " "); // Show user where they are at in the navigation

        var right = document.createElement('span');

        var navRight = null;

        if (page == lastPage) { // If user is on the last page, just display the text of the navigation controls for next
            navRight = (total > (limit * 2)) ? " > >> " : " > "; // Show controls based on number of results found
            $(right).text(navRight);
        } else { // If use is on a subsequent page, the right navigation controls must now become clickable

            // Right double
            var rightSingle = document.createElement('span');
            rightSingle.innerHTML = "&gt;&nbsp;";
            $(rightSingle).click(function() {
                // Call api to pull last result set (user wishes to go the end)
                $.get('api/index.php?route=list&offset=' + (page * limit) + '&limit=' + limit, showListResults);
                page++;
            });
            $(right).append(rightSingle);

            var rightDouble = document.createElement('span');

            // Right single
            rightDouble.innerHTML = "&nbsp;&gt;&gt;";
            var lastRecord = total - (lastPage - limit);
            $(rightDouble).click(function() {
                // Call api and paginate ahead back one page
                $.get('api/index.php?route=list&offset=' + lastRecord + '&limit=' + limit, showListResults);
                page = (lastPage - 1);
            });

            right.className = 'nav_controls';
            $(right).append(rightDouble);
        }

        // Build up navigation
        var d = document.createElement('div');
        d.id = "listNavContainer";

        $(d).append(left)
            .append(pagination)
            .append(right);

        $("#animalDetails").toggleClass('visible').append(d);
        $("#page").removeClass('hidden').addClass('visible');
        $("#loading").removeClass('visible').addClass('hidden')
    }

    /**
     * Takes api results and creates a modal of all details within the record
     * @param {string} results
     * TODO This can probably be abstracted out to be shared by display, edit, and add
     */
    function showDetails(results) {
        if (results) {
            results = jQuery.parseJSON(results);
            $("#modal").remove(); // Remove any prior modal

            // Build up display table for details
            var t = document.createElement('table');
            t.width = '100%';
            var r = null;
            t.id = 'detailsTable';
            var select = []; // Holder for select objects
            // Loop though results and build up table
            $.each(results, function (index, result) {
                if (index == 'ID') {
                    return; // Do not show id data
                }

                r = document.createElement('tr');
                var c = document.createElement('td');
                c.className = 'labels';
                var valueSpan = document.createElement('span'); // Span to hold text values for read only view
                if (index == 'Description') { // Additional manipulation of the DOM is needed for the description field
                    $(c).append(index + "<br />");
                    var s = document.createElement('span'); // This span will hold the edit control
                    $(s).click(function () {
                        // When clicked, swap out read only text for a textarea box with the text now inside
                        var t = document.createElement('textarea');
                        t.id = index;
                        var cell = document.getElementById('SpanDescription');
                        t.value = cell.innerHTML.replace(/<br>/gm, "\n"); // Convert br to \n
                        cell.innerHTML = "";
                        cell.appendChild(t);

                        // With edits, the characteristic values need to be swapped out for their drop lists
                        $.each(dropListData, function(key, values) {
                            var selectId = '#' + key;
                            var spanId = '#Span' + key;
                            $(selectId).removeClass('hidden').addClass('visible');
                            $(spanId).removeClass('visible').addClass('hidden');
                        });

                        $("#Cancel").toggleClass('visible');
                        $("#Submit").removeClass('hidden').addClass('visible');
                    });
                    s.className = 'edit';
                    $(s).text('Edit Description');
                    $(c).append(s);

                    valueSpan.id = 'Span' + index;
                    valueSpan.innerHTML = result.toString().replace(/\n/g, "<br />"); // Convert any \n into br
                } else {
                    if (index != 'Name') { // Do not allow user to edit the name of the animal

                        // Create drop lists
                        var option = null;
                        select[index] = document.createElement('select');
                        select[index].id = index;
                        var dropLists = dropListData[index];

                        // Populate drop lists
                        $.each(dropLists, function (i, dropList) {
                            option = document.createElement('option');
                            option.value = eval("dropList."+ index + 'ID');
                            option.innerHTML = dropList.Label;
                            if (dropList.Label == result) {
                                option.selected = true; // Be sure that current value is selected
                                selections[index] = option.value;
                            } else {
                                if (!selections[index]) {
                                    selections[index] = option.value;
                                }
                            }

                            $(select[index]).change(function() {
                                // When a new selection is made, store this
                                selections[index] = $(this).val();
                            });

                            $(select[index]).append(option);
                        });
                        $(select[index]).addClass('hidden');
                        $(c).text(index); // Set read only text
                    }

                    valueSpan.id = 'Span' + index;
                    valueSpan.innerHTML = result;
                }

                // Label cells
                $(c).attr({ width: '1%'});
                $(r).append(c);

                // Values cells
                c = document.createElement('td');
                c.id = 'Cell' + index;
                $(c).append(valueSpan);

                if (select.hasOwnProperty(index)) {
                    $(c).append(select[index]); // Attach drop lists to value cells
                }

                $(c).attr({ width: '99%'});
                $(r).append(c);
                $(t).append(r);
            });

            // Create button controls //

            // TODO these should be in their own calls or better yet, abstracted out into one call

            // Close button
            var input = document.createElement('input');
            input.type = 'button';
            input.value = 'Close';
            $(input).click(function() {
                // Close modal without saving any changes
                $("#modal").remove();
                $("#overlay").remove();
            });
            c = document.createElement('td');
            c.colSpan = 2;
            $(c).append(input);

            // Cancel button
            input = document.createElement('input');
            input.value = 'Cancel';
            input.type = 'button';
            input.id = 'Cancel';
            input.className = 'hidden';
            $(input).click(function() {
                // Abandon any edits and restore model to original read only state
                restore(null);
            });
            $(c).append(input);

            // Submit button
            input = document.createElement('input');
            input.value = 'Submit';
            input.type = 'button';
            input.id = "Submit";
            input.className = 'hidden';
            $(input).click(function() {
                var params = {
                    ID: results.ID,
                    Description : $("#Description").val()
                };

                // Dynamically populate params
                for (var n in selections) {
                    if (selections.hasOwnProperty(n)) {
                        params[n] = selections[n];
                    }
                }

                // Call api and submit edited contents to the database
                $.post('api/index.php?route=update', params, restore);
            });
            $(c).append(input);

            // Delete button
            input = document.createElement('input');
            input.value = 'Delete';
            input.type = 'button';
            input.id = "Delete";
            input.className = 'visible';
            $(input).click(function() {
                // First warn the user
                var yes = confirm("Are you sure?");
                if (yes == true) {
                    // Call api and delete selected record
                    $.post('api/index.php?route=delete', {
                        ID: results.ID
                    }, init);

                    $("#modal").remove();
                    $("#overlay").remove();
                } else {
                    restore(null);
                }
            });
            $(c).append(input);
            $(c).attr({nowrap : 'true'});
            $(c).addClass('navbuttons');

            $(c).addClass('center');

            r = document.createElement('tr');
            $(r).append(c);
            $(t).append(r);

            var overLay = document.createElement('div');
            overLay.id = 'overlay';
            $('body').append(overLay);

            var modal = document.createElement('div');
            modal.id = 'modal';
            $(modal).append(t);
            $("#animalDetails").append(modal);
        }
    }

    // Set event for adding new animal
    // TODO this belongs in a method or even better, abstracted as part of the method above
    $("#addAnimal").click(function() {
        // Similar to edit in construction...

        var t = document.createElement('table');
        t.width = '100%';
        t.id = 'detailsTable';

        var r = document.createElement('tr');
        var c = document.createElement('td');
        // Name will be an input text box so it must be handled on its own first
        c.className = 'labels';
        $(c).text('Name');
        $(r).append(c);

        c = document.createElement('td');
        var input = document.createElement('input');
        input.id = 'Name';
        input.type = 'text';
        $(c).append(input);
        $(r).append(c);
        $(t).append(r);

        var select = [];
        // Loop though drop list data and build up drop lists
        $.each(dropListData, function(label, values) {
            var r = document.createElement('tr');
            var c = document.createElement('td');
            c.className = 'labels';

            var option = null;
            select[label] = document.createElement('select');

            // Loop tough drop list values to pull proper kes and values
            $.each(values, function (i, dropList) {
                if (i == 0) { // Only set select attributes on the first pass
                    $.each(dropList, function (propName, obj) {
                        if (!isNaN(parseFloat(obj))) {
                            select[label].id = propName;
                            selections[label] = obj;
                            return false;
                        }
                    });
                }

                // Append options
                option = document.createElement('option');
                option.value = eval("dropList."+ label + 'ID');
                option.innerHTML = dropList.Label;
                $(select[label]).append(option);
            });
            $(select[label]).addClass('visible');
            $(select[label]).change(function() {
                // When a new selection is made, store this
                selections[label] = $(this).val();
            });

            // Create label cells
            $(c).text(label);
            $(c).attr({ width: '1%'});
            $(r).append(c);

            c = document.createElement('td');
            if (select.hasOwnProperty(label)) {
                $(c).append(select[label]);
            }

            // Create value cells
            $(c).attr({ width: '99%'});
            $(r).append(c);
            $(t).append(r);
        });

        r = document.createElement('tr');
        c = document.createElement('td');

        // Description comes last and it must be handled separately since it is a textarea
        c.className = 'labels';
        $(c).text('Description');
        $(r).append(c);
        c = document.createElement('td');
        var textarea = document.createElement('textarea');
        textarea.id = 'Description';
        $(c).append(textarea);
        $(r).append(c);
        $(t).append(r);

        // Create button controls //

        // TODO these should be in their own calls or better yet, abstracted out into one call

        // Close button
        r = document.createElement('tr');
        input = document.createElement('input');
        input.type = 'button';
        input.value = 'Close';
        $(input).click(function() {
            // Close modal without saving any changes
            $("#modal").remove();
            $("#overlay").remove();
        });
        c = document.createElement('td');
        c.colSpan = 2;
        $(c).append(input);
        $(c).attr({ nowrap : 'true' });
        $(c).addClass('navbuttons');

        // Add button
        input = document.createElement('input');
        input.value = 'Add';
        input.type = 'button';
        input.id = "Add";
        $(input).click(function() {
            var params = {
                Name : $('#Name').val(),
                Description : $("#Description").val()
            };

            // Dynamicly populate params
            for (var n in selections) {
                if (selections.hasOwnProperty(n)) {
                    params[n] = selections[n];
                }
            }

            // Call api and add new record
            $.post('api/index.php?route=add', params);
            $("#modal").remove();
            $("#overlay").remove();
        });
        c.colSpan = 2;
        $(c).addClass('center');
        $(c).append(input);
        $(r).append(c);
        $(t).append(r);

        var overLay = document.createElement('div');
        overLay.id = 'overlay';
        $('body').append(overLay);

        var modal = document.createElement('div');
        modal.id = 'modal';
        $(modal).append(t);
        $("#animalDetails").append(modal);
    });

    /**
     * Restore a modal back to read only
     */
    function restore(results) {
        var cell = document.getElementById('SpanDescription');
        var desc = $("#Description");
        if (desc.val()) { // If a description exists, change all \n back to br
            cell.innerHTML = desc.val().replace(/\n/g, "<br />");
        }
        $("#Cancel").removeClass('visible').addClass('hidden');
        $("#Submit").removeClass('visible').addClass('hidden');

        if (results) {
            // Loop though dropListData and hide drop lists, show text values
            $.each(dropListData, function (key, values) {
                var selectId = '#' + key;
                var selectedOption = selectId + ' option:selected';
                var spanId = '#Span' + key;

                $(selectId).removeClass('visible').addClass('hidden');
                $(spanId).text($(selectedOption).text());
                $(spanId).removeClass('hidden').addClass('visible');
            });
        } else {
            // Loop though dropListData and hide drop lists, show text values
            $.each(dropListData, function (key, values) {
                var selectId = '#' + key;
                var spanId = '#Span' + key;
                $(selectId).removeClass('visible').addClass('hidden');
                $(spanId).removeClass('hidden').addClass('visible');
            });
        }

    }

    /**
     * Polling for dynamic viewing
     * NOTE!!! This caused me to be booted from my web server, do not use!
     */
    //function poll() {
    //    $.ajax({
    //        url: "api/index.php?route=list",
    //        type: "GET",
    //        success: function(data) {
    //            init(page);
    //        },
    //        dataType: "json",
    //        complete: setTimeout(function() {poll()}, timeOutValue),
    //        timeout: timeOutValue
    //    })
    //}
});
