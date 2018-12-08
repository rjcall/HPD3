var page = 1,
    sortDir = "up",
    sortCol, filter;
const PAGE_SIZE = 10;
var offset = 0;

function sortBy(column) {
    if (sortCol == column) {
        if (sortDir == "up") {
            $(".filterIcon").html("▼");

            url = 'api/v1/index.php/owners';

            var data = {
                offs: offset,
                sortColumn: column + " DESC"
            };
            sortDir = "down";

        } else if (sortDir == "down") {
            $(".filterIcon").html("▲")

            url = 'api/v1/index.php/owners';
            var data = {
                offs: offset,
                sortColumn: column
            };
            sortDir = "up";
        }
    } else {
        var data = {
            offs: offset,
            sortColumn: column
        };
        $(".filterIcon").html("▲");
        url = 'api/v1/index.php/owners';
    }
    sortCol = column;

    $.getJSON(url, data, function(data) {
        owners = data;
        fillOwners(owners);
    });
}

function filter(column) {

    var array = Array();
    var data = {
        filter: 1,
        butts: 2,
        fnamefilter: $("input[name='fnamefilter']").val(),
        lnamefilter: $("input[name='lnamefilter']").val(),
        street1filter: $("input[name='street1filter']").val(),
        street2filter: $("input[name='street2filter']").val(),
        cityfilter: $("input[name='cityfilter']").val(),
        statefilter: $("input[name='statefilter']").val(),
        zipfilter: $("input[name='zipfilter']").val(),
        policyfilter: $("input[name='policyfilter']").val(),
        expirationfilter: $("input[name='expirationfilter']").val()
    };
    url = 'api/v1/index.php/owners';
    $.getJSON(url, data, function(data) {
        owners = data;
        fillOwners(owners);
    });
}

function deleteItem(ownerId, itemId) {
    url = 'api/v1/index.php/owners/' + ownerId + '/items/' + itemId;
    $.ajax({
        url: url,
        type: 'DELETE',
        success: function(result) {
            var data = {
                offset: offset,
                sortColumn: sortCol
            };
            showItems(ownerId);
        }
    });

}


function updateItem(ownerId, itemId) {
    url = 'api/v1/index.php/owners/' + ownerId + '/items/' + itemId;
    var data = {
        name: $("input[name='upitname']").val(),
        photo: $("input[name='upitphoto']").val(),
        description: $("input[name='upitdescription']").val(),
        valuation: $("input[name='upitvaluation']").val(),
        method: $("input[name='upitmethod']").val(),
        verified: $("input[name='upitverified']").val()
    };

    $.ajax({
        url: url,
        type: 'PUT',
        success: function(result) {
            showItems(ownerId);
        },
        data: {
            ownerId: ownerId,
            itemId: itemId,
            name: data.name,
            photo: data.photo,
            valuation: data.valuation,
            method: data.method,
            verified: data.verified,
            description: data.description
        }
    });
}

function updateOwner(id) {
    fname = $("input[name='fnameupdate']").val();
    lname = $("input[name='lnameupdate']").val();
    street1 = $("input[name='street1update']").val();
    street2 = $("input[name='street2update']").val();
    city = $("input[name='cityupdate']").val();
    state = $("input[name='stateupdate']").val();
    zip = $("input[name='zipupdate']").val();
    policy = $("input[name='policyupdate']").val();
    expiration = $("input[name='expirationupdate']").val();
    $.ajax({
        url: url,
        type: 'PUT',
        success: function(result) {
            var data = {

                sortColumn: sortCol
            };
            $.getJSON('api/v1/index.php/owners', data, function(data) {
                owners = data;

                fillOwners(owners);
            });
        },
        data: {
            fname: fname,
            lname: lname,
            street1: street1,
            street2: street2,
            city: city,
            state: state,
            zip: zip,
            policy: policy,
            expiration: expiration,
            ownerId: id
        }
    });
}

