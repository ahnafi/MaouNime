
function getQueryParam(name) {
    let urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}

function fetchAnime(url,params, onSuccess, onError) {
    $.ajax({
        url: `https://api.jikan.moe/v4/anime${url}`,
        method: 'GET',
        data: params,
        success: function(response) {
            onSuccess(response);
        },
        error: function() {
            onError();
        }
    });
}