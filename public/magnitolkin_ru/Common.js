function btnSearch_Click() {
    var searchQuery = jQuery('#txtSearchQuery').val();

    if (searchQuery.length > 0)
        location.href = '/Search/?q=' + searchQuery;
}

function hideQuickSearchResults() {
    jQuery('#quicksearchresults_content').html('');
    jQuery('#quicksearchresults_count').html('');
    jQuery('#quicksearchresults').hide();
}

function getQuickSearchItems(query) {
    if (query.length < 2)
        hideQuickSearchResults();
    else {
        jQuery.getJSON(
            '/Handlers/QuickSearchRequest/?q=' + query,
            function (data) {
                var html = '';
                if (data != null && data != undefined) {
                    for (index = 0; index < data.items.length; index++) {
                        var item = data.items[index];
                        html += '<div>';
                        html += '<div style="float: left; font-size: 9px;">';
                        html += '<div class="category">' + item.category + '</div>';
                        html += '<div class="description">';
                        html += '<div class="image"><img src="/Handlers/QuickSearchShopItemImage/?id=' + item.itemId + '"/></div>';
                        html += '<div class="name"><a href="' + item.path + '">' + item.name + '</a></div>';
                        html += '<div class="price">' + item.price + ' руб. </div>';
                        html += '<div class="clearfix"></div>';
                        html += '</div>';
                        html += '</div>';
                        html += '<div class="clearfix"></div>';
                        html += '</div>';
                        if (index != data.items.length - 1)
                            html += '<div class="divider"></div>';
                    }

                    jQuery('#quicksearchresults_count').html(data.totalcount);
                    jQuery('#quicksearchresults_all').attr('href', '/search/?q=' + query).show();

                    jQuery('#quicksearchresults_content').html(html);
                    jQuery('#quicksearchresults').show();
                }
                else {
                    jQuery('#quicksearchresults_content').html('');
                    jQuery('#quicksearchresults').hide();
                }
            }
        );
    }
}

function getCartState() {
    jQuery.getJSON(
        '/Handlers/Ordering/GetCartState/',
        function (data) {
            if (data != null && data != undefined && data.quantity != '') {
                jQuery('#Cart .shop_items_count').text(data.quantity);
                jQuery('#Cart').show();
            } else {
                jQuery('#Cart').hide();
            }
        }
    );
}