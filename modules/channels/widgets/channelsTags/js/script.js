$(document).ready(function()
{
    var tags = new Bloodhound({
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        datumTokenizer: Bloodhound.tokenizers.whitespace('name'),
        remote: {
            url: '/web/index.php?r=channels/ajax/tags&tag-name=%QUERY',
            wildcard: '%QUERY',
            filter: function (movies) {
                // Map the remote source JSON array to a JavaScript object array
                return $.map(movies, function (movie) {
                    return {
                        name: movie.name
                    };
                });
            }
        }
    });
    tags.initialize();

    $('#channels_tags_container > input').tagsinput({
        typeaheadjs: {
            name: 'tags',
            displayKey: 'name',
            valueKey: 'name',
            source: tags.ttAdapter(),
            limit:10
        }
    });
});