$(document).ready(function() {
    $(".btn-success, .btn-danger").click(function() {
        var bookId = $(this).data("book-id");
        var action = $(this).data("action");
        var voteCount = parseInt($(".book-card[data-book-id='" + bookId + "']").data("votes"));

        $.ajax({
            url: "vote.php",
            type: "POST",
            data: {
                book_id: bookId,
                action: action, 
                current_votes: voteCount
            },
            success: function(response) {
                var data = JSON.parse(response);
                $(".book-card[data-book-id='" + bookId + "'] .vote-count").text(data.total_votes);
                $(".book-card[data-book-id='" + bookId + "']").data("votes", data.total_votes);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
        
    });
});