function deleteOwner(ownerId) {

    url = 'api/v1/index.php/owners/' + ownerId;


    $.ajax({
        url: url,
        type: 'DELETE',
        success: function(result) {
            var data = {
                offset: offset,
                sortColumn: sortCol
            };
            $.getJSON('api/v1/index.php/owners', data, function(data) {
                owners = data;

                fillOwners(owners);
            });

        }
    });
}

function addItem(id) {
    sortCol = "notset"
    sortDir = "notset"
    url = 'api/v1/index.php/owners/' + id;
    var data = {
        name: $("input[name='name']").val(),
        photo: $("input[name='photo']").val(),
        description: $("input[name='description']").val(),
        valuation: $("input[name='valuation']").val(),
        method: $("input[name='method']").val(),
        verified: $("input[name='verified']").val()
    };
    $.post(url, data, function(data) {

        showItems(id);
    });
}

function addOwner() {
    url = 'api/v1/index.php/owners';

    var data = {
        fname: $("#fname_id").val(),
        lname: $("#lname_id").val(),
        street1: $("#street1_id").val(),
        street2: $("#street2_id").val(),
        city: $("#city_id").val(),
        state: $("#state_id").val(),
        zip: $("#zip_id").val(),
        policy: $("#policy_id").val(),
        expiration: $("#expiration_id").val()
    };
    $.post(url, data, function(data) {

        var data = {

            sortColumn: sortCol
        };
        $.getJSON('api/v1/index.php/owners', data, function(data) {
            owners = data;

            fillOwners(owners);
        });
    });
    $("#addUserForm").toggle();
}

function fillOwners(items) {

    $('#itemsTableBody').html("");
    for (let item of items) {
        console.log(item);
        $('#itemsTableBody').append(
            "<tr>" +
            '<td class="well well-sm text-justify" style="width:7%;"><span onClick="deleteOwner(' + item[0] + ')"><i class="fas fa-minus-circle" style="font-size:24px;color:red; padding-right:1em;"></i></span>' +
            '<span onClick="pUM(' + item[0] + ')" data-toggle="modal" data-target="#updateModal"><i class="fas fa-edit" style="font-size:25px;color:green;"></i></span>' +
            "<td onClick=showItems(" + item[0] + ") data-toggle='modal' data-target='#myModal'>" + item[1] + "</td>" +
            " <td onClick=showItems(" + item[0] + ") data-toggle='modal' data-target='#myModal'>" + item[2] + "</td>" +
            " <td onClick=showItems(" + item[0] + ") data-toggle='modal' data-target='#myModal'>" + item[3] + "</td>" +
            " <td onClick=showItems(" + item[0] + ") data-toggle='modal' data-target='#myModal'>" + item[4] + "</td>" +
            " <td onClick=showItems(" + item[0] + ") data-toggle='modal' data-target='#myModal'>" + item[5] + "</td>" +
            " <td onClick=showItems(" + item[0] + ") data-toggle='modal' data-target='#myModal'>" + item[6] + "</td>" +
            " <td onClick=showItems(" + item[0] + ") data-toggle='modal' data-target='#myModal'>" + item[7] + "</td>" +
            " <td onClick=showItems(" + item[0] + ") data-toggle='modal' data-target='#myModal'>" + item[8] + "</td>" +
            " <td onClick=showItems(" + item[0] + ") data-toggle='modal' data-target='#myModal'>" + item[9] + "</td>" +
            "</tr>"
        );
    }
}

