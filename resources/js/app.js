/*
* Redirects to to the company page
* */
$(".company-item").click(function () {
    let link = $(this).attr('data-link');
    let type = $(this).attr('data-name');
    let url = "/get-companies?link="+link+"&type="+type;
    window.location.href=url;
});


/*
* Loads the company table
* */
let compTableElem = $(".load-companies-table");
let exist = compTableElem.length;
let noData = "<p class='alert alert-danger'>Unable to fetch data....</p>";
let table = $("#companies-table");

/*
* Fetches the data over network and perform operation in table
* */
function fetchData(link, page) {
    $('.spinner-border').show();
    let pageInt = parseInt(page);
    let prev = pageInt - 1;
    let next = pageInt + 1;

    $.ajax({
        type: "GET",
        url: "/get-companies-table-by-page",
        data: {link : link, page : page},
        success: function(data) {
            $('.spinner-border').hide();
            if(data===undefined || data==null || data.length===0){
                table.prepend(noData);
            }else{
                table.html(data);
                $("#prev").attr('data-page',prev);
                $("#next").attr('data-page',next);
                $("#total-pages").text($('#table-results').attr('data-pages'));
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
    fetchData(link, 1);
}

/*
*
* Loads more company table data on click
* */
$(".loadMore").click(function () {
    let loadMore = $(this);
    let link = loadMore.attr('data-link');
    let page = loadMore.attr('data-page');

    //fetch data
    fetchData(link,page);
});
