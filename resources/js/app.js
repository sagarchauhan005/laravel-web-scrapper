/*
* Redirects to to the company page
* */
$(".company-item").click(function () {
    let link = $(this).attr('data-link');
    let type = $(this).attr('data-name');
    let id = $(this).attr('data-id');
    window.location.href="/get-companies?link=" + link + "&type=" + type + "&id=" + id;
});


/*
* Loads the company table
* */
let compTableElem = $(".load-companies-table");
let exist = compTableElem.length;
let noData = "<p class='alert alert-danger'>Unable to fetch data....</p>";
let table = $("#companies-table");
let companyListTable = $('#table-results');
/*
* Cleans up table and set it up
* */
function setUpTable() {
    companyListTable.html('');
    companyListTable.append('' +
        '<tr>' +
        '<th>CIN</th>' +
        '<th>Company Name</th>' +
        '<th>Class</th>' +
        '<th>Status</th>' +
        '</tr>'
    );
}
/*
* Appends each tale row result into table
* */
function appendResults(data) {
    let response = data.response;
    let size = response.length;
    if(data.response !== "null" && size>0){
        for (let i = 0; i < size; i++) {
            companyListTable.append('' +
                '<tr>' +
                    '<td>'+response[i][0]+'</td>' +
                    '<td><a href="get-business?company='+response[i][4]+'">'+response[i][1]+'</a></td>' +
                    '<td>'+response[i][2]+'</td>' +
                    '<td>'+response[i][3]+'</td>' +
                '</tr>'
            );
        }
    }else{
        companyListTable.html('<p class="alert alert-danger">No more data available....</p>')
    }
}

/*
* Fetches the data over network and perform operation in table
* */
function fetchData(link, page, totalPages, id) {
    $('.spinner-border').show();
    let pageInt = parseInt(page);
    let prev = pageInt - 1;
    let next = pageInt + 1;

    $.ajax({
        type: "GET",
        url: "/get-companies-table-by-page",
        data: {link : link, page : page, totalPages : totalPages, id : id},
        success: function(data) {
            $('.spinner-border').hide();
            if(data===undefined || data==null || data.length===0){
                table.prepend(noData);
            }else{
                //console.log(data);
                setUpTable();
                appendResults(data);
                $("#prev").attr('data-page',prev);
                $("#next").attr('data-page',next);
                $("#total-pages").text(data.total_pages);
                compTableElem.attr('data-total-pages',data.total_pages);
                $("#current-page").text(page);
            }
        },
        error: function(reject) {
            $('.spinner-border').hide();
            table.html(noData);
        }
    });
}

if(exist){
    let link = compTableElem.attr('data-link');
    let id = compTableElem.attr('data-id');
    let totalPages = compTableElem.attr('data-total-pages');
    fetchData(link, 1, totalPages, id);
}

/*
*
* Loads more company table data on click
* */
$(".loadMore").click(function () {
    let loadMore = $(this);
    let link = loadMore.attr('data-link');
    let page = loadMore.attr('data-page');
    let id = compTableElem.attr('data-id');
    let totalPages = compTableElem.attr('data-total-pages');

    //fetch data
    fetchData(link,page, totalPages, id);
});