function fillOJT(items) {


    $('#itemsTableBody').html("");
    for (let item of items) {
        var arr = [];
        for (var prop in item) {
            arr.push(item[prop]);
        }
        console.log(arr);
        $('#itemsTableBody').append(
            "<tr>" +
            '<td class="well well-sm text-justify" style="width:7%;"><span onClick="deleteOwner(' + arr[0] + ')"><i class="fas fa-minus-circle" style="font-size:24px;color:red; padding-right:1em;"></i></span>' +
            '<span onClick="pUM(' + arr[0] + ')" data-toggle="modal" data-target="#updateModal"><i class="fas fa-edit" style="font-size:25px;color:green;"></i></span>' +
            "<td onClick=showItems(" + arr[0] + ") data-toggle='modal' data-target='#myModal'>" + arr[1] + "</td>" +
            " <td onClick=showItems(" + arr[0] + ") data-toggle='modal' data-target='#myModal'>" + arr[2] + "</td>" +
            " <td onClick=showItems(" + arr[0] + ") data-toggle='modal' data-target='#myModal'>" + arr[3] + "</td>" +
            " <td onClick=showItems(" + arr[0] + ") data-toggle='modal' data-target='#myModal'>" + arr[4] + "</td>" +
            " <td onClick=showItems(" + arr[0] + ") data-toggle='modal' data-target='#myModal'>" + arr[5] + "</td>" +
            " <td onClick=showItems(" + arr[0] + ") data-toggle='modal' data-target='#myModal'>" + arr[6] + "</td>" +
            " <td onClick=showItems(" + arr[0] + ") data-toggle='modal' data-target='#myModal'>" + arr[7] + "</td>" +
            " <td onClick=showItems(" + arr[0] + ") data-toggle='modal' data-target='#myModal'>" + arr[8] + "</td>" +
            " <td onClick=showItems(" + arr[0] + ") data-toggle='modal' data-target='#myModal'>" + arr[9] + "</td>" +
            "</tr>"
        );
    }
}

function populateModal(ownerId, items) {

    $('#modalTableBody').html("");
    for (let item of items) {
        $('#modalTableBody').append(+item[0] +
            "<tr>" +
            '<td><span onClick="pUIM(' + ownerId + ',' + item[0] + ')"data-toggle=\'modal\' data-target=\'#updateItemModal\'><i class="fa fa-pencil-square\" style="font-size:25px;color:orange;"></i></span>' +
            '<br><span onClick="deleteItem(' + ownerId + ',' + item[0] + ')"><i class="fa fa-trash" style="font-size:24px;color:blue;"aria-hidden="true"></i></td></span>' +
            "<td>" + item[1] + "</td>" +
            "<td><img src='" + item[2] + "' class='img-thumbnail myimg'></td>" +
            "<td>" + item[3] + "</td>" +
            "<td>" + item[4] + "</td>" +
            "<td>" + item[5] + "</td>" +
            "<td>" + item[6] + "</td>" +
            "</tr>");
    }
    $('#modalTableBody').append(
        '<tr>' +
        '<td><button onClick = \"addItem(' + ownerId + ')\">ADD</button></td>' +
        "<td><input type='text' size='5' name=name value=''></td>" +
        "<td><input type='text' size='5' name=photo value=''></td>" +
        "<td><input type='text' size='5' name=description value=''></td>" +
        "<td><input type='text' size='5' name=valuation value=''></td>" +
        "<td><input type='text' size='5' name=method value=''></td>" +
        "<td><input type='text' size='1' name=verified value=''></td>" +
        '</tr>');
}

function pUM(id) {
    url = 'api/v1/index.php/owners/' + id;
    $.getJSON(url, function(data) {

        items = data;
        $('#updateModalTableBody').html("");
        for (let item of items) {
            $('#updateModalTableBody').append(
                "<tr>" +
                "<td><input type='text' size='5' name=fnameupdate value='" + item[1] + "'></td>" +
                "<td><input type='text' size='5' name=lnameupdate value='" + item[2] + "'></td>" +
                "<td><input type='text' size='5' name=street1update value='" + item[3] + "'></td>" +
                "<td><input type='text' size='5' name=street2update value='" + item[4] + "'></td>" +
                "<td><input type='text' size='5' name=cityupdate value='" + item[5] + "'></td>" +
                "<td><input type='text' size='1' name=stateupdate value='" + item[6] + "'></td>" +
                "<td><input type='text' size='5' name=zipupdate value='" + item[7] + "'></td>" +
                "<td><input type='text' size='5' name=policyupdate value='" + item[8] + "'></td>" +
                "<td><input type='text' size='5' name=expirationupdate value='" + item[9] + "'></td>" +
                "</tr><tr>");
        }
        $('#updateModalTableBody').append("<button type='button' class='btn btn-secondary' data-dismiss='modal' onClick='updateOwner(\"" +
            id + "\")'>Save</button>" +
            "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button></tr>");
    });
}

