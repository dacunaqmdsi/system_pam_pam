$(document).ready(function() {
    // Search functionality
    $('#searchInput').on('keyup', function() {
        var searchTerm = $(this).val().toLowerCase(); // Get the search input, convert to lowercase
        $('.asset-item').each(function() {
            var itemName = $(this).find('h3').text().toLowerCase(); // Get the asset name and convert to lowercase
            if (itemName.includes(searchTerm)) {
                $(this).show(); // Show item if it matches search
            } else {
                $(this).hide(); // Hide item if it doesn't match
            }
        });
    });

    // Show all items
    $('#filterAll').on('click', function() {
        $('.asset-item').show();
    });

    // Filter items by category
    $('.category-filter').on('click', function() {
        var categoryId = $(this).data('category_id');
        
        // Hide all items and show only the ones matching the selected category
        $('.asset-item').each(function() {
            var itemCategoryId = $(this).data('category_id');
            if (categoryId == itemCategoryId) {
                $(this).fadeIn();
            } else {
                $(this).fadeOut();
            }
        });
    });
});