function pUIM(ownerId, itemId) {
    url = 'api/v1/index.php/owners/' + ownerId + '/items/' + itemId;
    $.getJSON(url, function(data) {

        items = data;
        $('#updateItemModalTableBody').html("");
        for (let item of items) {
            $('#updateItemModalTableBody').append(
                '<tr>' +
                "<td><input type='text' size='5' name=upitname value='" + item[1] + "'></td>" +
                "<td><input type='text' size='5' name=upitphoto value='" + item[2] + "'></td>" +
                "<td><input type='text' size='5' name=upitdescription value='" + item[3] + "'></td>" +
                "<td><input type='text' size='5' name=upitvaluation value='" + item[4] + "'></td>" +
                "<td><input type='text' size='5' name=upitmethod value='" + item[5] + "'></td>" +
                "<td><input type='text' size='1' name=upitverified value='" + item[6] + "'></td>" +
                '</tr>');

            name = $("input[name='nameupdate']").val();
            photo = $("input[name='photoupdate']").val();
            description = $("input[name='descriptionupdate']").val();
            valuation = $("input[name='valuationupdate']").val();
            method = $("input[name='methodupdate']").val();
            verified = $("input[name='verifiedupdate']").val();

            $('#updateItemModalTableBody').append("<button type='button' class='btn btn-secondary' data-dismiss='modal' onClick='updateItem(\"" +
                ownerId + '\",\"' +
                item[0] + "\")'>Save</button>" +
                "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button></tr>");
        }


    });
}



function showItems(id) {


    $(document).ready(function() {
        url = 'api/v1/index.php/owners/' + id + "/items";
        $.getJSON(url, function(data) {

            items = data;
            console.log(items);
            populateModal(id, items);
        });
    });

}

function showOwners() {
    $.getJSON('api/v1/index.php/owners', function(data) {
        owners = data;

        fillOwners(owners);
    });
}

$(document).ready(function() {
    showOwners();
});

function nextP() {

    offset = page * PAGE_SIZE;
    page++;
    var obj, dbParam, xmlhttp, myObj, x, txt = "";
    if (sortCol == undefined) {
        sortCol = "NOTSET";
    }
    obj = { "table": "owners", "limit": 10, "offset": offset, "sort": sortCol, "sort_dir": sortDir };
    dbParam = JSON.stringify(obj);
    console.log("DB parameters" + dbParam);
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            myObj = JSON.parse(this.responseText);
            console.log(myObj);
            fillOJT(myObj);
        }
    };
    xmlhttp.open("GET", "api/v1/json_s.php?x=" + dbParam, true);
    xmlhttp.send();

}

function lastP() {
    if (page == 1)
        offset = 0;
    else {
        page -= 2;
        offset = page * PAGE_SIZE;
        page++;
    }
    var obj, dbParam, xmlhttp, myObj, x, txt = "";

    if (sortCol == undefined) {
        sortCol = "NOTSET";
    }
    obj = { "table": "owners", "limit": 10, "offset": offset, "sort": sortCol, "sort_dir": sortDir };
    dbParam = JSON.stringify(obj);
    console.log("DB parameters" + dbParam);
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            myObj = JSON.parse(this.responseText);
            console.log(myObj);
            fillOJT(myObj);
        }
    };
    xmlhttp.open("GET", "api/v1/json_s.php?x=" + dbParam, true);
    xmlhttp.send();

}